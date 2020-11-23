INCLUDE = -I"../deps/include" -I"../FactoryLib/include" -I"include"

CXX =arm-linux-gnueabihf-g++ $(INCLUDE)
CXXFLAGS = -std=gnu++17 -O3 -Wall -c -fmessage-length=0 -Wno-psabi 
LFLAGS = -Wall
LIBPATH = -L"../deps/lib" -L"../FactoryLib/obj" 

LIBS = -l"SDLWidgetsLib" \
	-l"paho-mqtt3c" \
	-l"paho-mqtt3a" \
	-l"paho-mqttpp3" \
	-l"jsoncpp" \
	-l"pthread" \
	-l"SDL" \
	-l"SDL_gfx" \
	-l"SDL_ttf" \
	-l"ts" \
	-l"freetype" \
	-l"z" \
	-l"png16" \
	-l"bz2" \
	-l"jpeg" \
	-l"asound" \
	-l"SDL_image" \
	-l"crypto" \
	-l"TxtControlLib" \
	-l"ROBOProLib" \
	-l"MotorIOLib" \
	-l"KeLibTxt"\
	-l"txtlowlevelapi"\
	-l"txthighlevelapi"\
	-l"utils"\
	-l"mqttclient"\
	-l"debug"

$(shell mkdir -p "bin")
$(shell mkdir -p "obj")

all: ControlSortingLineMain ControlProcessingStationMain ControlMainUnit

ControlVacuumRobot.o : src/ControlVacuumRobot.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

ControlWarehouseStorage.o : src/ControlWarehouseStorage.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

ControlHighBayWarehouse.o : src/ControlHighBayWarehouse.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

ControlMainUnit.o: src/ControlMainUnit.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

ControlProcessingStationMain.o: src/ControlProcessingStationMain.cpp 
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

ControlSortingLineMain.o: src/ControlSortingLineMain.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

ControlMainUnit: ControlMainUnit.o ControlHighBayWarehouse.o ControlVacuumRobot.o ControlWarehouseStorage.o
	$(CXX) $(LFLAGS) $(LIBPATH) obj/ControlMainUnit.o obj/ControlHighBayWarehouse.o obj/ControlVacuumRobot.o obj/ControlWarehouseStorage.o $(LIBS) -o bin/$@

ControlProcessingStationMain: ControlProcessingStationMain.o
	$(CXX) $(LFLAGS) $(LIBPATH) obj/$^ $(LIBS) -o bin/$@

ControlSortingLineMain: ControlSortingLineMain.o
	$(CXX) $(LFLAGS) $(LIBPATH) obj/$^ $(LIBS) -o bin/$@