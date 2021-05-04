document.getElementById('cart-symbol').classList.add("hidden");

let idleTimer = setInterval(setLoadingAnimation, 5000);

function setLoadingAnimation(){
    document.querySelector('#storage0').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage1').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage2').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage3').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage4').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage5').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage6').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage7').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
    document.querySelector('#storage8').innerHTML = '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
}

const chatSocket = new WebSocket(
    'ws://'
    + window.location.host
    + '/ws/storage/'
);

chatSocket.onmessage = function(e) {
    clearInterval(idleTimer);
    idleTimer = setInterval(setLoadingAnimation, 2000);

    const data = JSON.parse(e.data);
    const dataArray = [data.storage0, data.storage1, data.storage2,
        data.storage3, data.storage4, data.storage5,
        data.storage6, data.storage7, data.storage8];
    dataArray.forEach(setTextSwitchCase);
};

function setTextSwitchCase(item, index){
    switch (parseInt(item)){
        case -1:
            document.querySelector('#storage' + index).innerHTML = "Keine Kiste";
            break;
        case 0:
            document.querySelector('#storage' + index).innerHTML = "Leere Kiste";
            break;
        case 1:
            document.querySelector('#storage' + index).innerHTML = "Weiß";
            break;
        case 2:
            document.querySelector('#storage' + index).innerHTML = "Rot";
            break;
        case 3:
            document.querySelector('#storage' + index).innerHTML = "Blau";
            break;
    }
}

chatSocket.onclose = function() {
    console.error('Chat socket closed unexpectedly');
};