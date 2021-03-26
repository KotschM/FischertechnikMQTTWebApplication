from django.db import models
from django.contrib.auth.models import User


class Customer(models.Model):
    name = models.CharField(max_length=200)
    timestamp = models.BigIntegerField(null=True)

    def __str__(self):
        return self.name


class Product(models.Model):
    name = models.CharField(max_length=200)
    price = models.DecimalField(max_digits=7, decimal_places=2)
    image = models.ImageField(null=True, blank=True)

    def __str__(self):
        return self.name

    @property
    def imageUrl(self):
        try:
            url = self.image.url
        except:
            url = ''
        return url


class Order(models.Model):
    customer = models.ForeignKey(Customer, on_delete=models.SET_NULL, null=True, blank=True)
    complete = models.BooleanField(default=False, null=True, blank=False)
    transaction_id = models.CharField(max_length=100, null=True)

    def __str__(self):
        return str(self.id)

    @property
    def get_cart_total(self):
        orderitems = self.orderitem_set.all()
        total = sum([item.get_total for item in orderitems])
        return total

    @property
    def get_cart_items(self):
        orderitems = self.orderitem_set.all()
        total = sum([item.quantity for item in orderitems])
        return total


class OrderItem(models.Model):
    product = models.ForeignKey(Product, on_delete=models.SET_NULL, null=True)
    order = models.ForeignKey(Order, on_delete=models.SET_NULL, null=True)
    quantity = models.IntegerField(default=0, null=True, blank=True)

    @property
    def get_total(self):
        total = self.product.price * self.quantity
        return total


# class Storage(models.Model):
#     class BoxColors(models.TextChoices):
#         WHITE = 'W'
#         RED = 'R'
#         BLUE = 'B'
#
#     class BoxStatus(models.TextChoices):
#         EMPTY = 'E'
#         EMPTYBOX = 'EB'
#         FULL = 'F'

#     x = models.SmallIntegerField()
#     y = models.SmallIntegerField()
#     color = models.CharField(
#         max_length=1,
#         choices=BoxColors.choices,
#     )
#     status = models.CharField(
#         max_length=2,
#         choices=BoxStatus.choices,
#         default=BoxStatus.FULL,
#     )
