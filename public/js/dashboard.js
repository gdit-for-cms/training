

const PAGE_STORAGE_KEY = 'PAGE ADMIN'
let config = JSON.parse(localStorage.getItem(PAGE_STORAGE_KEY)) || {}


const navItemEles = $$('.nav_item')
const navContentEles = $$('.nav_content')


function start() {
    loadNav();
    changeNav();
    
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


