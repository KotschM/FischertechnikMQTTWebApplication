document.getElementById('cart-symbol').classList.add("hidden");

const chatSocket = new WebSocket(
    'ws://'
    + window.location.host
    + '/ws/monitoring/'
);

chatSocket.onmessage = function(e) {
    const data = JSON.parse(e.data);
    const colorValue = parseInt(data.colorSortingLine);
    var colorString;
    if (colorValue > 1600){
        colorString = "Blau";
    }else if (colorValue > 1000){
        colorString = "Rot";
    }else {
        colorString = "Weiß";
    }
    document.querySelector('#color-sensor').innerHTML = (data.colorSortingLine) + " (" + colorString + ")";
    document.querySelector('#temperature-sorting-sensor').innerHTML = parseFloat(data.temperatureSortingLine).toFixed(3) + " °C";
    document.querySelector('#voltage-sorting-sensor').innerHTML = (data.voltageSortingLine);
    document.querySelector('#temperature-main-sensor').innerHTML = parseFloat(data.temperatureMainUnit).toFixed(3) + " °C";
    document.querySelector('#voltage-main-sensor').innerHTML = (data.voltageMainUnit);
};

chatSocket.onclose = function(e) {
    console.error('Chat socket closed unexpectedly');
};