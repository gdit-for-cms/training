<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
        <div class="white_card card_height_100 mb_30">
          <div class="white_card_header">
            <div class="box_header m-0">
              <div class="main-title flex justify-between items-center w-full">
                <h3 class="m-0">User</h3>
                <div>
                  <a href='/user/new' class='w-20 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg mx-2 p-2'>Create</a>
                </div>
              </div>
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
                    </th>
                    <th scope="col">
                      Room
                      <select class="room_select w-26 text-medium border " aria-label="Default select example">
                        <option value="0" selected>All room</option>
                        <?php foreach ($rooms as $room) { ?>
                          <option value="<?= $room['name'] ?>"><?= $room['name'] ?></option>
                        <?php } ?>
                      </select>
                    </th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; foreach ($allUsers as $user) { ?>
                    <tr class="user_items">
                      <th scope="row"><?= $i; $i++ ?></th>
                      <td><?= $user['name'] ?></td>
                      <td><?= $user['email'] ?></td>
                      <td class="role_name"><?= $user['role_name'] ?></td>
                      <td class="room_name"><?= $user['room_name'] ?></td>
                      <td class="flex">
                        <a href='/user/edit?id=<?= $user['id'] ?>' class='edit_btn flex justify-center items-center text-white text-lg bg-blue-600 hover:bg-blue-700 hover:text-white rounded-lg mx-2 p-2'>Edit</a>
                        <a href='/user/delete?id=<?= $user['id'] ?>' class='delete_btn flex justify-center items-center text-white text-lg bg-red-600 hover:bg-red-700 hover:text-white rounded-lg mx-2 p-2'>Delete</a>
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