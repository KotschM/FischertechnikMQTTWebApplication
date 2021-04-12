import json
from threading import Lock

from .models import *
from .mqttOrder import mqttcOrder, MQTT_Topic_Order_Send

lock = Lock()

factoryIsWorking = False


def cookieCart(request):
    try:
        cart = json.loads(request.COOKIES['cart'])
    except:
        cart = {}

    print('Cart: ', cart)
    items = []
    order = {'get_cart_total': 0, 'get_cart_items': 0}
    cartItems = order['get_cart_items']

    for i in cart:
        try:
            cartItems += cart[i]['quantity']
            product = Product.objects.get(id=i)
            total = (product.price * cart[i]['quantity'])

            order['get_cart_total'] += total
            order['get_cart_items'] += cart[i]['quantity']

            item = {
                'product': {
                    'id': product.id,
                    'name': product.name,
                    'price': product.price,
                    'imageUrl': product.imageUrl
                },
                'quantity': cart[i]['quantity'],
            }
            items.append(item)
        except:
            pass
    return {'cartItems': cartItems, 'order': order, 'items': items}


def cartData(request):
    cookieData = cookieCart(request)
    cartItems = cookieData['cartItems']
    order = cookieData['order']
    items = cookieData['items']
    return {'cartItems': cartItems, 'order': order, 'items': items}


def guestOrder(request, data):
    name = data['form']['name']
    timestamp = data['form']['timestamp']

    customer, created = Customer.objects.get_or_create(
        timestamp=timestamp,
        # name=name,
    )
    # customer.timestamp = timestamp
    customer.name = name
    customer.save()

    order = Order.objects.create(
        customer=customer,
        finished=False,
        sendToFactory=False
    )

    return customer, order


def sendNewOrderToFactory(fromFactory):
    global factoryIsWorking

    if fromFactory:
        factoryIsWorking = False

    lock.acquire()
    try:
        if not factoryIsWorking:
            nextOrderList = Order.objects.filter(sendToFactory=False)
            if nextOrderList.exists():
                nextOrder = nextOrderList.order_by('transaction_id').first()
                nextOrder.sendToFactory = True
                messageString = nextOrder.color + nextOrder.transaction_id
                # orderJson = {"orderid": nextOrder.transaction_id, "color": nextOrder.color}
                nextOrder.save()
                print("Vor Publish => " + messageString)
                mqttcOrder.publish(MQTT_Topic_Order_Send, str(messageString), 2)

                factoryIsWorking = True
    finally:
        lock.release()
