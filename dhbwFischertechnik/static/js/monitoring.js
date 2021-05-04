document.getElementById('cart-symbol').classList.add("hidden");

const chatSocket = new WebSocket(
    'ws://'
    + window.location.host
    + '/ws/monitoring/'
);

let idleTimer = setInterval(setLoadingAnimation, 5000);

function setLoadingAnimation(){
    document.querySelector('#color-sensor').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#temperature-sorting-sensor').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#voltage-sorting-sensor').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#temperature-main-sensor').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#voltage-main-sensor').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
}

chatSocket.onmessage = function(e) {
    clearInterval(idleTimer);
    idleTimer = setInterval(setLoadingAnimation, 2000);

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