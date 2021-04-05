#include "TXT_highlevel_API.h"
#include "TxtMqttFactoryClient.h"
#include <thread>
#include "debug.h"
#include "config.h"

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

NTC motorTemperture = txt.ntc(4);
Voltage motorVoltage = txt.voltage(5);

SortingLineState colorDetectionUnit = SortingLineState::WAITING;
SortingLineState sortingUnit = SortingLineState::WAITING;

std::string order = "";
std::string user_topic = "unknown";
std::string MESSAGE_SCAN = "Die Farbe ihres Steines wird überprüft.";
std::string MESSAGE_SORT = "Ihr Stein wurde eingelagert.";

void SortWorkpiece(Color color);
void ColorDetection();

void topicCommand(const std::string &orderid){
    order = orderid;
    user_topic = "Status/" + order;
}

int main(void)
{
    readConfig();
    mqttClient = new TxtMqttFactoryClient("SortingLine", ip_adress, "", "");
    mqttClient->connect(1000);
    mqttClient->subTopicAsync("Factory/ProcessToSorting", topicCommand, 2);

    std::thread monitor = std::thread([] {
        while (true)
        {
            std::string message = "{\"Color\":\"" + std::to_string(color_sensor.value()) 
                                    + "\", \"Temperature\":\"" + std::to_string(motorTemperture.getTemperature()) 
                                    + "\", \"Voltage\":\"" + std::to_string(motorVoltage.value()) 
                                    + "\"}";
            mqttClient->publishMessageAsync("Monitor/SortingLine", message, 0);
            sleep(1000ms);
        }
    });
    monitor.detach();

    std::thread detection = std::thread(ColorDetection);

    while (true)
    {
        if (colorDetectionUnit == SortingLineState::WORKING || sortingUnit == SortingLineState::WORKING)
        {
            belt.right(512);
        }
        else
        {
            belt.stop();
        }
        sleep(50ms);
    }
    delete mqttClient;
    return 0;
}

void ColorDetection()
{
    while (true)
    {
        light_sensor_start.waitFor(DigitalState::LOW);

        std::string StatusMessage = "{\"Text\":\"" + MESSAGE_SCAN + "\"}";
        mqttClient->publishMessageAsync(user_topic, StatusMessage, 2);
        
        colorDetectionUnit = SortingLineState::WORKING;

        int min = color_sensor.value();
        while (light_sensor_end.value())
        {
            sleep(10ms);
            if (color_sensor.value() < min)
            {
                min = color_sensor.value();
            }
        }

        StatusMessage = "{\"Text\":\"" + MESSAGE_SORT + "\"}";
        mqttClient->publishMessageAsync(user_topic, StatusMessage, 2);

        std::string message = "{\"LastId\":\"" + order + "\"}";
        mqttClient->publishMessageAsync("Order/Ready", message, 2);

        std::thread sort = std::thread(SortWorkpiece, convertToColor(min, blue_lower, red_lower));
        sort.detach();
        colorDetectionUnit = SortingLineState::WAITING;
    }
}

void SortWorkpiece(Color color)
{
    sortingUnit = SortingLineState::WORKING;
    
    comp.on();
    switch (color)
    {
    case Color::WHITE:
        counter.waitSteps(6);
        white.on();
        break;
    case Color::RED:
        counter.waitSteps(16);
        red.on();
        break;
    case Color::BLUE:
        counter.waitSteps(26);
        blue.on();
        break;
    }
    sleep(100ms);
    white.off();
    red.off();
    blue.off();
    comp.off();
    sortingUnit = SortingLineState::WAITING;
}