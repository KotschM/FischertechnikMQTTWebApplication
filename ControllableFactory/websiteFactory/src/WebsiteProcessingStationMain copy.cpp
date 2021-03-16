#include "TXT_highlevel_API.h"
#include "TxtMqttFactoryClient.h"
#include "debug.h"
#include "config.h"


TXT txt;
TxtMqttFactoryClient* mqttClient;

TwoRefAxis oven = TwoRefAxis{txt, 5, 10, 9};
TwoRefAxis vacuum_roboter = TwoRefAxis{txt, 6, 5, 11};
NRefAxis table = NRefAxis{txt, 1, std::vector<uint8_t>{1, 2, 3}};

Motor belt = txt.motor(3);
Motor saw = txt.motor(2);

Output oven_gate = txt.output(15);
Output ventil_roboter = txt.output(14);
Output ventil_vacuum = txt.output(13);
Output comp = txt.output(8);
Output oven_light = txt.output(16);
Output table_ventil = txt.output(7);

//DigitalInput oven_light_sensor = txt.digitalInput(13);
//DigitalInput belt_light_sensor = txt.digitalInput(4);

bool sawStat = false;
bool compStat = false;
bool beltStat = false;
bool ovenLightStat = false;
bool ovenGateStat = false;

void ProcessWorkpiece();
void topicCommand(const std::string &message)
{
    if (message.compare("Saw") == 0)
    {
        sawStat = !sawStat;
    }else
    {
        if (message.compare("AirCompressor") == 0)
        {
            compStat = !compStat;
        }else
        {
            if (message.compare("Belt") == 0)
            {
                beltStat = !beltStat;
            }else
            {
                if (message.compare("OvenLight") == 0)
                {
                    ovenLightStat = !ovenLightStat;
                }else
                {
                    if (message.compare("OvenGate") == 0)
                    {
                        ovenGateStat = !ovenGateStat;
                    }
                }
            }
        }
    }
}

int main(void)
{
    mqttClient = new TxtMqttFactoryClient("ProcessingStation", "192.168.178.100", "", "");
    mqttClient->connect(1000);
    mqttClient->subTopicAsync("/factory/processingStation", topicCommand);

    while (true)
    {
        //ProcessWorkpiece();
        sawStat ? saw.right(1000) : saw.stop();
        compStat ? comp.on() : comp.off();
        ovenLightStat ? oven_light.on() : oven_light.off();
        ovenGateStat ? oven_gate.on() : oven_gate.off();
        beltStat ? belt.right(1000) : belt.stop();
    }
    delete mqttClient;
    return 0;
}

void ProcessWorkpiece()
{
    /*
    oven_light_sensor.waitFor(DigitalState::LOW);
    mqttClient->publishMessageAsync(TOPIC_INPUT_PROCESSINGSTATION_STATE, "starte...", DFLT_QUALITY_OF_SERVICE, true);
    comp.on();
    sleep(2s);
    std::thread thread2 = vacuum_roboter.pos2Async();
    mqttClient->publishMessageAsync(TOPIC_INPUT_PROCESSINGSTATION_STATE, "brennen", DFLT_QUALITY_OF_SERVICE, true);
    oven_gate.on();
    oven.pos2();
    oven_gate.off();
    sleep(100ms);
    for (int i = 0; i < 14; i++)
    {
        oven_light.on();
        sleep(200ms);
        oven_light.off();
        sleep(200ms);
    }
    oven_gate.on();
    oven.pos1();

    thread2.join();
    ventil_roboter.on();

    sleep(500ms);
    ventil_vacuum.on();
    mqttClient->publishMessageAsync(TOPIC_INPUT_PROCESSINGSTATION_STATE, "transportieren", DFLT_QUALITY_OF_SERVICE, true);
    sleep(500ms);

    ventil_roboter.off();
    vacuum_roboter.pos1();
    ventil_roboter.on();

    sleep(500ms);
    ventil_vacuum.off();
    sleep(500ms);

    ventil_roboter.off();
    sleep(100ms);
    table.pos(1);
    mqttClient->publishMessageAsync(TOPIC_INPUT_PROCESSINGSTATION_STATE, "sägen", DFLT_QUALITY_OF_SERVICE, true);
    saw.right(OUTPUT_MAX_LEVEL);
    sleep(3s);
    saw.stop();
    table.pos(2);

    mqttClient->publishMessageAsync(TOPIC_INPUT_PROCESSINGSTATION_STATE, "fertig", DFLT_QUALITY_OF_SERVICE, true);
    belt.right(OUTPUT_MAX_LEVEL);
    table_ventil.on();
    sleep(100ms);
    table_ventil.off();
    comp.off();
    std::thread table_thread = table.posAsync(0);
    table_thread.detach();

    belt_light_sensor.waitFor(DigitalState::LOW);
    sleep(5s);
    belt.stop();
    mqttClient->publishMessageAsync(TOPIC_INPUT_PROCESSINGSTATION_STATE, "bereit", DFLT_QUALITY_OF_SERVICE, true);
    */
}