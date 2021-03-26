import json

from asgiref.sync import async_to_sync
from channels.generic.websocket import WebsocketConsumer


class MonitoringConsumer(WebsocketConsumer):

    def connect(self):
        self.room_group_name = 'sensors_monitoring'
        async_to_sync(self.channel_layer.group_add)(
            self.room_group_name,
            self.channel_name
        )
        self.accept()

    def disconnect(self, close_code):
        async_to_sync(self.channel_layer.group_discard)(
            self.room_group_name,
            self.channel_name
        )

    def receive(self, text_data=None, bytes_data=None):
        pass

    def monitoring_message(self, event):
        color = event['colorSortingLine']
        temperatureSortingLine = event['temperatureSortingLine']
        voltageSortingLine = event['voltageSortingLine']
        temperatureMainUnit = event['temperatureMainUnit']
        voltageMainUnit = event['voltageMainUnit']

        self.send(text_data=json.dumps({
            'colorSortingLine': color,
            'temperatureSortingLine': temperatureSortingLine,
            'voltageSortingLine': voltageSortingLine,
            'temperatureMainUnit': temperatureMainUnit,
            'voltageMainUnit': voltageMainUnit
        }))


class StatusConsumer(WebsocketConsumer):

    def connect(self):
        self.customer_name = self.scope['url_route']['kwargs']['customer_name']
        self.customer_group_name = 'name_%s' % self.customer_name
        async_to_sync(self.channel_layer.group_add)(
            self.customer_group_name,
            self.channel_name
        )
        self.accept()

    def disconnect(self, close_code):
        async_to_sync(self.channel_layer.group_discard)(
            self.customer_group_name,
            self.channel_name
        )

    def receive(self, text_data=None, bytes_data=None):
        pass

    def status_message(self, event):
        message = event['message']

        self.send(text_data=json.dumps({
            'message': message
        }))


class StorageConsumer(WebsocketConsumer):

    def connect(self):
        self.room_group_name = 'storage_monitoring'
        async_to_sync(self.channel_layer.group_add)(
            self.room_group_name,
            self.channel_name
        )
        self.accept()

    def disconnect(self, close_code):
        async_to_sync(self.channel_layer.group_discard)(
            self.room_group_name,
            self.channel_name
        )

    def receive(self, text_data=None, bytes_data=None):
        pass

    def storage_message(self, event):
        storage0 = event['storage0']
        storage1 = event['storage1']
        storage2 = event['storage2']
        storage3 = event['storage3']
        storage4 = event['storage4']
        storage5 = event['storage5']
        storage6 = event['storage6']
        storage7 = event['storage7']
        storage8 = event['storage8']

        self.send(text_data=json.dumps({
            'storage0': storage0,
            'storage1': storage1,
            'storage2': storage2,
            'storage3': storage3,
            'storage4': storage4,
            'storage5': storage5,
            'storage6': storage6,
            'storage7': storage7,
            'storage8': storage8
        }))
