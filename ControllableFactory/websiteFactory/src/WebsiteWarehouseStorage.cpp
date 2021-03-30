#include "WarehouseStorage.h"

FileStorage::FileStorage()
{
    std::ifstream file(STORAGE_LOCATION);

    std::map<char, WarehouseContent> c2w;
    c2w['x'] = WarehouseContent::NO_BOX;
    c2w['e'] = WarehouseContent::EMPTY_BOX;
    c2w['w'] = WarehouseContent::WHITE;
    c2w['r'] = WarehouseContent::RED;
    c2w['b'] = WarehouseContent::BLUE;

    char c[STORAGE_SIZE];
    file.read(c, STORAGE_SIZE);
    for (int i = 0; i < STORAGE_SIZE; i++)
    {
        values[i] = c2w[c[i]];
    }
    file.close();
}

WarehouseContent FileStorage::getWorkpieceAt(uint8_t pos)
{
    return values[pos];
}

void FileStorage::setWorkpieceAt(uint8_t pos, WarehouseContent workpiece)
{
    values[pos] = workpiece;
    char c[STORAGE_SIZE];
    std::map<WarehouseContent, char> w2c;
    w2c[WarehouseContent::NO_BOX] = 'x';
    w2c[WarehouseContent::EMPTY_BOX] = 'e';
    w2c[WarehouseContent::WHITE] = 'w';
    w2c[WarehouseContent::RED] = 'r';
    w2c[WarehouseContent::BLUE] = 'b';

    for (int i = 0; i < STORAGE_SIZE; i++)
    {
        c[i] = w2c[values[i]];
    }
    std::ofstream file(STORAGE_LOCATION);
    file.write(c, STORAGE_SIZE);
    file.close();
}

int FileStorage::getPositionOf(WarehouseContent content)
{
    for (int i = 0; i < STORAGE_SIZE; i++)
    {
        if (values[i] == content)
        {
            return i;
        }
    }
    return -1;
}

std::string FileStorage::getAsJson()
{
    std::string temp = "{";
    int counter = 0;
    for (uint32_t i = 0; i < STORAGE_SIZE; i++)
    {
        temp += "\"Storage" + std::to_string(counter) + "\":\"" + std::to_string((int)values[i]) + "\",";
        counter ++;
    }
    std::string message = temp.substr(0, temp.size()-1);
    message += "}";

    return message;
}

void FileStorage::setNewStorage(std::string storageString)
{
    std::map<char, WarehouseContent> c2w;
    c2w['x'] = WarehouseContent::NO_BOX;
    c2w['e'] = WarehouseContent::EMPTY_BOX;
    c2w['w'] = WarehouseContent::WHITE;
    c2w['r'] = WarehouseContent::RED;
    c2w['b'] = WarehouseContent::BLUE;
    
    char c[STORAGE_SIZE];
    int i;
    for (i = 0; i < STORAGE_SIZE; i++) {
        c[i] = storageString[i];
    }

    for (int i = 0; i < STORAGE_SIZE; i++)
    {
        values[i] = c2w[c[i]];
    }

    std::ofstream file(STORAGE_LOCATION);
    file.write(c, STORAGE_SIZE);
    file.close();
}

int FileStorage::getQuantityOf(Color color){
    int quantity = 0;
    switch (color)
    {
    case Color::WHITE:
        for (int i = 0; i < STORAGE_SIZE; i++)
        {
            if (values[i] == WarehouseContent::WHITE)
            {
                quantity++;
            }
        }
        break;

    case Color::RED:
        for (int i = 0; i < STORAGE_SIZE; i++)
        {
            if (values[i] == WarehouseContent::RED)
            {
                quantity++;
            }
        }
        break;

    case Color::BLUE:
        for (int i = 0; i < STORAGE_SIZE; i++)
        {
            if (values[i] == WarehouseContent::BLUE)
            {
                quantity++;
            }
        }
        break;
    default:
        break;
    }
    
    return quantity;
}
