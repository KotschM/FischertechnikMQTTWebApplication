const total = '{{ order.get_cart_total }}'

var form = document.getElementById('form')

csrftoken = form.getElementsByTagName("input")[0].value
console.log('NewToken: ', form.getElementsByTagName("input")[0].value)

form.addEventListener('submit', function (e){
    e.preventDefault()
    console.log('Form Submitted...')
    submitFormData()
})

function submitFormData(){
    console.log('Payment button clicked')
    const timestamp = Date.now()
    const userFormData = {
        'name': form.name.value,
        'total': total,
        'timestamp': timestamp,
        'color': cart['color']
    };

    console.log('User Info:', userFormData)

    const url = "/process_order/";
    fetch(url, {
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRFToken':csrftoken,
        },
        body:JSON.stringify({'form':userFormData}),

    })
    .then((response) => response.json())
    .then((data) => {
        console.log('Success:', data);

        cart = {"count": 0, "color": 0}
        document.cookie ='cart=' + JSON.stringify(cart) + ";domain=;path=/"

        let trackOrder = confirm("Bestellung erfolgreich :) \nMöchten Sie die Bestellung verfolgen?");
        if (trackOrder){
            window.location.pathname = '/checkout/status/' + timestamp + '/';
        }else {
            window.location.pathname = '';
        }
    })
}