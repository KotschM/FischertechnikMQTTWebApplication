import json

from asgiref.sync import async_to_sync
from channels.layers import get_channel_layer


def Test_Data_Handler(data):
    json_Dict = json.loads(data)
    color = json_Dict['Color']
    temperature = json_Dict['Temperature']
    voltage = json_Dict['Voltage']
    print('Inside Handler')
    channel_layer = get_channel_layer()
    async_to_sync(channel_layer.group_send)(
        'sensors_monitoring',
        {
            'type': 'monitoring_message',
            'color': color,
            'temperature': temperature,
            'voltage': voltage
        }
    )


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


def topic_Data_Handler(topic, data):
    if topic.startswith("Factory/Status"):
        Status_Data_Handler(topic, data)
    elif topic == "Factory/Test":
        Test_Data_Handler(data)
