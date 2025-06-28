<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    protected $client;

    public function __construct()
    {
        // Inisialisasi Guzzle Client dengan base URI ke API Django Anda
        $this->client = new Client(['base_uri' => 'http://127.0.0.1:8000/api/']);
    }

    /**
     * Menampilkan daftar semua customer dengan fungsionalitas pencarian.
     */
    public function index(Request $request)
    {
        $customers = [];
        try {
            // Menyiapkan parameter query untuk dikirim ke API
            $queryParams = [
                'search' => $request->input('search')
            ];

            // Mengambil data dari endpoint dengan parameter query
            // Guzzle akan membuat URL menjadi /api/customers/?search=...
            $response = $this->client->get('customers/', [
                'query' => array_filter($queryParams) // array_filter untuk menghapus parameter kosong
            ]);

            $customers = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data customer dari Django: ' . $e->getMessage());
            // Kembali ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Gagal menghubungi API Django.');
        }

        // Menampilkan view dengan data yang didapat
        return view('customers.index', compact('customers'));
    }

    /**
     * Menampilkan form untuk membuat customer baru.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Menyimpan customer baru ke API Django.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        try {
            $this->client->post('customers/', ['json' => $request->all()]);
            return redirect()->route('customers.index')->with('success', 'Customer baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambah customer ke Django: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan data customer ke server.');
        }
    }

    /**
     * Menampilkan form untuk mengedit customer.
     */
    public function edit($id)
    {
        $customer = null;
        try {
            $response = $this->client->get("customers/{$id}/");
            $customer = json_decode($response->getBody()->getContents());
        } catch (\Exception $e) {
             Log::error("Gagal mengambil data customer (ID: {$id}) dari Django: " . $e->getMessage());
            return redirect()->route('customers.index')->with('error', 'Gagal mengambil data customer dari server.');
        }
        return view('customers.edit', compact('customer'));
    }

    /**
     * Mengupdate data customer di API Django.
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
        ]);

        try {
            $this->client->put("customers/{$id}/", ['json' => $request->all()]);
            return redirect()->route('customers.index')->with('success', 'Data customer berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui customer (ID: {$id}) di Django: " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data customer.');
        }
    }

    /**
     * Menghapus data customer dari API Django.
     */
    public function destroy($id)
    {
        try {
            $this->client->delete("customers/{$id}/");
            return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus customer (ID: {$id}) di Django: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus customer.');
        }
    }
}
