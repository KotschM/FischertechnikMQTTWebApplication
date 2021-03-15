from django.urls import re_path
from .consumers import MonitoringConsumer, StatusConsumer

websocket_urlpatterns = [
    re_path(r'ws/checkout/(?P<customer_name>\w+)/$', StatusConsumer.as_asgi()),
    re_path(r'ws/monitoring/$', MonitoringConsumer.as_asgi()),
]
