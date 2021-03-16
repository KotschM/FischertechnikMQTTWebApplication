#include "TXT_highlevel_API.h"
#include "TxtMqttFactoryClient.h"
#include <thread>
#include "debug.h"
#include "config.h"

TXT txt;
TxtMqttFactoryClient* mqttClient;

//DigitalInput light_sensor_start = txt.digitalInput(1);
//DigitalInput light_sensor_end = txt.digitalInput(3);
Motor belt = txt.motor(1);
//Counter counter = txt.counter(1);
//ColorSensor color_sensor = txt.colorSensor(2);
Output comp = txt.output(8);
Output white = txt.output(5);
Output red = txt.output(6);
Output blue = txt.output(7);

// Monitor
//NTC motorTemperture = txt.ntc(4);
//Voltage motorVoltage = txt.voltage(5);

bool compStat = false;
bool whiteStat = false;
bool redStat = false;
bool blueStat = false;
bool beltStat = false;
void topicCommand(const std::string &message)
{
    if (message.compare("AirCompressor") == 0)
    {
        compStat = !compStat;
    }else
    {
        if (message.compare("White") == 0)
        {
            whiteStat = !whiteStat;
        }else
        {
            if (message.compare("Red") == 0)
            {
                redStat = !redStat;
            }else
            {
                if (message.compare("Blue") == 0)
                {
                    blueStat = !blueStat;
                }else
                {
                    if (message.compare("Belt") == 0)
                    {
                        beltStat = !beltStat;
                    }
                }
            }
        }
    }
}

int main(void)
{
    mqttClient = new TxtMqttFactoryClient("SortingLine", "192.168.178.100", "", "");
    mqttClient->connect(1000);
    mqttClient->subTopicAsync("/factory/sortingLine", topicCommand);

    while (true)
    {
        compStat ? comp.on() : comp.off();
        whiteStat ? white.on() : white.off();
        redStat ? red.on() : red.off();
        blueStat ? blue.on() : blue.off();
        beltStat ? belt.right(1000) : belt.stop();
    }
    delete mqttClient;
    return 0;
}