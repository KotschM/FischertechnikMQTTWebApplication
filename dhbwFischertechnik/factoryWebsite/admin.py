from django.contrib import admin
from .models import *


@admin.register(Customer)
class CustomerAdmin(admin.ModelAdmin):
    list_display = ("name", "timestamp")


@admin.register(Product)
class ProductAdmin(admin.ModelAdmin):
    list_display = ("name", "price", "image")


@admin.register(Order)
class OrderAdmin(admin.ModelAdmin):
    list_display = ("customer", "sendToFactory", "finished", "color", "transaction_id")
