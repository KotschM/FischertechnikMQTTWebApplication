from django.db import models
#from channels.binding.websockets import WebsocketBinding


class Storage(models.Model):
    class BoxColors(models.TextChoices):
        WHITE = 'W'
        RED = 'R'
        BLUE = 'B'

    class BoxStatus(models.TextChoices):
        EMPTY = 'E'
        EMPTYBOX = 'EB'
        FULL = 'F'

    x = models.SmallIntegerField()
    y = models.SmallIntegerField()
    color = models.CharField(
        max_length=1,
        choices=BoxColors.choices,
    )
    status = models.CharField(
        max_length=2,
        choices=BoxStatus.choices,
        default=BoxStatus.FULL,
    )


#class StorageBinding(WebsocketsBinding):
#    model = Storage
#    stream = "storage"
#    fields = ["x", "y", "color", "status"]
#
#    @classmethod
#    def group_names(cls, instance):
#        return ["storage-updates"]
#
#    def has_permission(self, user, action, pk):
#        return True
