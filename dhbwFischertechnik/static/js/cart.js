let updateBtns = document.getElementsByClassName('update-cart');

for (let i = 0; i < updateBtns.length; i++){
    updateBtns[i].addEventListener('click', function (){
        const productId = this.dataset.product;
        const action = this.dataset.action;
        console.log('productId: ', productId, 'Action: ', action)

        addCookieItem(productId, action)
    })
}

function addCookieItem(productId, action){
    console.log('User is not authenticated..')
    if (action === 'add'){
        if (cart[productId] == undefined){
            if (cart['count'] > 0){
                alert("Es darf sich nur ein Stein im Warenkorb befinden! \nBitte gehen Sie in den Warenkorb, um" +
                    " einen Stein zu" +
                    " entfernen.")
            }else {
                console.log('User is not authenticated...')
                cart[productId] = {'quantity':1}
                cart['count'] += 1
                cart['color'] = productId
            }
        }else {
            alert("Es darf sich nur ein Stein im Warenkorb befinden! \nBitte gehen Sie in den Warenkorb um einen Stein zu" +
                " entfernen.")
        }
    }
    if (action === 'remove'){
        cart[productId]['quantity'] -= 1
        cart['count'] -= 1
        cart['color'] = 0
        if (cart[productId]['quantity'] <= 0){
            console.log('Remove Item')
            delete cart[productId]
        }
    }
    console.log('Carts: ', cart)
    document.cookie = 'cart=' + JSON.stringify(cart) + ";domain=;path=/"
    location.reload()
}
