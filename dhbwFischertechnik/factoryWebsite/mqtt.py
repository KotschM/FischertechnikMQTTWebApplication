import paho.mqtt.client as mqtt
from .mqttHandler import topic_Data_Handler_QoS_0, topic_Data_Handler_QoS_2

MQTT_Broker = "localhost"
MQTT_Port = 1883
Keep_Alive_Interval = 60
MQTT_Topic_Monitor = "Monitor/#"
MQTT_Topic_Storage_Factory = "Storage/Factory"
MQTT_Topic_Storage_Web = "Storage/Web"
MQTT_Topic_Order_Ready = "Order/Ready"
MQTT_Topic_Status = "Status/#"


def on_connect(self, mosq, obj, rc):
    print('Connected with ', MQTT_Topic_Monitor, ' and ', MQTT_Topic_Storage_Factory, ' and ', MQTT_Topic_Status,
          ' and ', MQTT_Topic_Order_Ready)
    mqttc.subscribe([(MQTT_Topic_Monitor, 0), (MQTT_Topic_Storage_Factory, 0), (MQTT_Topic_Status, 2),
                     (MQTT_Topic_Order_Ready, 2)])


def on_disconnect(self, mosq, obj, rc):
    print('Disconnect from Broker')


def on_message(mosq, obj, msg):
    if msg.qos == 0:
        topic_Data_Handler_QoS_0(msg.topic, msg.payload)
    elif msg.qos == 2:
        topic_Data_Handler_QoS_2(msg.topic, msg.payload)


def on_subscribe(mosq, obj, mid, granted_qos):
    print('Subscribed on ', MQTT_Topic_Monitor, ' and ', MQTT_Topic_Storage_Factory, ' and ', MQTT_Topic_Status,
          ' and ', MQTT_Topic_Order_Ready)


def on_publish(client, userdata, result):
    print("data published")


mqttc = mqtt.Client("Monitoring")

mqttc.on_message = on_message
mqttc.on_connect = on_connect
mqttc.on_subscribe = on_subscribe
mqttc.on_publish = on_publish
mqttc.on_disconnect = on_disconnect

mqttc.connect(MQTT_Broker, int(MQTT_Port), int(Keep_Alive_Interval))
