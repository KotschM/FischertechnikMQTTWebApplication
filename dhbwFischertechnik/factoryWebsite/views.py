import datetime
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
    mqttc.publish("Factory/Send/Storage", request.body, 0)
    return JsonResponse('Storage was updated', safe=False)


def updateItem(request):
    data = json.loads(request.body)
    productId = data['productId']
    action = data['action']

    customer = request.user.customer
    product = Product.objects.get(id=productId)
    order, created = Order.objects.get_or_create(customer=customer, complete=False)

    orderItem, created = OrderItem.objects.get_or_create(order=order, product=product)

    if action == 'add':
        orderItem.quantity = (orderItem.quantity + 1)
    elif action == 'remove':
        orderItem.quantity = (orderItem.quantity - 1)

    orderItem.save()

    if orderItem.quantity <= 0:
        orderItem.delete()

    return JsonResponse('Item was added', safe=False)


def processOrder(request):
    data = json.loads(request.body)
    transaction_id = data['form']['timestamp']

    if request.user.is_authenticated:
        customer = request.user.customer
        order, created = Order.objects.get_or_create(customer=customer, complete=False)
    else:
        customer, order = guestOrder(request, data)

    total = float(data['form']['total'])
    order.transaction_id = transaction_id

    if total == float(order.get_cart_total):
        order.complete = True
    order.save()

    mqttc.publish("Factory/Send/Order", str(transaction_id), 2)

    return JsonResponse('Payment complete!', safe=False)
