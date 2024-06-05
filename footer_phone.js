/*-----FUNZIONE ASSOCIATA AL FOOTER IN VERSIONE TELEFONO-----*/
function onClickFooterPhone(event) {
    closeAll();
    let name = event.currentTarget.dataset.name;
    let contentShow = document.querySelector('#' + name + '_content');
    contentShow.classList.remove('hidden');
}

function closeAll() {
    const footerRowClose = document.querySelectorAll('div.footer_phone_row_hidden');
    for(const row of footerRowClose){
        row.classList.add('hidden');
    }
}


/*-----EVENT LISTENER ASSOCIATO AL FOOTER PHONE-----*/
const footerRow = document.querySelectorAll('.footer_phone_row');

for(const row of footerRow){
    row.addEventListener('click', onClickFooterPhone);
}