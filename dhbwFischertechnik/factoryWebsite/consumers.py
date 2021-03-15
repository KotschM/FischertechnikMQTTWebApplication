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
        text_data_json = json.loads(text_data)
        message = text_data_json['message']
        print('Normal Receive')

        async_to_sync(self.channel_layer.group_send)(
            self.room_group_name,
            {
                'type': 'monitoring_message',
                'message': message
            }
        )

    # Receive message from room group
    def chat_message(self, event):
        message = event['message']

        # Send message to WebSocket
        self.send(text_data=json.dumps({
            'message': message
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
        text_data_json = json.loads(text_data)
        message = text_data_json['message']
        print('Normal Receive')

        async_to_sync(self.channel_layer.group_send)(
            self.customer_group_name,
            {
                'type': 'status_message',
                'message': message
            }
        )

    # Receive message from room group
    def status_message(self, event):
        message = event['message']

        # Send message to WebSocket
        self.send(text_data=json.dumps({
            'message': message
        }))
