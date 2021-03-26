import json

from django.http import JsonResponse
from django.shortcuts import render

from .models import *
from .utils import cartData, guestOrder
from .mqtt import *


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


def sendToFactory(request):
    mqttc.publish(MQTT_Topic_Storage_Web, request.body, 2)
    return JsonResponse('Storage was updated', safe=False)


def processOrder(request):
    data = json.loads(request.body)
    transaction_id = data['form']['timestamp']
    color = data['form']['color']

    customer, order = guestOrder(request, data)

    total = float(data['form']['total'])
    order.transaction_id = transaction_id

    if total == float(order.get_cart_total):
        order.complete = True
    order.save()

    orderJson = {"timestamp": transaction_id, "color": color}
    mqttc.publish(MQTT_Topic_Order, str(orderJson), 2)

    return JsonResponse('Payment complete!', safe=False)
