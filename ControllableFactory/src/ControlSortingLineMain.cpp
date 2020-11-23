#include "TXT_highlevel_API.h"
#include "TxtMqttFactoryClient.h"
#include <thread>
#include "debug.h"
#include "config.h"

#define DEBUG_SORTINGLINE false

enum SortingLineState
{
    WAITING,
    WORKING
};

TXT txt;
TxtMqttFactoryClient* mqttClient;

DigitalInput light_sensor_start = txt.digitalInput(1);
DigitalInput light_sensor_end = txt.digitalInput(3);
Motor belt = txt.motor(1);
Counter counter = txt.counter(1);
ColorSensor color_sensor = txt.colorSensor(2);
Output comp = txt.output(8);
Output white = txt.output(5);
Output red = txt.output(6);
Output blue = txt.output(7);

// Monitor
NTC motorTemperture = txt.ntc(4);
Voltage motorVoltage = txt.voltage(5);

SortingLineState colorDetectionUnit = SortingLineState::WAITING;
SortingLineState sortingUnit = SortingLineState::WAITING;

void SortWorkpiece(Color color);
void ColorDetection();
bool end = false;
void topicCommand(const std::string &message)
{
	end = true;
}

int main(void)
{
    mqttClient = new TxtMqttFactoryClient("SortingLine", "192.168.178.100", "", "");
    mqttClient->connect(1000);
    mqttClient->subTopicAsync("/factory/sortingLine", topicCommand);
}