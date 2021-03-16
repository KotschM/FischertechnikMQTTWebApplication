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

all: WebsiteSortingLineMain WebsiteProcessingStationMain WebsiteMainUnit

WebsiteVacuumRobot.o : src/WebsiteVacuumRobot.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

WebsiteWarehouseStorage.o : src/WebsiteWarehouseStorage.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

WebsiteHighBayWarehouse.o : src/WebsiteHighBayWarehouse.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

WebsiteMainUnit.o: src/WebsiteMainUnit.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

WebsiteProcessingStationMain.o: src/WebsiteProcessingStationMain.cpp 
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

WebsiteSortingLineMain.o: src/WebsiteSortingLineMain.cpp
	$(CXX) $(CXXFLAGS) $^ -o obj/$@

WebsiteMainUnit: WebsiteMainUnit.o WebsiteHighBayWarehouse.o WebsiteVacuumRobot.o WebsiteWarehouseStorage.o
	$(CXX) $(LFLAGS) $(LIBPATH) obj/WebsiteMainUnit.o obj/WebsiteHighBayWarehouse.o obj/WebsiteVacuumRobot.o obj/WebsiteWarehouseStorage.o $(LIBS) -o bin/$@

WebsiteProcessingStationMain: WebsiteProcessingStationMain.o
	$(CXX) $(LFLAGS) $(LIBPATH) obj/$^ $(LIBS) -o bin/$@

WebsiteSortingLineMain: WebsiteSortingLineMain.o
	$(CXX) $(LFLAGS) $(LIBPATH) obj/$^ $(LIBS) -o bin/$@