<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Collection exam</h3>
                        </div>
                        <div class="top-right">
                            <?php
                            if ($cur_user['role_id'] != 3) {
                            ?>
                                <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
                                <a class="btn btn-primary mr-3" id="createFilesButton" href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit">Upload exam</a>
                                <a class="btn btn-info mr-3 text-white" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>">Edit</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="card-body d-flex">
                        <div class="mb-6 col-4 mr-12" style="">
                            <div class="mb-3 mr-12">
                                <label class="form-label" for="title">Title </label>
                                <input class="form-control" disabled value="<?php echo $exam['title'] ?>" rows="3" placeholder="title..." />
                            </div>
                            <div class="mb-3  mr-12">
                                <label class="form-label" for="description">Description collection </label>
                                <input class="form-control" disabled value="<?php echo isset($exam['description']) ? $exam['description'] : "" ?>" rows="3" placeholder="description..." />
                            </div>
                        </div>

                        <div class="mb-6 col-2 mr-12" style="">
                            <div class="mb-3 ">
                                <label class="form-label" for="duration">Duration (minutes) </label>
                                <input class="form-control" disabled value="<?php echo $exam['duration'] ?>" rows="3" placeholder="duration..." />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="status">Status </label>
                                <input class="form-control" disabled value="<?php echo $exam['published'] == 1 ? "Đã upload lên server" : " Chưa upload lên server" ?>" rows="3" placeholder="status..." />
                            </div>
                        </div>
                        <div class="col-4 mr-7">
                            <table class="table table-striped table-bordered table-responsive  ">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-rule-body">'
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
                            <a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add email</button></a>

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
                                    <th scope="col">Content Question</th>
                                    <th scope="col">Answer<span>( <span style="padding-left: 20px; background-color: yellow;"></span> : correct)</span></th>

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
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php
                                                    $stt = 1;

                                                    foreach ($answers as $answer) {
                                                        $answer = explode('-', $answer);

                                                        if ($answer['1'] == 1) {
                                                    ?>
                                                            <span style="background-color: yellow; margin-right: 20px;">
                                                                <?php
                                                                echo $stt++ . " ) " . $answer[0] . "<br>";
                                                                ?> </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span style="margin-right: 20px;">
                                                                <?php
                                                                echo $stt++ . " ) " . $answer[0] . "<br>";
                                                                ?> </span>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <?php
                                            if ($cur_user['role_id'] != 3) {
                                            ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                                            <li>
                                                                <button data-question_id="<?php echo $exam_detail['question_id']; ?>" data-exam_id="<?php echo $exam['id']; ?>" type="button" class=" btn-delete-exam-detail dropdown-item">Delete</button>
                                                            </li>

                                                        </ul>
                                                    </div>

                                                </td>
                                            <?php
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
                                <ul class="pagination">
                                    <?php
                                    $next = $page;
                                    if ($page <= $numbers_of_page) {
                                    ?>
                                        <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=1" class="page-link">
                                                << </a>
                                        </li>
                                        <?php
                                        if ($page > 1) {
                                        ?>
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

                                        <?php
                                        }
                                        ?>
                                        <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
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