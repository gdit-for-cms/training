<div id="room" name="room" class="mt-6 nav_content ">
    <div class="panel panel-default">
        <div class="panel-heading mb-10 flex items-center justify-between">
            ROOM
            <div>
                <a href='/room/new' class='w-20 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg mx-2 p-2'>Create</a>
            </div>
        </div>
        <hr>
        <div class="panel-body">
            <?php foreach ($rooms as $room) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading flex justify-between items-center">
                        <span class="room_name_main text-xl font-bold bg-white p-2 rounded-lg"><?= $room['name'] ?></span>
                        <div class="flex justify-center items-center">
                            <a href='/room/edit?id=<?= $room['id'] ?>' class='edit_btn flex justify-center items-center text-white bg-blue-600 hover:bg-blue-700 hover:text-white rounded-lg mx-2 p-1'>Edit</a>
                            <a href='/room/delete?id=<?= $room['id'] ?>' class='delete_btn flex justify-center items-center text-white bg-red-600 hover:bg-red-700 hover:text-white rounded-lg mx-2 p-1'>Delete</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="mb-4">
                            <h3 class="font-bold text-lg">Description:</h3>
                            <?= $room['description'] ?>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mt-2">Member</h3>
                            <div class="">
                                <?php foreach ($allUsers as $user) { ?>
                                <?php echo ($room['id'] == $user['room_id'] ?  '<span class="flex"> - ' . $user['name'] . '</span>' : '');
                                } ?>
                            </div>
                        </div>
                        <!-- <div>
                            <button class='add_member_btn w-36 mt-4 flex justify-center items-center text-white text-lg bg-green-600 hover:bg-green-700 hover:text-white rounded-lg my-2 p-2'>Add Member</button>
                        </div> -->
                        <hr>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>