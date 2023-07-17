<link href="/css/back-css/dashboard.css" rel="stylesheet">
<div class="container-fluid main-container" style="padding-top: 0;">
  <div class="col-md-2 sidebar">
    <div class="row">
      <!-- uncomment code for absolute positioning tweek see top comment in css -->
      <!-- Menu -->
      <div class="side-menu min-h-screen w-4/12 top-0 left-0 right-0" style="position: fixed; max-width: 325px;">
        <nav class="navbar navbar-default" role="navigation">
          <!-- Main Menu -->
          <div class="side-menu-container ml-4 mt-20">
            <ul class="nav navbar-nav w-full">
              <!-- <li class="active nav_item rounded"><a href="#"><span class="glyphicon glyphicon-dashboard"></span>User</a></li>
              <li class="nav_item rounded"><a href="#"><span class="glyphicon glyphicon-plane"></span>Role</a></li>
              <li class="nav_item rounded"><a href="#"><span class="glyphicon glyphicon-cloud"></span>Room</a></li> -->
            </ul>
          </div><!-- /.navbar-collapse -->
        </nav>

      </div>
    </div>
  </div>
  <h2 class="m-5"> Dashboard</h2>

  <div id="role" name="role" class="col-md-10 mt-6 w-full nav_content hidden">
    <div class="panel panel-default shadow-xl">
      <div class="panel-heading">
        ROLE
      </div>
      <div class="panel-body flex">
        <div class="panel panel-default shadow-lg w-1/2 mx-2">
          <div class="panel-heading">
            Admin
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                <tr>
              </thead>
              <tbody>
                <?php foreach ($admins as $admin) { ?>
                  <tr>
                    <th scope="row"><?= $admin['id'] ?></th>
                    <td><?= $admin['name'] ?></td>
                    <td><?= $admin['email'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="panel panel-default shadow-lg w-1/2 mx-2">
          <div class="panel-heading">
            User
          </div>
          <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                <tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user) { ?>
                  <tr>
                    <th scope="row"><?= $user['id'] ?></th>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="room" name="room" class="col-md-10 mt-6 nav_content ">
    <div class="panel panel-default">
      <div class="panel-heading flex items-center justify-between">
        ROOM
        <div>
          <a href='/room/new' class='w-20 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg mx-2 p-2'>Create</a>
        </div>
      </div>
      <div class="panel-body">
        <?php foreach ($rooms as $room) { ?>
          <div class="panel panel-default">
            <div class="panel-heading flex justify-between items-center">
              <span class="room_name_main"><?= $room['name'] ?></span>
              <div class="flex justify-center items-center">
                <a href='/room/edit?id=<?= $room['id'] ?>' class='edit_btn flex justify-center items-center text-white text-lg bg-blue-600 hover:bg-blue-700 hover:text-white rounded-lg mx-2 p-2'>Edit</a>
                <a href='/room/delete?id=<?= $room['id'] ?>' class='delete_btn flex justify-center items-center text-white text-lg bg-red-600 hover:bg-red-700 hover:text-white rounded-lg mx-2 p-2'>Delete</a>
              </div>
            </div>
            <div class="panel-body">
              <div class="mb-4">
                <h3 class="font-bold">Description:</h3>
                <?= $room['description'] ?>
              </div>
              <hr>
              <div>
                <h3 class="font-bold mt-2">Member</h3>
                <div class="">
                  <?php foreach ($allUsers as $user) { ?>
                  <?php echo ($room['id'] == $user['room_id'] ?  '<span class="flex"> - ' . $user['name'] . '</span>' : '');
                  } ?>
                </div>
              </div>
              <div>
                <button class='add_member_btn w-36 mt-4 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg my-2 p-2'>Add Member</button>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<div id="modal_room" style="animation: fadeIn 0.5s linear;" class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-alert-id">
  <div class="relative flex justify-center items-center w-auto m-auto max-w-3xl h-screen">
    <!--content-->
    <div class="p-4 bg-white dark:bg-gray-800 m-auto">
      <div class="w-full h-full text-center">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-4xl mt-10 font-bold" style="padding: 0;">LIST USER</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-left flex items-center justify-start">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Room</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($allUsers as $user) { ?>
                  <tr>
                    <td><?= $user['name'] ?></td>
                    <td class="room_name_add"><?= $user['room_name'] ?></td>
                    <td>
                      <input type="checkbox" class='edit_btn flex justify-center items-center text-white text-lg bg-blue-600 hover:bg-blue-700 hover:text-white rounded-lg mx-2 p-2'>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="close_modal_btn btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" disabled>Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="/js/back-js/dashboard.js"></script>