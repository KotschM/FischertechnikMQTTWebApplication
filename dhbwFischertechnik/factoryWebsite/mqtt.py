import paho.mqtt.client as mqtt
from .mqttHandler import topic_Data_Handler

MQTT_Broker = "localhost"
MQTT_Port = 1883
Keep_Alive_Interval = 60
MQTT_Topic = "Factory/#"
# MQTT_Topic = "Factory/Get/#"


def on_connect(self, mosq, obj, rc):
    print('Connected with ', MQTT_Topic)
    mqttc.subscribe(MQTT_Topic, 0)


def on_disconnect(self, mosq, obj, rc):
    print('Disconnect from Broker')


def on_message(mosq, obj, msg):
    topic_Data_Handler(msg.topic, msg.payload)
    # print('Received ', {msg.payload.decode()}, ' from ', {msg.topic}, ' topic')


def on_subscribe(mosq, obj, mid, granted_qos):
    print('Subscribed on ', MQTT_Topic)
    # mqttc.publish('Factory/Test', 'Morris')


def on_publish(client, userdata, result):
    print("data published")


mqttc = mqtt.Client()

mqttc.on_message = on_message
mqttc.on_connect = on_connect
mqttc.on_subscribe = on_subscribe
mqttc.on_publish = on_publish
mqttc.on_disconnect = on_disconnect

mqttc.connect(MQTT_Broker, int(MQTT_Port), int(Keep_Alive_Interval))
