from django.conf.urls import url
from django.urls import re_path

from .consumers import ChatConsumer, StorageConsumer

websocket_urlpatterns = [
    re_path(r'ws/chat/(?P<room_name>\w+)/$', ChatConsumer.as_asgi()),
    re_path(r'ws/$', StorageConsumer.as_asgi()),
]
