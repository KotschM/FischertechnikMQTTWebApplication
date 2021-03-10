from django.apps import AppConfig


class SampleStoreConfig(AppConfig):
    name = 'sampleStore'

    def ready(self):
        from . import mqtt
        mqtt.mqttc.loop_start()
