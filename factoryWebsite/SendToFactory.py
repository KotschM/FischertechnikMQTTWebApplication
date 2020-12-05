import paho.mqtt.client as mqtt
import sys
    
def on_publish(client, userdata, result):
    print("data published \n")
    pass

BROKER_ADDRESS = "localhost"
print("Connected to MQTT Broker: " + BROKER_ADDRESS)

client = mqtt.Client()
client.on_publish = on_publish
client.connect(BROKER_ADDRESS)
ret = client.publish(sys.argv[1], sys.argv[2])