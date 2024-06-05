/*----FUNZIONE ASSOCIATA ALLA COVER INIZIALE------*/
function onMouseOverCover(event) {
    event.currentTarget.removeEventListener('mouseover', onMouseOverCover);
    const bgVideo = document.querySelector('video.hidden');
    coverContainer.classList.add('hidden');
    bgVideo.classList.remove('hidden');
}


/*----FUNZIONE ASSOCIATA ALLA CAMPAGNA CORE VALUES-----*/
function onClickCampaign(event) {
    const campaignCover = document.querySelector('.campaign_container_cover');
    campaignCover.classList.add('hidden');
    const campaignContainer = document.querySelector('.campaign_container');
    const newDiv = document.createElement('div');
    const newParagraph = document.createElement('p');
    newParagraph.innerHTML = 'Tutti i dettagli della nuova campagna Core Values saranno disponibili a breve...';
    newDiv.classList.add('center_object');
    newDiv.classList.add('center_text');
    newDiv.style.margin = "70px 0 0 0";
    campaignContainer.appendChild(newDiv);
    newDiv.appendChild(newParagraph);
    readMore.removeEventListener('click', onClickCampaign);
    readMoreCover.removeEventListener('click', onClickCampaign);

}

/*-----FUNZIONE ASSOCIATA AI TOP PRODUCTS-----*/
function onHoverProduct(event) {
    const imageTarget = event.currentTarget;
    const fileSource = imageTarget.src;
    const fileUrlParts = fileSource?.split('/');
    const fileName = fileUrlParts?.length && fileUrlParts.pop();

    if(fileName.includes('.png')){
        let [imageName, ext] = fileName.split('.');
        imageName = imageName.concat('_2');

        const newFileName = [imageName, ext].join('.');
        fileUrlParts.push(newFileName);

        imageTarget.src = fileUrlParts.join('/');
        imageTarget.addEventListener('mouseout', onLeaveProduct, {once: true})
    }
}

/* */
function onLeaveProduct(event) {

    const imageTarget = event.currentTarget;
    const fileSource = imageTarget.src;
    const fileUrlParts = fileSource?.split('/');
    const fileName = fileUrlParts?.length && fileUrlParts.pop();

    if(fileName.includes('.png') && fileName.includes('_2')){
        fileUrlParts.push(fileName.replace('_2', ''));
        imageTarget.src = fileUrlParts.join('/');
    }
}



/*----EVENT LISTENER ASSOCIATO ALLA COVER INIZIALE----*/
const coverContainer = document.querySelector('.cover_container');
coverContainer.addEventListener('mouseover', onMouseOverCover);


/*----EVENT LISTENER ASSOCIATO ALLA CAMPAGNA CORE VALUES-----*/
const readMore = document.querySelector('p.campaign_container_title_small');
const readMoreCover = document.querySelector('.campaign_container_cover');
readMore.addEventListener('click', onClickCampaign);
readMoreCover.addEventListener('click', onClickCampaign);

/*-----EVENT LISTENER ASSOCIATO ALLO ZAINO CHRISTOPHER BLACK GREY*/
const images = document.querySelectorAll('.topproduct_container_items_img img');

for (const image of images){
    image.addEventListener('mouseover', onHoverProduct);
    
}