document.getElementById('cart-symbol').classList.add("hidden");

const customer_timestamp = JSON.parse(document.getElementById('customer_timestamp').textContent);

const chatSocket = new WebSocket(
    'ws://'
    + window.location.host
    + '/ws/status/'
    + customer_timestamp
    + '/'
);

chatSocket.onmessage = function(e) {
    const data = JSON.parse(e.data);
    var table = document.getElementById("statusTable");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = data.message;
    var date = new Date();
    cell2.innerHTML = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds() + " Uhr";
};

chatSocket.onclose = function(e) {
    console.error('Chat socket closed unexpectedly');
};