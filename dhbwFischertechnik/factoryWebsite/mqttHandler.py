import json

from asgiref.sync import async_to_sync
from channels.layers import get_channel_layer
from factoryWebsite.models import Order
from factoryWebsite.utils import sendNewOrderToFactory

monitorMainUnit = False
temperatureMainUnit = ""
voltageMainUnit = ""

monitorSortingLine = False
colorSortingLine = ""
temperatureSortingLine = ""
voltageSortingLine = ""


def Status_Data_Handler(topic, data):
    json_Dict = json.loads(data)
    message = json_Dict['Text']
    short_topic = topic.partition("Status/")[2]
    customer_group_name = 'name_%s' % short_topic

    channel_layer = get_channel_layer()
    async_to_sync(channel_layer.group_send)(
        customer_group_name,
        {
            'type': 'status_message',
            'message': message
        }
    )


def Monitoring_Data_Handler(topic, data):
    global colorSortingLine, temperatureSortingLine, voltageSortingLine, temperatureMainUnit, voltageMainUnit, \
        monitorSortingLine, monitorMainUnit
    json_Dict = json.loads(data)
    if topic == "Monitor/MainUnit":
        temperatureMainUnit = json_Dict['Temperature']
        voltageMainUnit = json_Dict['Voltage']
        monitorMainUnit = True

    elif topic == "Monitor/SortingLine":
        colorSortingLine = json_Dict['Color']
        temperatureSortingLine = json_Dict['Temperature']
        voltageSortingLine = json_Dict['Voltage']
        monitorSortingLine = True

    if monitorMainUnit and monitorSortingLine:
        monitorMainUnit = False
        monitorSortingLine = False
        channel_layer = get_channel_layer()
        async_to_sync(channel_layer.group_send)(
            'sensors_monitoring',
            {
                'type': 'monitoring_message',
                'colorSortingLine': colorSortingLine,
                'temperatureSortingLine': temperatureSortingLine,
                'voltageSortingLine': voltageSortingLine,
                'temperatureMainUnit': temperatureMainUnit,
                'voltageMainUnit': voltageMainUnit
            }
        )


def Storage_Data_Handler(data):
    json_Dict = json.loads(data)

    channel_layer = get_channel_layer()
    async_to_sync(channel_layer.group_send)(
        'storage_monitoring',
        {
            'type': 'storage_message',
            'storage0': json_Dict['Storage0'],
            'storage1': json_Dict['Storage1'],
            'storage2': json_Dict['Storage2'],
            'storage3': json_Dict['Storage3'],
            'storage4': json_Dict['Storage4'],
            'storage5': json_Dict['Storage5'],
            'storage6': json_Dict['Storage6'],
            'storage7': json_Dict['Storage7'],
            'storage8': json_Dict['Storage8']
        }
    )


def Order_Ready_Data_Handler(data):
    json_Dict = json.loads(data)
    last_id = json_Dict['LastId']

    try:
        recentOrder = Order.objects.get(transaction_id=last_id)
        recentOrder.finished = True
        recentOrder.save()
        # recentOrder.delete()
    except Order.DoesNotExist:
        pass

    sendNewOrderToFactory(True)


def topic_Data_Handler_QoS_0(topic, data):
    if topic.startswith("Monitor"):
        Monitoring_Data_Handler(topic, data)
    elif topic == "Storage/Factory":
        Storage_Data_Handler(data)


def topic_Data_Handler_QoS_2(topic, data):
    if topic.startswith("Status"):
        Status_Data_Handler(topic, data)
    elif topic == "Order/Ready":
        Order_Ready_Data_Handler(data)
