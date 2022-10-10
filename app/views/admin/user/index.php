<div class="col-md-10">
      <div id="user" name="user" class="col-md-10 mt-6 w-full nav_content hidden">
          <div class="panel panel-default shadow-xl">
              <div class="panel-heading flex items-center justify-between">
                  USER
                  <div>
                    <a href='/user/new' class='w-20 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg mx-2 p-2'>Create</a>
                  </div>
              </div>

              <div class="panel-body">
              <table class="table">
                <thead class="pb-2">
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
                        <?php foreach($rooms as $room) { ?>
                        <option value="<?= $room['name'] ?>"><?= $room['name'] ?></option>
                        <?php } ?>
                      </select>
                    </th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allUsers as $user) { ?>
                  <tr class="user_items">
                    <th scope="row"><?= $user['id'] ?></th>
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