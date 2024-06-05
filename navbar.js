function showMenu(event) {
    event.preventDefault();
    const menu = document.querySelector('.nav_hamburger_link_container');
    menu.classList.remove('hidden');
    const closeMenuImg = document.querySelector('#close_menu');
    closeMenuImg.addEventListener('click', closeMenu);
}

function closeMenu() {
    document.querySelector('.nav_hamburger_link_container').classList.add('hidden');
}



const hamburgerLink = document.querySelectorAll('.nav_container_hamburger a');
for(const link of hamburgerLink){
    link.addEventListener('click', showMenu);
}