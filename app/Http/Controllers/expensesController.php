<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpensesController extends Controller
{
    /**
     * Guzzle HTTP Client instance.
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * API endpoint for expenses in Django.
     * @var string
     */
    protected $apiEndpoint = 'gudang/pengeluaran/'; // As per your request

    public function __construct()
    {
        // Initialize the Guzzle Client for all methods in this controller
        $this->client = new Client(['base_uri' => 'http://127.0.0.1:8000/api/']);
    }

    /**
     * Display a paginated list of expenses with filtering.
     */
    public function index(Request $request)
    {
        try {
            $queryParams = [
                'page' => $request->input('page', 1),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ];

            $response = $this->client->get($this->apiEndpoint, [
                'query' => array_filter($queryParams)
            ]);

            $data = json_decode($response->getBody()->getContents());

            $expenses = new LengthAwarePaginator(
                $data->results ?? [],
                $data->count ?? 0,
                25, // Match this with your Django pagination setting
                $queryParams['page'],
                ['path' => $request->url(), 'query' => $request->query()]
            );

            $grandTotal = $data->grand_total ?? 0;
        } catch (\Exception $e) {
            Log::error('Failed to fetch expenses from Django: ' . $e->getMessage());
            $expenses = new LengthAwarePaginator([], 0, 25);
            $grandTotal = 0;
            return back()->with('error', 'Failed to connect to the API server. Please ensure the Django server is running.');
        }

        return view('expenses.index', compact('expenses', 'grandTotal'));
    }

    /**
     * Show the form for creating a new resource.
     * In this case, the form is on the index page, so we redirect.
     */
    public function create()
    {
        return redirect()->route('expenses.index');
    }

    /**
     * Store a newly created expense in the Django API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        try {
            $this->client->post($this->apiEndpoint, [
                'json' => [
                    'date' => $request->date,
                    'category' => $request->category,
                    'amount' => $request->amount,
                    'payment_status' => $request->status,
                ]
            ]);
            return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add expense to Django: ' . $e->getMessage());
            return back()->with('error', 'Failed to save data to the server.');
        }
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit($id)
    {
        try {
            // Fetch the specific expense from the API
            $response = $this->client->get($this->apiEndpoint . $id . '/');
            $expense = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error("Failed to fetch expense (ID: {$id}): " . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'The requested expense was not found.');
        }
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified expense in the Django API.
     */
    public function update(Request $request, $id)
    {
        // Validasi hanya untuk status
        $request->validate([
            'status' => 'required|string|in:paid,unpaid',
        ]);

        try {
            // Kirim HANYA payment_status ke API
            $this->client->put($this->apiEndpoint . $id . '/', [
                'json' => [
                    'payment_status' => $request->status,
                ]
            ]);
            return redirect()->route('expenses.index')->with('success', 'Status pengeluaran berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui pengeluaran (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Remove the specified expense from the Django API.
     */
    public function destroy($id)
    {
        try {
            $this->client->delete($this->apiEndpoint . $id . '/');
            return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to delete expense (ID: {$id}): " . $e->getMessage());
            return back()->with('error', 'Failed to delete data.');
        }
    }

    /**
     * Export expenses data to a PDF file.
     */
    public function exportPdf(Request $request)
    {
        try {
            $queryParams = [
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ];

            // Fetch all data (without pagination) from the API to render in the PDF
            $response = $this->client->get($this->apiEndpoint, [
                'query' => array_filter($queryParams)
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $expenses = isset($responseData['results']) ? $responseData['results'] : $responseData;

            $pdf = Pdf::loadView('expenses.pdf', compact('expenses'));
            return $pdf->download('expenses-report.pdf');
        } catch (\Exception $e) {
            Log::error('Failed to export expenses PDF: ' . $e->getMessage());
            return redirect()->route('expenses.index')->with('error', 'Failed to create PDF report.');
        }
    }
}
