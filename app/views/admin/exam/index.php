<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Exam collection</h4>
            <a href='/admin/exam/new'><button type="button" class="btn btn-success">Create collection</button></a>
        </div>
    </div>
    <div class="box_body white_card_body">
        <div class="default-according" id="accordion2">
            <div class="flex col-4 mb-6">
                <input id="searchInput" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            </div>
            <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">

                <table id="<?= "1" ?>" class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <!-- <span>Select All</span><br> -->
                                <input type="checkbox" id="selectAll" class="checkbox" name="select_all">
                            </th>

                            <th>#</th>
                            <th>TITLE</th>
                            <th>
                                STATUS
                                <select class="role_select select_option w-26 text-medium border " name="role_id" aria-label="Default select example">
                                    <option value="0" selected="">All</option>
                                    <option value="1">Note Started</option>
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
                            <!-- <th>TIME START</th>
                            <th>TIME END</th> -->
                            <!-- <th><span>DURATION</span><br> <span>(minutes)</span></th> -->
                            <!-- <th>LAST UPDATE</th> -->
                            <!-- <th>LINK EXAM</th> -->
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="body_table_main" id="table_result">
                        <?php
                        $stt = 1;
                        foreach ($exams as $exam) {
                        ?>
                            <tr>
                                <th class="text-center"><input type="checkbox" value="<?php echo $exam['id']; ?>" name="item[]" class="checkbox" id=""></th>
                                <th scope="row"><?php echo $stt++; ?></th>
                                <td class="text-ellipsis">
                                    <?php echo $exam['title'] ?>
                                </td>
                                <td>
                                    In Progress
                                </td>
                                <!-- <td class="text-ellipsis">
                                    Admin 1
                                </td> -->
                                <!-- <td></td> -->
                                <td>
                                    <div class="overflow-auto">
                                        <?php echo $exam['published'] == 1 ? 'Đã xuất bản' : 'Chưa xuất bản'; ?><br>
                                        __ngày/tháng/năm giờ/phút__
                                    </div>
                                </td>
                                <td>
                                    <?php echo $exam['updated_at'] ?><br>
                                    <!-- </td>
                                <td> -->
                                    <?php echo $exam['updated_at'] ?>
                                </td>

                                <!-- <td class=" text-center"><?php echo $exam['duration']; ?></td> -->
                                <!-- <td>
                                    <?php echo $exam['updated_at'] ?>
                                </td> -->
                                <!-- <td style=" align-items: center;">
                                    <?php if ($exam['published'] == 1) { ?>
                                        <button onclick="copyLink('linkToCopy<?php echo $exam['id']; ?>')" class="linkToCopy text-primary-hover" id="linkToCopy<?php echo $exam['id']; ?>" href="<?php echo $directory['domain'] . $exam['id'] . '.html' ?>"><?php echo $directory['domain'] . $exam['id'] . '.html' ?> </button>
                                    <?php } ?>
                                </td> -->
                                <td>
                                    <a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>"><button type="button" class="btn btn-success">Detail</button></a>
                                    <a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                                    <button type="button" data-path="exam" data-id="<?php echo $exam['id']; ?>" class="btn btn-danger text-white btn-delete-question ">Delete</button>
                                    <!-- <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li><a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>" class="dropdown-item">Add question to exam</a></li>
                                            <li><a id="createFilesButton" href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit" class="dropdown-item">Publish exam</a></li>
                                            <?php if ($exam['published'] == 1) { ?>
                                                <li><a href="/admin/exam/unpublish?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit" class="dropdown-item">UnPublish exam</a></li>
                                            <?php } ?>
                                            <li><a class="dropdown-item" href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>">Detail</a></li>
                                            <li><a class="dropdown-item" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>">Edit </a></li>
                                            <li>
                                                <button type="button" data-path="exam" data-id="<?php echo $exam['id']; ?>" class="dropdown-item btn-delete-question ">Delete</button>
                                            </li>
                                        </ul>
                                    </div> -->
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <!-- <div class="">
                    <img class="selectallarrow" src="./themes/pmahomme/img/arrow_ltr.png" width="38" height="22" alt="With selected:">
                    <input type="checkbox" id="tablesForm_checkall" class="checkall_box" title="Check all">
                    <label for="tablesForm_checkall">Check all</label>
                    <select name="submit_mult" style="margin: 0 3em 0 3em;">
                        <option value="With selected:" selected="selected">With selected:</option>
                        <option value="copy_tbl">Copy table</option>
                        <option value="show_create">Show create</option>
                        <option value="export">Export</option>
                        <optgroup label="Delete data or table">
                            <option value="empty_tbl">Empty</option>
                            <option value="drop_tbl">Drop</option>
                        </optgroup>
                        <optgroup label="Table maintenance">
                            <option value="analyze_tbl">Analyze table</option>
                            <option value="check_tbl">Check table</option>
                            <option value="checksum_tbl">Checksum table</option>
                            <option value="optimize_tbl">Optimize table</option>
                            <option value="repair_tbl">Repair table</option>
                        </optgroup>
                        <optgroup label="Prefix">
                            <option value="add_prefix_tbl">Add prefix to table</option>
                            <option value="replace_prefix_tbl">Replace table prefix</option>
                            <option value="copy_tbl_change_prefix">Copy table with prefix</option>
                        </optgroup>
                    </select>
                </div> -->
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


    // <input type="checkbox" id="selectAll" class="checkbox" name="select_all">

    // Lấy tham chiếu đến checkbox "Select All" và tất cả các checkbox khác
    var selectAllCheckbox = document.getElementById("selectAll");
    var checkboxes = document.querySelectorAll(".checkbox");

    // Thêm sự kiện click vào checkbox "Select All"
    selectAllCheckbox.addEventListener("click", function() {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // // Thêm sự kiện click vào từng checkbox để kiểm tra trạng thái "Select All"
    // checkboxes.forEach(function(checkbox) {
    //     checkbox.addEventListener("click", function() {
    //         selectAllCheckbox.checked = checkboxes.every(function(c) {
    //             return c.checked;
    //         });
    //     });
    // });
</script>