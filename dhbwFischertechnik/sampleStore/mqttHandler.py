import json

from .models import Order


def Storage_Data_Handler(data):
    json_Dict = json.loads(data)
    White1 = json_Dict['w1']
    White2 = json_Dict['w2']
    White3 = json_Dict['w3']
    Red1 = json_Dict['r1']
    Red2 = json_Dict['r2']
    Red3 = json_Dict['r3']
    Blue1 = json_Dict['b1']
    Blue2 = json_Dict['b2']
    Blue3 = json_Dict['b3']
#
#    actualStorage = Storage.objects.first()
#    actualStorage.white1 = White1
#    actualStorage.white2 = White2
#    actualStorage.white3 = White3
#    actualStorage.red1 = Red1
#    actualStorage.red2 = Red2
#    actualStorage.red3 = Red3
#    actualStorage.blue1 = Blue1
#    actualStorage.blue2 = Blue2
#    actualStorage.blue3 = Blue3
#    actualStorage.save()


def Order_Data_Handler(data):
    json_Dict = json.loads(data)
    SensorID = json_Dict['Color']
    # Data_and_Time = json_Dict['Date']
    # Temperature = json_Dict['Finish']

    newOrder = Order()
    newOrder.color_text = SensorID
    # newOrder.pub_date = Data_and_Time
    # newOrder.finished = Temperature
    newOrder.save()


def sensor_Data_Handler(topic, data):
    if topic == "Factory/OrderOld":
        Order_Data_Handler(data)
    elif topic == "Factory/Storage":
        Storage_Data_Handler(data)
