

const PAGE_STORAGE_KEY = 'PAGE ADMIN'
let config = JSON.parse(localStorage.getItem(PAGE_STORAGE_KEY)) || {}


const navItemEles = $$('.nav_item')
const navContentEles = $$('.nav_content')
const selectRoomEles = $('.room_select')
const selectRoleEles = $('.role_select')
const userItemsEles = $$('.user_items')
const roomNameEles = $$('.room_name')
const modalRoomEle = $('#modal_room')
const addMemberBtn = $$('.add_member_btn')
const closeModalBtn = $('.close_modal_btn')
const roomNameAddEles = $$('.room_name_add')


function start() {
    loadNav();
    changeNav();
    sort();
    showAndCloseModal();
}

start()



function setPage(key, value) {
    config[key] = value
    localStorage.setItem(PAGE_STORAGE_KEY, JSON.stringify(config))
}

function changeNav() {
    navItemEles.forEach(nav => {
        nav.addEventListener('click', () => {
            navItemEles.forEach(ele=> {
                ele.classList.remove('active')
            })
            nav.classList.add('active')
            navContentEles.forEach((ele) => {
                if (nav.textContent.toLowerCase() == ele.id) {
                    navContentEles.forEach((ele) => {
                        ele.classList.add('hidden')
                    })
                    ele.classList.remove('hidden')
                }
            })
            setPage('currentNav', nav.textContent.toLowerCase())          
        
        });
    })
}

function loadNav(params) {
    navContentEles.forEach((ele) => {
        if (ele.id == config.currentNav) {
            navItemEles.forEach(ele=> {
                ele.classList.remove('active')
                if (ele.textContent.toLowerCase() == config.currentNav) {
                    ele.classList.add('active')
                }
            })
            navContentEles.forEach((ele) => {
                ele.classList.add('hidden')
            })
            ele.classList.remove('hidden')
        }
    })
}

function sort() {
    selectRoomEles.addEventListener('change', () => {
        console.log(selectRoomEles.value);
        if (selectRoomEles.value == 0) {
            userItemsEles.forEach(ele => {
                ele.classList.remove('hidden')
            })
        } else {
            userItemsEles.forEach(ele => {
                if (selectRoomEles.value != ele.querySelector('.room_name').textContent ) {
                    ele.classList.add('hidden')
                } else {
                    ele.classList.remove('hidden')
                }
            })
        }

    })
}

function showAndCloseModal(params) {
    addMemberBtn.forEach(ele => {
        ele.addEventListener('click', () => {
            modalRoomEle.classList.remove('hidden');
            console.log(ele.parentNode.parentNode.parentNode.querySelector('.room_name_main').textContent);
            roomNameAddEles.forEach(e => {
                if (ele.parentNode.parentNode.parentNode.querySelector('.room_name_main').textContent == e.textContent) {
                    e.parentNode.getElementsByTagName('input')[0].checked = true
                }

            })
        })
    })
    closeModalBtn.addEventListener('click', () => {
        roomNameAddEles.forEach(e => {
             e.parentNode.getElementsByTagName('input')[0].checked = false
        })
        modalRoomEle.classList.add('hidden');
    })
}