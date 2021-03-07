from django.urls import path

from . import views

urlpatterns = [
    #path('', views.startpage(), name='startpage'),
    path('chat/', views.index, name='index'),
    path('chat/<str:room_name>/', views.room, name='room'),
]
