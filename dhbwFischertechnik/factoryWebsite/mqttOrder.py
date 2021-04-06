import paho.mqtt.client as mqtt

MQTT_Broker = "localhost"
MQTT_Port = 1883
Keep_Alive_Interval = 60
MQTT_Topic_Order_Send = "Order/Send"


def on_connect(self, mosq, obj, rc):
    print('Connected with ')


def on_disconnect(self, mosq, obj, rc):
    print('Disconnect from Broker')


def on_message(mosq, obj, msg):
    pass


def on_subscribe(mosq, obj, mid, granted_qos):
    pass


def on_publish(client, userdata, result):
    print("order published")


mqttcOrder = mqtt.Client("Order")

mqttcOrder.on_message = on_message
mqttcOrder.on_connect = on_connect
mqttcOrder.on_subscribe = on_subscribe
mqttcOrder.on_publish = on_publish
mqttcOrder.on_disconnect = on_disconnect

mqttcOrder.connect(MQTT_Broker, int(MQTT_Port), int(Keep_Alive_Interval))
