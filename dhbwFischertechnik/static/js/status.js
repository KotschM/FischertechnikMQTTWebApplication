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
    document.querySelector('#chat-log').value += (data.message + '\n');
};

chatSocket.onclose = function(e) {
    console.error('Chat socket closed unexpectedly');
};