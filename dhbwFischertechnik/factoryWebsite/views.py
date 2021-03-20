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


def status(request, customer_name):
    mqttc.publish("Factory/PushOrder", str(customer_name))
    return render(request, 'factoryWebsite/status.html', {
        'customer_name': customer_name
    })


def sendToFactory(request):
    data = json.loads(request.body)
    formData = data['form']
    mqttc.publish("Factory/Order", str(formData))
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
    transaction_id = datetime.datetime.now().timestamp()
    data = json.loads(request.body)

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

    return JsonResponse('Payment complete!', safe=False)
