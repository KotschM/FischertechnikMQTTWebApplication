#include "VacuumRobot.h"
#include "HighBayWarehouse.h"
#include "TxtMqttFactoryClient.h"
#include "debug.h"
#include "config.h"

#define DEBUG_MAINUNIT false

enum BeltState
{
    WAREHOUSE,
    VACUUM_ROBOT
};

TXT txt;
TxtMqttFactoryClient* mqttClient;

VacuumRobot robot = VacuumRobot(txt);
HighbayWarehouse warehouse = HighbayWarehouse(txt);

Motor belt = txt.motor(1);
DigitalInput light_sensor_vacuum_robot = txt.digitalInput(1);
DigitalInput light_sensor_warehouse = txt.digitalInput(4);
TrackSensor belt_track_sensor = txt.trackSensor(2, 3);

DigitalInput white_available = txt.digitalInput(12);
DigitalInput red_available = txt.digitalInput(13);
DigitalInput blue_available = txt.digitalInput(14);

NTC motorTemperature = txt.ntc(15);
Voltage vaccuumVoltage = txt.voltage(16);

BeltState beltstate = BeltState::WAREHOUSE;

std::string order = "";
std::string user_topic = "unknown";
Color orderColor;

void checkAvailableWorkpieceOfColor();
void processOrder();
void getWorkpieceWithColor();

void driveToWarehouse(Color);
void driveToProcessing();
void storeWorkpieceHighBay(uint8_t, uint8_t, int);
void getWorkpieceHighBay(uint8_t, uint8_t);
void checkAvailableWorkpieces();
void getEmptyBox(Color);
void storeBox(WarehouseContent);
void getFullBox();
void driveBeltTo(BeltState);
std::thread driveBeltToAsync(BeltState);

void mqttNewStorageFromWeb(const std::string &message){
    warehouse.storage.setNewStorage(message);
}

void mqttOrderIsSorted(const std::string &orderid){
    order = orderid;
    user_topic = "Status/" + order;
}

void mqttNewOrder(const std::string &jsonOrderIdAndColor){
    const auto rawJsonLength = static_cast<int>(jsonOrderIdAndColor.length());
    JSONCPP_STRING err;
    Json::Value root;
    Json::CharReaderBuilder builder;
    const std::unique_ptr<Json::CharReader> reader(builder.newCharReader());
    if (!reader->parse(jsonOrderIdAndColor.c_str(), jsonOrderIdAndColor.c_str() + rawJsonLength, &root,
                       &err)) {
      return;
    }
    order = root["orderid"].asString();
    std::string color = root["color"].asString();
    int colorId = std::stoi(color);
    switch (colorId){
    case 1:
        orderColor = Color::WHITE;
        break;
    case 2:
        orderColor = Color::RED;
        break;
    case 3:
        orderColor = Color::BLUE;
        break;
    default:
        break;
    }
}

int main()
{
    readConfig();
    mqttClient = new TxtMqttFactoryClient("MainUnit", ip_adress, "", "");
    mqttClient->connect(1000);
    mqttClient->subTopicAsync("Storage/Web", mqttNewStorageFromWeb, 2);
    mqttClient->subTopicAsync("Order/Send", mqttNewOrder, 2);
    mqttClient->subTopicAsync("Factory/SortingToMain", mqttOrderIsSorted, 2);

    std::thread thread_vacuum = robot.referenceAsync();
    std::thread thread_warehouse = warehouse.referenceAsync();

    thread_vacuum.join();
    thread_warehouse.join();

    //std::thread run = std::thread(checkAvailableWorkpieces);
    //run.detach();

    std::thread run = std::thread(processOrder);
    run.detach();

    std::thread monitor = std::thread([] {
        while (true)
        {
            mqttClient->publishMessageAsync("Storage/Factory", warehouse.storage.getAsJson(), 0);
            std::string message = "{\"Temperature\":\"" + std::to_string(motorTemperature.getTemperature()) 
                                    + "\", \"Voltage\":\"" + std::to_string(vaccuumVoltage.value()) 
                                    + "\"}";
            mqttClient->publishMessageAsync("Monitor/MainUnit", message, 0);
            sleep(1000ms);
        }
    });
    monitor.detach();

    delete mqttClient;
    return 0;
}

void processOrder(){
    if (warehouse.storage.getQuantityOf(orderColor) > 0)
    {
        /* code */
    }else
    {
        checkAvailableWorkpieceOfColor();
    }
}

