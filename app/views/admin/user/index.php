<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
      <div class="white_card card_box card_height_100 mb_30">
        <div class="white_box_tittle">
          <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">User</h4>
            <a href="/user/new"><button type="button" class="btn btn-success">Create</button></a>
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
                  <th scope="col">Email</th>
                  <th scope="col">
                    Role
                    <select class="role_select select_option w-26 text-medium border " name="role_id" aria-label="Default select example">
                      <option value="0" selected>All role</option>
                      <?php foreach ($allRoles as $role) { ?>
                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col">
                    Room
                    <select class="room_select select_option w-26 text-medium border " name="room_id" aria-label="Default select example">
                      <option value="0" selected>All room</option>
                      <?php foreach ($allRooms as $room) { ?>
                        <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col">
                    Position
                    <select class="position_select select_option w-26 text-medium border " name="position_id" aria-label="Default select example">
                      <option value="0" selected>All position</option>
                      <?php foreach ($allPositions as $position) { ?>
                        <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1;
                  foreach ($allUsers as $user) { ?>
                    <tr class="user_items">
                      <th scope="row"><?= $i;
                                      $i++ ?></th>
                      <td><?= $user['name'] ?></td>
                      <td><?= $user['email'] ?></td>
                      <td class="role_name"><?= $user['role_name'] ?></td>
                      <td class="room_name"><?= $user['room_name'] ?></td>
                      <td class="position_name"><?= $user['position_name'] ?></td>
                      <td class="flex items-center justify-center">
                        <a href='/user/edit?id=<?= $user['id'] ?>' class="edit_btn mr-2"><button type="button" class="btn btn-info text-white">Edit</button></a>
                        <a href='/user/delete?id=<?= $user['id'] ?>' class="delete_btn"><button type="button" class="btn btn-danger text-white">Delete</button></a>
                      </td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
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

  function filter() {
    selectOptionEles.forEach(ele => {
      ele.addEventListener('change', () => {
        window.location.href = `filter?role_id=${selectRoleEles.value}&room_id=${selectRoomEles.value}&position_id=${selectPositionEles.value}`
      })
    })
  }

  function filterUser() {
    selectRoomEles.value = config.room_id
    selectRoleEles.value = config.role_id
    selectPositionEles.value = config.position_id
    searchInput.value = config.search

    selectOptionEles.forEach(ele => {
      ele.addEventListener('change', (e) => {
        setFilter(ele.name, ele.value)
        let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}`
        e.preventDefault();
        if (data.charAt(0) == '&') {
          data = data.substring(1)
        }
        document.location.search = `?${data}`
      });
    })

    searchBtn.addEventListener('click', () => {
      setFilter('search', searchInput.value)
      let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}`
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
      let data = `${config.role_id == '0' ? '' : `role_id=${config.role_id}`}${config.room_id == '0' ? '' : `&room_id=${config.room_id}`}${config.position_id == '0' ? '' : `&position_id=${config.position_id}`}${config.search == '' ? '' : `&search=${config.search}`}`
      if (data.charAt(0) == '&') {
        data = data.substring(1)
      }
      document.location.search = `?${data}`
    })
  }
</script>