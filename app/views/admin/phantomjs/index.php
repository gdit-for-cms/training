<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
      <div class="white_card card_box card_height_100 mb_30">
        <div class="white_box_tittle">
          <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Phantomjs</h4>
          </div>
        </div>
        <div class="white_card_body">
          <div class="table-responsive m-b-30">
            <form class="mb-3" action="screen" method="POST">
              <label class="form-label" for="creen-url">Url*</label>
              <input class="form-control mb-3" type="text" name="url" id="creen-url" require>
              <button id="submit-creen" type="submit" class="btn btn-primary">Screen capture</button>
            </form>
            <form class="mb-3" action="saving" method="POST">
              <label class="form-label" for="saving-url">Url*</label>
              <input class="form-control mb-3" type="text" name="url" id="saving-url" require>
              <button id="submit-saving" type="submit" class="btn btn-primary">Saving</button>
            </form>
            <form class="mb-3" action="outputting" method="POST">
              <label class="form-label" for="outputting-url">Url*</label>
              <input class="form-control mb-3" type="text" name="url" id="outputting-url" require>
              <button id="submit-outputting" type="submit" class="btn btn-primary">Outputting PDF</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const userItemsEles = document.querySelectorAll('.user_items')
  const selectOptionEles = document.querySelectorAll('.select_option')
  const selectRoomEles = document.querySelector('.room_select')
  const selectRoleEles = document.querySelector('.role_select')
  const selectPositionEles = document.querySelector('.position_select')
  const searchInput = document.querySelector('#search_input')
  const searchBtn = document.querySelector('#search_btn')
  const deleteSearchBtn = document.querySelector('#delete_search')
  const paginationEles = document.querySelectorAll('.page-item')

  const PAGE_STORAGE_KEY = 'PAGE FILTER'
  var config = JSON.parse(localStorage.getItem(PAGE_STORAGE_KEY)) || {}

  function start() {
    filterUser()
    checkValueSearch()
    deleteSearch()
  }

  start()

  function setFilter(key, value) {
    config[key] = value
    localStorage.setItem(PAGE_STORAGE_KEY, JSON.stringify(config))
  }

  function sort(selectOption, itemName, sortName) {
    selectOption.addEventListener('change', () => {
      selectOptionEles.forEach(ele => {
        if (selectOption != ele) {
          ele.value = 0
        }
      })
      if (selectOption.value == 0) {
        userItemsEles.forEach(ele => {
          ele.classList.remove('hidden')
        })
      } else {
        userItemsEles.forEach(ele => {
          if (selectOption.value != ele.querySelector(itemName).textContent) {
            ele.classList.add('hidden')
          } else {
            ele.classList.remove('hidden')
          }
        })
      }

    })
  }

  function filterUser() {
    if (localStorage.getItem("PAGE FILTER") === null) {
      selectOptionEles.forEach(ele => {
        setFilter(ele.name, 0)
      })
      setFilter('search', searchInput.value)
      setFilter('page', 1)
    }
    selectRoomEles.value = config.room_id
    selectRoleEles.value = config.role_id
    selectPositionEles.value = config.position_id
    searchInput.value = config.search

    paginationEles.forEach(ele => {
      if (config.page == 1 && ele.getElementsByTagName('a')[0].textContent == 'Previous') {
        ele.classList.add('d-none')
      } else {
        ele.classList.remove('hidden')
      }

      if (config.page == paginationEles.length - 2 && ele.getElementsByTagName('a')[0].textContent == 'Next') {
        ele.classList.add('hidden')
      } else {
        ele.classList.remove('hidden')
      }

      if (config.page == ele.getElementsByTagName('a')[0].textContent) {
        ele.getElementsByTagName('a')[0].style.backgroundColor = '#C5C5C5'
      }

      ele.addEventListener('click', () => {
        switch (ele.getElementsByTagName('a')[0].textContent) {
          case 'Previous':
            if (config.page == 1) {
              setFilter('page', 1)
            } else {
              setFilter('page', parseInt(config.page) - 1)
            }
            break;
          case 'Next':
            if (config.page == paginationEles.length - 2) {
              setFilter('page', paginationEles.length - 2)
            } else {
              setFilter('page', parseInt(config.page) + 1)
            }
            break;
          default:
            setFilter('page', ele.getElementsByTagName('a')[0].textContent)
            break;
        }
        let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}${config.page == '' ? '' : `&page=${config.page}`}`
        if (data.charAt(0) == '&') {
          data = data.substring(1)
        }
        document.location.search = `?${data}`
      })
    })

    selectOptionEles.forEach(ele => {
      ele.addEventListener('change', (e) => {
        setFilter('page', 1)
        setFilter(ele.name, ele.value)
        let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}${config.page == '' ? '' : `&page=${config.page}`}`
        e.preventDefault();
        if (data.charAt(0) == '&') {
          data = data.substring(1)
        }
        document.location.search = `?${data}`
      });
    })

    searchBtn.addEventListener('click', () => {
      setFilter('page', 1)
      selectOptionEles.forEach(ele => {
        setFilter(ele.name, 0)
      })
      setFilter('search', searchInput.value)
      let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}${config.page == '' ? '' : `&page=${config.page}`}`
      if (data.charAt(0) == '&') {
        data = data.substring(1)
      }
      document.location.search = `?${data}`
    })
  };

  function checkValueSearch() {
    searchInput.addEventListener('keyup', () => {
      if (searchInput.value.length == 0) {
        searchBtn.disabled = true
      } else {
        searchBtn.disabled = false
      }
    })
  }

  function deleteSearch() {
    if (searchInput.value == '') {
      deleteSearchBtn.disabled = true
    } else {
      deleteSearchBtn.disabled = false
    }
    deleteSearchBtn.addEventListener('click', () => {
      setFilter('search', '')
      selectOptionEles.forEach(ele => {
        setFilter(ele.name, 0)
      })
      let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}`
      if (data.charAt(0) == '&') {
        data = data.substring(1)
      }
      document.location.search = `?${data}`
    })
  }
</script>