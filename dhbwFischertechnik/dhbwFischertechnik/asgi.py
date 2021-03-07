"""
ASGI config for dhbwFischertechnik project.

It exposes the ASGI callable as a module-level variable named ``application``.

For more information on this file, see
https://docs.djangoproject.com/en/3.1/howto/deployment/asgi/
"""

import os

from channels.auth import AuthMiddlewareStack
from channels.routing import ProtocolTypeRouter, URLRouter
from django.core.asgi import get_asgi_application

import modelfabrik.routing

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'dhbwFischertechnik.settings')

application = ProtocolTypeRouter({
    "http": get_asgi_application(),
    "websocket": AuthMiddlewareStack(
        URLRouter(
            modelfabrik.routing.websocket_urlpatterns
        )
    ),
})
