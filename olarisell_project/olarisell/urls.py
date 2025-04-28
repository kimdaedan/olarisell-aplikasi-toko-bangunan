from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import ProductViewSet, index

router = DefaultRouter()
router.register(r'products', ProductViewSet)

urlpatterns = [
    path('', index, name='index'),  # Rute untuk tampilan produk
    path('', include(router.urls)),  # Rute untuk API produk
]