void checkAvailableWorkpieceOfColor(){
    switch (orderColor){
    case Color::WHITE:
        while(!white_available.value()){
            std::thread wait = std::thread([] {
                while (warehouse.state != HighBayState::H_READY)
                {
                    sleep(10ms);
                }
                getEmptyBox(Color::WHITE);
                driveBeltTo(BeltState::VACUUM_ROBOT);
            });
            driveToWarehouse(Color::WHITE);
            wait.join();
            storeBox(WarehouseContent::WHITE);
        }
        break;

    case Color::RED:
        while (!red_available.value()){
            std::thread wait = std::thread([] {
                while (warehouse.state != HighBayState::H_READY){
                    sleep(10ms);
                }
                getEmptyBox(Color::RED);
                driveBeltTo(BeltState::VACUUM_ROBOT);
            });
            driveToWarehouse(Color::RED);
            wait.join();
            storeBox(WarehouseContent::RED);
        }
        break;

    case Color::BLUE:
        while (!blue_available.value()){
            std::thread wait = std::thread([] {
                while (warehouse.state != HighBayState::H_READY){
                    sleep(10ms);
                }
                getEmptyBox(Color::BLUE);
                driveBeltTo(BeltState::VACUUM_ROBOT);
            });
            driveToWarehouse(Color::BLUE);
            wait.join();
            storeBox(WarehouseContent::BLUE);
        }
        break;
    default:
        break;
    }
}

void getWorkpieceWithColor(){
    // TODO move vaccuum robot to warehouse
    getFullBox();
    driveBeltTo(BeltState::VACUUM_ROBOT);
    std::thread processing = std::thread(driveToProcessing);
    while (beltstate != BeltState::WAREHOUSE)
    {
        sleep(10ms);
    }
    storeBox(WarehouseContent::EMPTY_BOX);
    processing.join();
}

/*
void checkAvailableWorkpieces()
{
    if (!white_available.value())
    {
        std::thread wait = std::thread([] {
            while (warehouse.state != HighBayState::H_READY)
            {
                sleep(10ms);
            }
            getEmptyBox(Color::WHITE);
            driveBeltTo(BeltState::VACUUM_ROBOT);
        });
        driveToWarehouse(Color::WHITE);
        wait.join();
        storeBox(WarehouseContent::WHITE);
    }
    else if (!red_available.value())
    {
        std::thread wait = std::thread([] {
            while (warehouse.state != HighBayState::H_READY)
            {
                sleep(10ms);
            }
            getEmptyBox(Color::RED);
            driveBeltTo(BeltState::VACUUM_ROBOT);
        });
        driveToWarehouse(Color::RED);
        wait.join();
        storeBox(WarehouseContent::RED);
    }
    else if (!blue_available.value())
    {
        std::thread wait = std::thread([] {
            while (warehouse.state != HighBayState::H_READY)
            {
                sleep(10ms);
            }
            getEmptyBox(Color::BLUE);
            driveBeltTo(BeltState::VACUUM_ROBOT);
        });
        driveToWarehouse(Color::BLUE);
        wait.join();
        storeBox(WarehouseContent::BLUE);
    }
    else
    {
        // TODO move vaccuum robot to warehouse
        getFullBox();
        driveBeltTo(BeltState::VACUUM_ROBOT);
        std::thread processing = std::thread(driveToProcessing);
        while (beltstate != BeltState::WAREHOUSE)
        {
            sleep(10ms);
        }
        storeBox(WarehouseContent::EMPTY_BOX);
        processing.join();
    }
}
*/

void driveToWarehouse(Color color)
{
    mqttClient->publishMessageAsync(TOPIC_INPUT_VACUUMROBOT_STATE, "holen", DFLT_QUALITY_OF_SERVICE, true);
    robot.yaxis.moveAbsolut(0);
    if (color == Color::WHITE)
    {
        robot.drive(WHITE_PICK_UP_X, PICK_UP_Y, WHITE_PICK_UP_Z);
    }
    else if (color == Color::RED)
    {
        robot.drive(RED_PICK_UP_X, PICK_UP_Y, RED_PICK_UP_Z);
    }
    else if (color == Color::BLUE)
    {
        robot.drive(BLUE_PICK_UP_X, PICK_UP_Y, BLUE_PICK_UP_Z);
    }    
    robot.suck();    
    robot.yaxis.moveAbsolut(0);
    robot.drive(WAREHOUSE_X, 0, 0);
    robot.zaxis.moveAbsolut(WAREHOUSE_Z);
    while (beltstate != BeltState::VACUUM_ROBOT)
    {
        sleep(10ms);
    }
    robot.yaxis.moveAbsolut(WAREHOUSE_Y);
    robot.release();
    robot.yaxis.moveAbsolut(0);
    //mqttClient->publishMessageAsync(TOPIC_INPUT_VACUUMROBOT_STATE, "bereit", DFLT_QUALITY_OF_SERVICE, true);
}

