<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
      <div class="white_card card_box card_height_100 mb_30">
        <div class="white_box_tittle">
          <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">User</h4>
            <a href="/admin/user/new"><button type="button" class="btn btn-success">Create</button></a>
          </div>
        </div>
        <div class="white_card_body">
          <div class="table-responsive m-b-30">
            <div class="flex col-4 mb-6">
              <input id="search_input" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
              <button id="search_btn" type="button" disabled class="btn btn-primary">search</button>
              <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Email</th>
                  <th scope="col">
                    Role
                    <select class="role_select select_option w-26 text-medium border " name="role_id" aria-label="Default select example">
                      <option value="0" selected>All role</option>
                      <?php foreach ($all_roles as $role) { ?>
                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col">
                    Room
                    <select class="room_select select_option w-26 text-medium border " name="room_id" aria-label="Default select example">
                      <option value="0" selected>All room</option>
                      <?php foreach ($all_rooms as $room) { ?>
                        <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col">
                    Position
                    <select class="position_select select_option w-26 text-medium border " name="position_id" aria-label="Default select example">
                      <option value="0" selected>All position</option>
                      <?php foreach ($all_positions as $position) { ?>
                        <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col">Option</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1;
                foreach ($all_users as $user) { ?>
                  <tr class="user_items">
                    <th scope="row"><?= $i;
                                    $i++ ?></th>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['gender'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td class="role_name"><?= $user['role_name'] ?></td>
                    <td class="room_name"><?= $user['room_name'] ?></td>
                    <td class="position_name"><?= $user['position_name'] ?></td>
                    <td class="flex items-center justify-start">
                      <a href='/admin/user/edit?id=<?= $user['id'] ?>' class="edit_btn mr-2"><button type="button" class="btn btn-info text-white">Edit</button></a>
                      <button type="button" data-id="<?= $user['id'] ?>" class="btn btn-danger delete-btn text-white">Delete</button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="flex justify-center items-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <li class="page-item cursor-pointer"><a class="page-link">Previous</a></li>
              <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                <li class="page-item cursor-pointer"><a class="page-link"><?= $i ?></a></li>
              <?php } ?>
              <li class="page-item cursor-pointer"><a class="page-link">Next</a></li>
            </ul>
          </nav>
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