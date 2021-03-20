from django.urls import path
from . import views

urlpatterns = [
    path('', views.store, name="factoryWebsite"),
    path('cart/', views.cart, name="cart"),
    path('checkout/', views.checkout, name="checkout"),
    path('monitoring/', views.monitoring, name="monitoring"),
    path('storage/', views.storage, name="storage"),
    path('setting/', views.setting, name="setting"),
    path('checkout/status/<str:customer_name>/', views.status, name="status"),
    path('update_item/', views.updateItem, name="update_item"),
    path('process_order/', views.processOrder, name="process_order"),
]
