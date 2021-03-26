from django.urls import re_path
from .consumers import MonitoringConsumer, StatusConsumer, StorageConsumer

websocket_urlpatterns = [
    re_path(r'ws/status/(?P<customer_name>\w+)/$', StatusConsumer.as_asgi()),
    re_path(r'ws/monitoring/$', MonitoringConsumer.as_asgi()),
    re_path(r'ws/storage/$', StorageConsumer.as_asgi()),
]
