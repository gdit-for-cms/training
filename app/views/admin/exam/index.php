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
                            <th>#</th>
                            <th>TITLE</th>
                            <th>AUTHOR</th>
                            <th>STATUS</th>
                            <th>DATE</th>
                            <th>TIME START</th>
                            <th>TIME END</th>
                            <th><span>DURATION</span><br> <span>(minutes)</span></th>
                            <th>LAST UPDATE</th>
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
                                <th scope="row" ><?php echo $stt++; ?></th>
                                <td class="text-ellipsis">
                                    <?php echo $exam['title'] ?>
                                </td>

                                <td class="text-ellipsis">
                                    Admin 1
                                </td>
                                <td></td>
                                <td>
                                    <div class="overflow-auto">
                                        <?php echo $exam['published'] == 1 ? 'Đã xuất bản' : 'Chưa xuất bản'; ?><br>
                                         __ngày/tháng/năm giờ/phút__
                                    </div>
                                </td>
                                <td>
                                    <?php echo $exam['updated_at'] ?>
                                </td>
                                <td>
                                    <?php echo $exam['updated_at'] ?>
                                </td>

                                <td class=" text-center"><?php echo $exam['duration']; ?></td>
                                <td>
                                    <?php echo $exam['updated_at'] ?>
                                </td>
                                <!-- <td style=" align-items: center;">
                                    <?php if ($exam['published'] == 1) { ?>
                                        <button onclick="copyLink('linkToCopy<?php echo $exam['id']; ?>')" class="linkToCopy text-primary-hover" id="linkToCopy<?php echo $exam['id']; ?>" href="<?php echo $directory['domain'] . $exam['id'] . '.html' ?>"><?php echo $directory['domain'] . $exam['id'] . '.html' ?> </button>
                                    <?php } ?>
                                </td> -->
                                <td>
                                    <div class="dropdown">
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
                                            <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                            <li>
                                                <button type="button" data-path="exam" data-id="<?php echo $exam['id']; ?>" class="dropdown-item btn-delete-question ">Delete</button>
                                            </li>
                                            <!-- <li><a class="dropdown-item" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>">Participant Email</a></li> -->
                                        </ul>
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
</script>