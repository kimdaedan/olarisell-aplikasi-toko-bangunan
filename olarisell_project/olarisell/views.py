from django.shortcuts import render
from rest_framework import viewsets
from .models import Product  # Pastikan ini benar
from .serializers import ProductSerializer

class ProductViewSet(viewsets.ModelViewSet):
    queryset = Product.objects.all()  # Mengambil semua produk
    serializer_class = ProductSerializer

def index(request):
    products = Product.objects.all()  # Ambil semua produk
    return render(request, 'olarisell/index.html', {'products': products})  # Kirim produk ke template