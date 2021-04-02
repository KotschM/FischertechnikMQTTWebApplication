from django.apps import AppConfig


class SampleStoreConfig(AppConfig):
    name = 'factoryWebsite'

    def ready(self):
        from . import mqtt
        from . import mqttOrder
        mqtt.mqttc.loop_start()
        mqttOrder.mqttcOrder.loop_start()
