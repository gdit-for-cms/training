<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0 fs-2">Collection exam</h3>
                        </div>
                        <div class="top-right">
                            <?php
                            $startTime = strtotime($exam['time_start']);
                            $endTime = strtotime($exam['time_end']);
                            $check_status = false;
                            $currentTime = time();

                            if ($currentTime < $startTime) {
                                $check_status = true; ?>
                                <?php

                            }
                            if ($cur_user['role_id'] != 3) {
                                if ($check_status) {
                                ?>

                                    <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
                                    <a class="btn btn-primary mr-3" id="createFilesButton" href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit">Upload exam</a>
                                    <!-- <a class="btn btn-info mr-3 text-white" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>">Edit</a> -->
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ml-10">
                    <div class="card-body d-flex ">
                        <?php
                        // echo "<pre>";
                        // var_dump($exam);
                        // die();
                        ?>
                        <div class="mb-3 col-4 mr-10" style="">
                            <b><label class="form-label" for="title">Title : </label></b>
                            <?php echo $exam['title'] ?>
                            <br>
                            <b><label class="form-label" for="author">Author : </label></b>
                            <?php echo $user[0]['name'] ?>
                            <br>
                            <b><label class="form-label" for="description">Description : </label></b>
                            <?php echo isset($exam['description']) ? $exam['description'] : "Chưa có mô tả"; ?>
                            <br>
                            <b><label class="form-label" for="status">Status : </label></b>
                            <?php

                            if ($currentTime < $startTime) {
                            ?>
                                <span style="color: #FF0000;">Not Started</span>
                            <?php

                            } elseif ($currentTime >= $startTime && $currentTime <= $endTime) { ?>
                                <span style="color: #3c7cdb;">In Progress</span>
                            <?php
                            } else {
                            ?>
                                <span style="color: #008000;">Finished</span>
                            <?php
                            }
                            ?>
                            <br>

                            <b><label class="form-label" for="status">Publish </label></b>
                            <?php echo $exam['published'] == 1 ? "Đã upload lên server" : " Chưa upload lên server" ?>

                            <?php
                            if ($exam['published'] == 1) {
                                // $directory['domain'] = "asd"; 
                            ?>
                                <br>
                                <b><label class="form-label" for="link_exam">Link exam </label></b>
                                <button onclick="copyLink('linkToCopy<?php echo $exam['id']; ?>')" class="linkToCopy text-primary-hover" id="linkToCopy<?php echo $exam['id']; ?>" href="<?php echo $directory['domain'] . $exam['id'] . '.html' ?>"><?php echo $directory['domain'] . $exam['id'] . '.html' ?> </button>

                            <?php                                }

                            ?>
                            <br>
                            <b><label class="form-label" for="time_start">Time start : </label></b>
                            <?php echo isset($exam['time_start']) ? $exam['time_start'] : "Chưa có thời gian làm bài!" ?>
                            <br>
                            <b><label class="form-label" for="time_end">Time end : </label></b>
                            <?php echo isset($exam['time_end']) ? $exam['time_end'] : "Chưa có thời gian làm bài!" ?>
                            <br>
                            <!-- <b><label class="form-label" for="email">Email : </label></b> -->
                        </div>
                        <div class="col-5 ml-15">
                            <b><label class="form-label" for="email">Email : </label></b>
                            <table class="table table-striped table-bordered table-responsive">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-rule-body">
                                    <?php
                                    if (count($emails) > 0) {
                                        $stt = 1;
                                        foreach ($emails as $email) {
                                    ?>
                                            <tr class="text-center">
                                                <td><?php echo $stt++; ?></td>
                                                <td><?php echo $email['email'] ?></td>
                                                <td><?php echo $email['is_submit'] == 2 ? "Chưa nộp bài" : "Đã nộp bài"; ?></td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr class="text-center">
                                            <td colspan="3">Empty</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- <a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add email</button></a> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="px-4 pt-4">
                    <div class="main-title2 d-flex justify-content-between items-center ">

                        <div class="top-left d-flex">
                            <h4 class="mb-2 nowrap">List question</h4>

                        </div>

                    </div>
                </div>
                <div class="white_card_body">
                    <div class="table-responsive m-b-30">
                        <table class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Answer</th>

                                    <?php
                                    if ($cur_user['role_id'] != 3) {
                                    ?>
                                        <th scope="col">Option</th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody class="table-rule-body">
                                <?php
                                if (!empty($exam_details)) {
                                    $st = 1;
                                    foreach ($exam_details as $exam_detail) {
                                        $answers = explode(',', $exam_detail['answers']);
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $st++; ?></th>
                                            <td>
                                                <div class="overflow-auto">
                                                    <?php echo $exam_detail['question_content'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <!-- <div class="overflow-auto"> -->
                                                <div class="answer-container">
                                                    <ul>
                                                        <?php
                                                        $stt = 1;

                                                        foreach ($answers as $answer) {
                                                            $answer = explode('-', $answer);

                                                            if ($answer['1'] == 1) {
                                                        ?>
                                                                <li class="text-ellipsis" style="font-weight:bold;color:blue ;border: 1px solid; padding: 1px; border-radius:2px; margin-bottom: 7px;"><?php echo  $answer[0] ?> </li>

                                                            <?php
                                                            } else { ?>
                                                                <li class="text-ellipsis" style="border: 1px solid; padding: 1px; border-radius:2px;margin-bottom: 7px;"><?php echo  $answer[0] ?> </li>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </td>
                                            <?php
                                            if ($cur_user['role_id'] != 3) {
                                                if ($check_status) {
                                            ?>
                                                    <td class="col-2">
                                                        <a href="/admin/question/edit?question_id=<?php echo $exam_detail['question_id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                                                        <button data-question_id="<?php echo $exam_detail['question_id']; ?>" data-exam_id="<?php echo $exam['id']; ?>" type="button" class=" btn btn-danger text-white btn-delete-exam-detail">Delete</button>
                                                    </td>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tr>
                                    <?php }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9" class='text-center h-100'>Empty</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="flex justify-center items-center">
                            <nav aria-label="Page navigation example">
                                <ul class="paginations">
                                    <?php
                                    $next = $page;
                                    if ($page <= $numbers_of_page) {
                                    ?>

                                        <?php
                                        if ($page > 1) {
                                        ?>
                                            <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=1" class="page-link">
                                                    << </a>
                                            </li>
                                            <li class=" page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php $page--;
                                                                                                                                                            echo $page; ?>" class="page-link">Previous</a></li>
                                        <?php
                                        }
                                        ?>
                                        <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                            <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                        <?php }
                                        if ($next < $numbers_of_page) {
                                        ?>
                                            <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>
                                            <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>

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
    </div>
</div>
<script>
    const paginationContainer = document.getElementById("paginations");
</script>