import json
import time

from asgiref.sync import async_to_sync
from channels.layers import get_channel_layer

counter = 0

def Status_Data_Handler(topic, data):
    json_Dict = json.loads(data)
    message = json_Dict['Text']
    short_topic = topic.partition("Factory/Status/")[2]
    customer_group_name = 'name_%s' % short_topic

    channel_layer = get_channel_layer()
    async_to_sync(channel_layer.group_send)(
        customer_group_name,
        {
            'type': 'status_message',
            'message': message
        }
    )

    # newOrder = Order()
    # newOrder.color_text = SensorID
    # newOrder.pub_date = Data_and_Time
    # newOrder.finished = Temperature
    # newOrder.save()


def Monitoring_Data_Handler(data):
    json_Dict = json.loads(data)
    color = json_Dict['Color']
    temperature = json_Dict['Temperature']
    voltage = json_Dict['Voltage']
    actualTime = time.time()
    print('Inside Handler')
    channel_layer = get_channel_layer()
    async_to_sync(channel_layer.group_send)(
        'sensors_monitoring',
        {
            'type': 'monitoring_message',
            'time': actualTime,
            'color': color,
            'temperature': temperature,
            'voltage': voltage
        }
    )


def Storage_Data_Handler(data):
    print(data)
    json_Dict = json.loads(data)
    storage0 = json_Dict['Storage0']
    storage1 = json_Dict['Storage1']
    storage2 = json_Dict['Storage2']
    storage3 = json_Dict['Storage3']
    storage4 = json_Dict['Storage4']
    storage5 = json_Dict['Storage5']
    storage6 = json_Dict['Storage6']
    storage7 = json_Dict['Storage7']
    storage8 = json_Dict['Storage8']

    channel_layer = get_channel_layer()
    async_to_sync(channel_layer.group_send)(
        'storage_monitoring',
        {
            'type': 'storage_message',
            'storage0': storage0,
            'storage1': storage1,
            'storage2': storage2,
            'storage3': storage3,
            'storage4': storage4,
            'storage5': storage5,
            'storage6': storage6,
            'storage7': storage7,
            'storage8': storage8
        }
    )


def topic_Data_Handler(topic, data):
    if topic.startswith("Factory/Status"):
        Status_Data_Handler(topic, data)
    elif topic == "Factory/Monitoring":
        Monitoring_Data_Handler(data)
    elif topic == "Factory/Storage":
        Storage_Data_Handler(data)
