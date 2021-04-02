from django.urls import path

from . import views

urlpatterns = [
    path('', views.store, name="factoryWebsite"),
    path('cart/', views.cart, name="cart"),
    path('checkout/', views.checkout, name="checkout"),
    path('monitoring/', views.monitoring, name="monitoring"),
    path('storage/', views.storage, name="storage"),
    path('user/login/setting/', views.setting, name="setting"),
    path('setting/sendToFactory/', views.sendStorageToFactory, name="sentToFactory"),
    path('checkout/status/<str:customer_timestamp>/', views.status, name="status"),
    path('process_order/', views.processOrder, name="process_order"),
]
