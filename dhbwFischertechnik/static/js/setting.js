document.getElementById('cart-symbol').classList.add("hidden");

csrftoken = form.getElementsByTagName("input")[0].value

document.getElementById('send-to-factory').addEventListener('click', function (){
    sendToFactory()
})

function sendToFactory(){
    var storageString = "" + document.getElementById('storage0').value +
        document.getElementById('storage1').value +
        document.getElementById('storage2').value +
        document.getElementById('storage3').value +
        document.getElementById('storage4').value +
        document.getElementById('storage5').value +
        document.getElementById('storage6').value +
        document.getElementById('storage7').value +
        document.getElementById('storage8').value

    const url = "/setting/sendToFactory/";
    fetch(url, {
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRFToken':csrftoken,
        },
        body: storageString,

    })
    .then((response) => response.json())
    .then(() => {
        alert('Lagerbestand erfolgreich aktualisiert');
        window.location.pathname = 'user/login/setting/';
    })
}