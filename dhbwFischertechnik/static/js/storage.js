document.getElementById('cart-symbol').classList.add("hidden");

const chatSocket = new WebSocket(
    'ws://'
    + window.location.host
    + '/ws/storage/'
);

chatSocket.onmessage = function(e) {
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
            document.querySelector('#storage' + index).style.backgroundColor = "grey";
            document.querySelector('#storage' + index).style.color = "black";
            break;
        case 0:
            document.querySelector('#storage' + index).innerHTML = "Leere Kiste";
            document.querySelector('#storage' + index).style.backgroundColor = "grey";
            document.querySelector('#storage' + index).style.color = "black";
            break;
        case 1:
            document.querySelector('#storage' + index).innerHTML = "Weißer Stein";
            document.querySelector('#storage' + index).style.backgroundColor = "grey";
            document.querySelector('#storage' + index).style.color = "white";
            break;
        case 2:
            document.querySelector('#storage' + index).innerHTML = "Roter Stein";
            document.querySelector('#storage' + index).style.backgroundColor = "grey";
            document.querySelector('#storage' + index).style.color = "red";
            break;
        case 3:
            document.querySelector('#storage' + index).innerHTML = "Blauer Stein";
            document.querySelector('#storage' + index).style.backgroundColor = "grey";
            document.querySelector('#storage' + index).style.color = "blue";
            break;
    }
}

chatSocket.onclose = function() {
    console.error('Chat socket closed unexpectedly');
};