#ifndef UTILS
#define UTILS

#include <chrono>
#include <thread>
#include <string>
#include "math.h"
#include "json/json.h"

using namespace std::chrono;

enum Color
{
    WHITE = 0,
    RED = 1,
    BLUE = 2
};

void sleep(std::chrono::microseconds);

Color convertToColor(uint16_t value, int blue_lower = 1600, int red_lower = 1200);

double convertToTemperature(uint16_t);

std::string jsonToString(Json::Value obj);

std::string jsonToStyledString(Json::Value obj);

#endif