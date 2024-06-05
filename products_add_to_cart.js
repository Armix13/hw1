/*FUNZIONE PER INTERCETTARE IL SUBMIT*/
function onHandleAddToCart(event) {
    /*IMPEDISCO IL RICARICAMENTO DELLA PAGINA*/
    event.preventDefault();

    /*OTTENGO IL RIFERIMENTO AL FORM PIU' VICINO CHE HA GENERATO L'EVENTO*/
    const form = event.currentTarget.closest('form');
    
    const productId = form.querySelector('input[name="product_id"]').value;
    addToCart(productId);
}

/*FUNZIONE CHE EFFETTUA LA FETCH ALLA PAGINA add_to_cart.php */
function addToCart(productId) {
    
    return fetch('./products_add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'product_id=' + encodeURIComponent(productId)
    })
    .then(onFetchResponse)
    .then(onHandleCartResponse);
}

function onFetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

/*FUNZIONE PER GESTIRE LA RISPOSTA JSON*/
function onHandleCartResponse(json) {
    const message = document.createElement('div');
    message.classList.add('message');

    if(typeof json.success === 'string'){
        message.textContent = 'Si è verificato un errore. Controllare di aver effettuato il login e riprovare.';
        message.style.color = 'red';
        
    }else if (json.success === true) {
        message.textContent = 'Il prodotto è stato aggiunto al carrello.';
        message.style.color = 'green';
    } else {
        message.textContent = 'Si è verificato un errore. Riprova.';
        message.style.color = 'red';
    }


    document.body.appendChild(message);

    setTimeout(() => {
        message.remove();
    }, 3000);
}



/*-----EVENT LISTENER ASSOCIATO AI BOTTONI AGGIUNGI AL CARRELLO-----*/
const buttons = document.querySelectorAll('.btn_submit');
for(const button of buttons){
    button.addEventListener('click', onHandleAddToCart);
}
