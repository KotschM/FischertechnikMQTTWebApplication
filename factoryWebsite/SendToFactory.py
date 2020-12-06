import paho.mqtt.client as mqtt
import sys
import sqlite3
    
def on_publish(client, userdata, result):
    print("data published \n")
    pass

BROKER_ADDRESS = "localhost"
print("Connected to MQTT Broker: " + BROKER_ADDRESS)

client = mqtt.Client()
client.on_publish = on_publish
client.connect(BROKER_ADDRESS)
ret = client.publish(sys.argv[1], sys.argv[2])

connection = sqlite3.connect("ftdatabase.db")
zeiger = connection.cursor()
sql_createTableIfNotExists = "CREATE TABLE IF NOT EXISTS `FromWebToFactory` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `topic` TEXT NOT NULL, `message` TEXT NOT NULL );"
sql_insert = "INSERT INTO FromWebToFactory (topic, message) VALUES ('" + sys.argv[1] + "', '" + sys.argv[2] + "');"
zeiger.execute(sql_createTableIfNotExists)
connection.commit()
zeiger.execute(sql_insert)
connection.commit()
connection.close()