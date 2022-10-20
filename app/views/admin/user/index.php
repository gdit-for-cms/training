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
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">
                    Role
                    <select class="role_select select_option w-26 text-medium border " aria-label="Default select example">
                      <option value="0" selected>All role</option>
                      <?php foreach ($allRoles as $role) { ?>
                        <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col">
                    Room
                    <select class="room_select select_option w-26 text-medium border " aria-label="Default select example">
                      <option value="0" selected>All room</option>
                      <?php foreach ($allRooms as $room) { ?>
                        <option value="<?= $room['id'] ?>"><?= $room['name'] ?></option>
                      <?php } ?>
                    </select>
                  </th>
                  <th scope="col">
                    Position
                    <select class="position_select select_option w-26 text-medium border " aria-label="Default select example">
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


  function start() {
      sort(selectRoomEles, '.room_name', 'roomSort');
      sort(selectRoleEles, '.role_name', 'roleSort');
      sort(selectPositionEles, '.position_name', 'positionSort'); 
      // filter()  
  }

  start()

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
                  if (selectOption.value != ele.querySelector(itemName).textContent ) {
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
</script>