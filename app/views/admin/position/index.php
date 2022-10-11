<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
<div id="position" name="position" class="col-md-10 mt-6 nav_content ">
    <div class="panel panel-default">
        <div class="panel-heading flex items-center justify-between mb-10">
            <span class="text-xl">POSITION</span>
            <div>
                <a href='/position/new' class='w-20 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg mx-2 p-2'>Create</a>
            </div>
        </div>
        <hr>
        <div class="panel-body">
            <?php foreach ($positions as $position) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading flex justify-between items-center">
                        <span class="position text-xl font-bold"><?= $position['name'] ?></span>
                        <div class="flex justify-center items-center">
                            <a href='/position/edit?id=<?= $position['id'] ?>' class='edit_btn flex justify-center items-center text-white bg-blue-600 hover:bg-blue-700 hover:text-white rounded-lg mx-2 p-1'>Edit</a>
                            <a href='/position/delete?id=<?= $position['id'] ?>' class='delete_btn flex justify-center items-center text-white bg-red-600 hover:bg-red-700 hover:text-white rounded-lg mx-2 p-1'>Delete</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="mb-4">
                            <h3 class="text-lg text-gray-400 font-bold">Description:</h3>
                            <?= $position['description'] ?>
                        </div>
                        <div>
                            <h3 class="text-lg text-gray-400 font-bold mt-2">Member</h3>
                            <div class="">
                                <?php foreach ($allUsers as $user) { ?>
                                    <?php echo ($position['id'] == $user['position_id'] ?  '<span class="flex"> - ' . $user['name'] . '</span>' : '');
                                } ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
        </div>
    </div>
</div>