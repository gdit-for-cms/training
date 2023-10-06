<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Exam collection</h4>
            <a href='/admin/exam/new'><button type="button" class="btn btn-success">Create collection</button></a>
        </div>
    </div>
    <div class="box_body white_card_body">
        <div class="default-according" id="accordion2">
            <div class="flex col-6 mb-6">
                <div class="input-button-group">
                    <input id="searchInput" type="search" class="form-control rounded" style="width: 425px;" placeholder="Search..." aria-label="Search" aria-describedby="search-addon" />
                    <!-- <button type="button" data-path="question-title" data-id="all" class="btn btn-danger text-white btn-delete-question btn-delete-select">Delete</button> -->
                    <button type="button" data-path="exam" data-id="select" class="btn btn-danger text-white btn-delete-select-all btn-delete-select" style="display: none;">Delete</button>
                </div>
            </div>
            <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">

                <table id="<?= "1" ?>" class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <!-- <span>Select All</span><br> -->
                                <input type="checkbox" id="selectAll" class=" selectAll" name="select_all">
                            </th>

                            <th>#</th>
                            <th>TITLE</th>
                            <th>
                                STATUS
                                <select class="role_select select_option w-26 text-medium border " name="role_id" aria-label="Default select example">
                                    <option value="0" selected="">All</option>
                                    <option value="1">Not Started</option>
                                    <option value="2">In Progress</option>
                                    <option value="3">Completed</option>
                                </select>
                            </th>

                            <!-- <th>AUTHOR</th> -->
                            <th>
                                PUBLISH
                                <select class="role_select select_option w-26 text-medium border " name="role_id" aria-label="Default select example">
                                    <option value="0" selected="">All</option>
                                    <option value="1">Published</option>
                                    <option value="2">Unpublished</option>
                                </select>
                            </th>
                            <th>TIME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="body_table_main" id="table_result">
                        <?php
                        $stt = 1;
                        foreach ($exams as $exam) {
                            $check_finished = false;
                            $check_progress = false;
                        ?>
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" value="<?php echo $exam['id']; ?>" name="item[]" class="checkbox" id="">
                                </th>
                                <th scope="row"><?php echo $stt++; ?></th>
                                <td class="text-ellipsis">
                                    <?php echo $exam['title'] ?>
                                </td>
                                <td>
                                    <?php
                                    // date_default_timezone_set('Asia/Tokyo');
                                    $startTime = strtotime($exam['time_start']);
                                    $endTime = strtotime($exam['time_end']);
                                    $currentTime = time();

                                    // Lấy thời gian hiện tại của Tokyo

                                    // $timezone = date_default_timezone_get();
                                    // echo "Múi giờ hiện tại: " . $timezone;
                                    // echo date('Y-m-d H:i:s');
                                    // var_dump($endTime);
                                    // var_dump($currentTime);
                                    // die();
                                    if ($currentTime < $startTime || empty($startTime)) {
                                        $check_finished = true; ?>
                                        <span style="color: #FF0000;">Not Started</span>
                                    <?php

                                    } elseif ($currentTime >= $startTime && $currentTime <= $endTime) {
                                        $check_progress = true;
                                    ?>
                                        <span style="color: #3c7cdb;">In Progress</span>
                                    <?php
                                    } elseif ($endTime < $currentTime) {
                                    ?>
                                        <span style="color: #008000;">Finished</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="overflow-auto">
                                        <?php echo $exam['published'] == 1 ? 'Đã xuất bản' : 'Chưa xuất bản'; ?><br>
                                        <?php echo $exam['uploaded_at'] ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    if (isset($exam['time_start']) && isset($exam['time_end'])) {
                                    ?>
                                        <?php echo $exam['time_start'] ?><br>

                                        <?php echo $exam['time_end'] ?>
                                    <?php } else {
                                    ?>
                                        <!-- Thời gian làm bài exam chưa có -->
                                    <?php
                                    } ?>
                                </td>

                                <td>
                                    <div style="display: flex;">
                                        <a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>"><button type="button" class="btn btn-success mr-2">Detail</button></a>
                                        <?php if ($check_finished) { ?>
                                            <a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>"><button type="button" class="btn btn-info text-white mr-2">Edit</button></a>
                                        <?php } ?>
                                        <?php if (!$check_progress) { ?>
                                            <button type="button" data-path="exam" data-id="<?php echo $exam['id']; ?>" class="btn btn-danger text-white btn-delete-question mr-2">Delete</button>
                                        <?php } ?>

                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <div class="flex justify-center items-center">
                    <nav aria-label="Page navigation example">
                        <ul class="paginations" id="paginations">
                            <?php
                            $next = $page;
                            if ($page <= $numbers_of_page) {
                                if ($page > 1) {
                            ?>
                                    <li class=" cursor-pointer"><a href="/admin/exam/index?page=1">
                                            << </a>
                                    </li>
                                    <li class="  cursor-pointer"><a href="/admin/exam/index?page=<?php $page--;
                                                                                                    echo $page; ?>">Previous</a></li>
                                <?php
                                }
                                ?>
                                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                    <li class=" cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/index?page=<?php echo $i; ?>"><?= $i ?></a></li>
                                <?php }
                                if ($next < $numbers_of_page) {
                                ?>
                                    <li class=" cursor-pointer"><a href="/admin/exam/index?page=<?php echo $next += 1; ?>">Next</a></li>
                                    <li class=" cursor-pointer"><a href="/admin/exam/index?page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>">>></a></li>

                                <?php
                                }
                                ?>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //search
    // const searchInput = document.getElementById("searchInput");
    const paginationContainer = document.getElementById("paginations");
    let selectAllCheckboxes = document.getElementsByClassName("selectAll");
    let checkboxes = document.getElementsByClassName("checkbox");
    let checkboxesArray = Array.from(checkboxes);


    // var selectAllCheckbox = document.getElementById("selectAll");
    // var checkboxes = document.querySelectorAll(".checkbox");

    // // Thêm sự kiện click vào checkbox "Select All"
    // selectAllCheckbox.addEventListener("click", function() {
    //     alert("a");
    //     checkboxes.forEach(function(checkbox) {
    //         checkbox.checked = selectAllCheckbox.checked;
    //     });
    // });
</script>