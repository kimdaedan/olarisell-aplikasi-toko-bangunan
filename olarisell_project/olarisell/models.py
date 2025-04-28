from django.db import models

class Product(models.Model):
    product_name = models.CharField(max_length=255)
    current_stock = models.IntegerField()
    product_image = models.ImageField(upload_to='images/')  # Gunakan ImageField

    def __str__(self):
        return self.product_name