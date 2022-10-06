<link href="/css/dashboard.css" rel="stylesheet">
<div class="container-fluid main-container">
    <div class="col-md-2 sidebar">
        <div class="row">
            <!-- uncomment code for absolute positioning tweek see top comment in css -->
            <div class="absolute-wrapper"> </div>
            <!-- Menu -->
            <div class="side-menu">
                <nav class="navbar navbar-default" role="navigation">
                    <!-- Main Menu -->
                    <div class="side-menu-container">
                        <ul class="nav navbar-nav w-full">
                            <li class="active nav_item"><a href="#"><span class="glyphicon glyphicon-dashboard"></span>User</a></li>
                            <li class="nav_item"><a href="#"><span class="glyphicon glyphicon-plane"></span>Role</a></li>
                            <li class="nav_item"><a href="#"><span class="glyphicon glyphicon-cloud"></span>Room</a></li>
                          

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>

            </div>
        </div>
    </div>
    <div id="user" name="user" class="col-md-10 nav_content hidden">
        <div class="panel panel-default">
            <div class="panel-heading">
                USER
            </div>
            <div class="panel-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Role</th>
                  <th scope="col">Room</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($allUsers as $user) { ?>
                <tr>
                  <th scope="row"><?= $user['id'] ?></th>
                  <td><?= $user['name'] ?></td>
                  <td><?= $user['email'] ?></td>
                  <td><?= $user['role_name'] ?></td>
                  <td><?= $user['room_name'] ?></td>
                  <td class="flex">
                  <a href='/viewPost.php?post_id=$post_id' class='view_btn flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg mx-2 p-2'>View</a>
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
    <div id="role" name="role" class="col-md-10 nav_content hidden">
        <div class="panel panel-default">
            <div class="panel-heading">
                ROLE
            </div>
            <div class="panel-body flex">
              <div class="panel panel-default w-1/2 mx-2">
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
                      <?php foreach($admins as $admin) { ?>
                        <th scope="row"><?= $admin['id'] ?></th>
                        <td><?= $admin['name'] ?></td>
                        <td><?= $admin['email'] ?></td>
                      <?php } ?>
                    </tbody>
                  </table>                      
                </div>
              </div>
              <div class="panel panel-default w-1/2 mx-2">
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
                      <?php foreach($users as $user) { ?>
                        <th scope="row"><?= $user['id'] ?></th>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                      <?php } ?>
                    </tbody>
                  </table>                      
                </div>
              </div>
            </div>
        </div>
    </div>
    <div id="room" name="room" class="col-md-10 nav_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                ROOM
            </div>
            <div class="panel-body">
              <?php foreach($rooms as $room) { ?>
              <div class="panel panel-default">
                  <div class="panel-heading flex justify-between items-center">
                      <?= $room['name'] ?>
                      <div class="flex justify-center items-center">
                        <a href='/room/edit?id=<?= $room['id'] ?>' class='edit_btn flex justify-center items-center text-white text-lg bg-blue-600 hover:bg-blue-700 hover:text-white rounded-lg mx-2 p-2'>Edit</a>
                        <a href='/room/delete?id=<?= $user['id'] ?>' class='delete_btn flex justify-center items-center text-white text-lg bg-red-600 hover:bg-red-700 hover:text-white rounded-lg mx-2 p-2'>Delete</a>
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
                      <?php foreach($allUsers as $user) { ?>
                        <?= $room['id'] == $user['room_id'] ? $user['name'] : ''?>
                      <?php } ?>
                    </div>
                    <div>
                    <button class='w-36 mt-4 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg my-2 p-2'>Add Member</button>
                    </div>
                  </div>
              </div>
              <?php } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/dashboard.js"></script>