void driveToProcessing()
{
    //mqttClient->publishMessageAsync(TOPIC_INPUT_VACUUMROBOT_STATE, "abliefern", DFLT_QUALITY_OF_SERVICE, true);
    robot.yaxis.moveAbsolut(0);
    robot.drive(WAREHOUSE_X, WAREHOUSE_Y, WAREHOUSE_Z);
    robot.suck();
    robot.yaxis.moveAbsolut(0);    
    std::thread beltState = driveBeltToAsync(BeltState::WAREHOUSE);
    robot.zaxis.moveAbsolut(0);
    robot.xaxis.moveAbsolut(PROCESS_STATION_X);
    robot.drive(PROCESS_STATION_X, PROCESS_STATION_Y, PROCESS_STATION_Z); 
    robot.release();
    std::thread xaxis = robot.yaxis.moveAbsolutAsync(0);
    robot.zaxis.moveAbsolut(0);
    beltState.join();
    xaxis.join();
    //mqttClient->publishMessageAsync(TOPIC_INPUT_VACUUMROBOT_STATE, "bereit", DFLT_QUALITY_OF_SERVICE, true);
}

void storeWorkpieceHighBay(uint8_t x, uint8_t y, WarehouseContent content)
{
    //mqttClient->publishMessageAsync(TOPIC_INPUT_WAREHOUSE_STATE, "einlagern", DFLT_QUALITY_OF_SERVICE, true);
    warehouse.state = HighBayState::H_STORE_WORKPIECE;
    std::thread beltThread = driveBeltToAsync(BeltState::WAREHOUSE);
    warehouse.drive(3, 3);
    beltThread.join();
    warehouse.pull();
    warehouse.drive(x, y);
    warehouse.put();
    warehouse.storage.setWorkpieceAt(y * 3 + x, content);

    //mqttClient->publishMessageAsync(TOPIC_INPUT_STOCK, warehouse.storage.getAsJson(), DFLT_QUALITY_OF_SERVICE, true);

    warehouse.state = HighBayState::H_READY;
    //mqttClient->publishMessageAsync(TOPIC_INPUT_WAREHOUSE_STATE, "bereit", DFLT_QUALITY_OF_SERVICE, true);
}

void getEmptyBox(Color color)
{
    int pos = warehouse.storage.getPositionOf(WarehouseContent::EMPTY_BOX);
    if (pos != -1)
    {
        int x = pos % 3;
        int y = pos / 3;
        getWorkpieceHighBay(x, y);
    }
}

void storeBox(WarehouseContent content)
{
    int pos = warehouse.storage.getPositionOf(WarehouseContent::NO_BOX);
    if (pos != -1)
    {
        int x = pos % 3;
        int y = pos / 3;
        storeWorkpieceHighBay(x, y, content);
    }
}

void getWorkpieceHighBay(uint8_t x, uint8_t y)
{
    //mqttClient->publishMessageAsync(TOPIC_INPUT_WAREHOUSE_STATE, "auslagern", DFLT_QUALITY_OF_SERVICE, true);
    warehouse.state = HighBayState::H_PROVIDE_WORKPIECE;
    warehouse.drive(x, y);
    warehouse.pull();
    warehouse.storage.setWorkpieceAt(y * 3 + x, WarehouseContent::NO_BOX);

    //mqttClient->publishMessageAsync(TOPIC_INPUT_STOCK, warehouse.storage.getAsJson(), DFLT_QUALITY_OF_SERVICE, true);

    warehouse.drive(3, 3);
    warehouse.put(true);
    warehouse.state = HighBayState::H_READY;
    //mqttClient->publishMessageAsync(TOPIC_INPUT_WAREHOUSE_STATE, "bereit", DFLT_QUALITY_OF_SERVICE, true);
}

void getFullBox()
{
    int x = 0;
    int y = 0;
    for (int i = 0; i < STORAGE_SIZE; i++)
    {
        if ((int)warehouse.storage.getWorkpieceAt(i) > 0)
        {
            x = i % 3;
            y = i / 3;
            break;
        }
    }
    getWorkpieceHighBay(x, y);
}

void driveBeltTo(BeltState state) {
    if (state == BeltState::WAREHOUSE && !light_sensor_vacuum_robot.value())
    {
        belt.left(450);
        light_sensor_warehouse.waitFor(DigitalState::LOW);
        belt.stop();
        beltstate = BeltState::WAREHOUSE;
    }
    else if (state == BeltState::VACUUM_ROBOT && !light_sensor_warehouse.value())
    {
        belt.right(450);
        light_sensor_vacuum_robot.waitFor(DigitalState::LOW);
        // drive a bit more than the light sensor
        sleep(100ms);
        belt.stop();
        beltstate = BeltState::VACUUM_ROBOT;
    }
}

std::thread driveBeltToAsync(BeltState state) {
    return std::thread(driveBeltTo, state);
}
