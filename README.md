# Fischertechnik - MQTT - Web Application

Dieses Projekt entstand während einer Studienarbeit der [DHBW Stuttgart Campus Horb](https://www.dhbw-stuttgart.de/horb/home/) im Studiengang Informatik.
Bearbeiter: Moris Kotsch

Während dieser Arbeit wurde eine Web Anwendung entworfen und umgesetzt, welche mithilfe des IoT-Protokolls MQTT mit der [9-Volt Modellfabrik](https://www.fischertechnik.de/de-de/produkte/simulieren/simulationsmodelle/536629-sim-fabrik-simulation-9v-simulation), der Firma fischertechnik, kommunizieren kann.

## Verzeichnisstruktur

### ControllableFactory/deps 
Von fischertechnik bereitgestellte Bibliotheken und Header Dateien zur Entwicklung von Software für den TXT-Controller in C++.

### ControllableFactory/FactoryLib
Enthalten ist eine Implementierung der Highlevel und Lowlevel API für den TXT-Controller.
<br>
Author => [Joel Schmid](https://github.com/SchmidJoel/FischertechnikTXTApi)

### ControllableFactory/websiteFactory
C/C++ - Programme für die Modellfabrik. Angepasst für die Verwendung mit der E-Commerce Website.

### dhbwFischertechnik
Django-Projekt für die E-Commerce Website.
