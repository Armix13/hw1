function onClickQuantityButton(event){

    const action = event.currentTarget.dataset.action;
    const cartItem = event.currentTarget.closest('.cart_item');
    const productId = cartItem.querySelector('input[name="product_id"]').value;
    const quantityCurrent = cartItem.querySelector('input[name="quantity_value"]');

    let quantity = parseInt(quantityCurrent.value);

    if(action === 'increase'){
        quantity++
    }else if (action === 'decrease'){
        quantity = Math.max(1, quantity - 1);
    }
    
    updateQuantity(productId, quantity, cartItem);
}


function updateQuantity(productId, quantity, cartItem){

    const requestData = {
        product_id: productId,
        quantity: quantity,
    };
    

    fetch('update_quantity.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(requestData),
    }).then(onResponse).then(onJson)

}

function onResponse(response){
    if(!response.ok) return null;
    return response.json();
}

function onJson(json){

    const message = document.createElement('div');
    message.classList.add('message');
    console.log(json.success);

    if (json.success === 'prodotto rimosso') {
        message.textContent = 'Prodotto rimosso dal carrello';
        message.style.color = 'green';

        window.setTimeout(reload, 1000);
    }
    else if (json.success === 'quantità aggiornata con successo'){
            message.textContent = 'Quantià aggiornata';
            message.style.color = 'green';   
            window.setTimeout(reload, 1000);
    }
    else if (json.success === 'errore invio dati post'){
            message.textContent = 'Errore';
            message.style.color = 'red';
            window.setTimeout(reload, 1000);
        }
}
function reload(){
    window.location.reload(true);
}

const buttonsQuantity = document.querySelectorAll(".quantity_btn");
for(const button of buttonsQuantity){
    button.addEventListener('click', onClickQuantityButton);
}
