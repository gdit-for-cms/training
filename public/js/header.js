const $ = document.querySelector.bind(document)
const $$ = document.querySelectorAll.bind(document)

const accountEle = $('.dropdown');
const dropMenu = $('.dropdown-menu');

function start() {
    handleEvent();
}

start()

function handleEvent() {

    accountEle.addEventListener('click', () => {
        dropMenu.classList.toggle('block')
    })
};