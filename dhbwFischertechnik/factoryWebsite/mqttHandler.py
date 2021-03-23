import json

from asgiref.sync import async_to_sync
from channels.layers import get_channel_layer

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
    short_topic = topic.partition("Factory/Get/Status/")[2]
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
    if topic == "Factory/Get/Monitoring/MainUnit":
        temperatureMainUnit = json_Dict['Temperature']
        voltageMainUnit = json_Dict['Voltage']
        monitorMainUnit = True

    elif topic == "Factory/Get/Monitoring/SortingLine":
        colorSortingLine = json_Dict['Color']
        temperatureSortingLine = json_Dict['Temperature']
        voltageSortingLine = json_Dict['Voltage']
        monitorSortingLine = True

    if monitorMainUnit == True and monitorSortingLine == True:
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
    if topic.startswith("Factory/Get/Status"):
        Status_Data_Handler(topic, data)
    elif topic.startswith("Factory/Get/Monitoring"):
        Monitoring_Data_Handler(topic, data)
    elif topic == "Factory/Get/Storage":
        Storage_Data_Handler(data)
