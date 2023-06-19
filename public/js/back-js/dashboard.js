const url = window.location.href
console.log(url);
const controller = url.split('/')[4]
var navItem = ''
navItem = document.querySelector(`.${controller}`)
navItem.querySelector('a').classList.add('fw-bold', 'list-group-item', 'active')