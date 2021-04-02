import json

from django.http import JsonResponse
from django.shortcuts import render

from .models import *
from .mqtt import mqttc, MQTT_Topic_Storage_Web
from .utils import cartData, guestOrder, sendNewOrderToFactory


def store(request):
    data = cartData(request)
    cartItems = data['cartItems']

    products = Product.objects.all()
    context = {'products': products, 'cartItems': cartItems}
    return render(request, 'factoryWebsite/store.html', context)


def cart(request):
    data = cartData(request)
    cartItems = data['cartItems']
    order = data['order']
    items = data['items']

    context = {'items': items, 'order': order, 'cartItems': cartItems}
    return render(request, 'factoryWebsite/cart.html', context)


def checkout(request):
    data = cartData(request)
    cartItems = data['cartItems']
    order = data['order']
    items = data['items']
    context = {'items': items, 'order': order, 'cartItems': cartItems}
    return render(request, 'factoryWebsite/checkout.html', context)


def monitoring(request):
    return render(request, 'factoryWebsite/monitoring.html')


def storage(request):
    return render(request, 'factoryWebsite/storage.html')


def setting(request):
    return render(request, 'factoryWebsite/setting.html')


def status(request, customer_timestamp):
    return render(request, 'factoryWebsite/status.html', {
        'customer_timestamp': customer_timestamp
    })


def sendStorageToFactory(request):
    mqttc.publish(MQTT_Topic_Storage_Web, request.body, 2)
    return JsonResponse('Storage was updated', safe=False)


def processOrder(request):
    data = json.loads(request.body)
    transaction_id = data['form']['timestamp']
    color = data['form']['color']

    customer, order = guestOrder(request, data)

    order.transaction_id = transaction_id
    order.color = color
    order.save()

    sendNewOrderToFactory(False)

    return JsonResponse('Payment complete!', safe=False)
