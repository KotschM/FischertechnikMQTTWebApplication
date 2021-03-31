document.getElementById('cart-symbol').classList.add("hidden");

const chatSocket = new WebSocket(
    'ws://'
    + window.location.host
    + '/ws/monitoring/'
);

chatSocket.onmessage = function(e) {
    const data = JSON.parse(e.data);
    document.querySelector('#color-sensor').innerHTML = (data.colorSortingLine);
    document.querySelector('#temperature-sorting-sensor').innerHTML = (data.temperatureSortingLine);
    document.querySelector('#voltage-sorting-sensor').innerHTML = (data.voltageSortingLine);
    document.querySelector('#temperature-main-sensor').innerHTML = (data.temperatureMainUnit);
    document.querySelector('#voltage-main-sensor').innerHTML = (data.voltageMainUnit);
};

chatSocket.onclose = function(e) {
    console.error('Chat socket closed unexpectedly');
};