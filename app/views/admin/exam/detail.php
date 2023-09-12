<?php
// echo "<pre>";
// var_dump($question_answers);
// $answers = explode(',', $question_answers[0]['answers']);
// $answer = explode('-', $answers[0]);
// var_dump($answer);
// die();
?>
<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_box card_height_100 mb_30">
                <div class="px-4 pt-4">
                    <div class="main-title2 d-flex justify-content-between items-center ">

                        <div class="top-left d-flex">
                            <h4 class="mb-2 nowrap">List Exams</h4>
                            <h4 class="mb-2 nowrap fw-bold"> <?php if (isset($exam['title'])) {
                                                                    echo ': ' . htmlspecialchars($exam['title']);
                                                                } ?>
                            </h4>
                        </div>
                        <div class="top-right">
                            <?php
                            if ($cur_user['role_id'] != 3) {
                            ?>
                                <a href="/admin/exam/create?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
                                <a href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>"><button data-id="<?php echo $exam['id']; ?>" type="button" class="btn btn-primary btn-show-preview-exam text-white  mr-2">Preview</button></a>
                                <!-- <button id="createFilesButton" data-id="<?php echo $exam['id'] ?>" id="submit" class="btn btn-primary btn-upload-file-ftp">Upload</button> -->
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="table-responsive m-b-30">
                        <table class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title Question</th>
                                    <th scope="col">Content Question</th>
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
                                if (!empty($question_answers)) {
                                    $st = 1;
                                    foreach ($question_answers as $question_answer) {
                                        $answers = explode(',', $question_answer['answers']);
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $st++; ?></th>

                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php echo $question_answer['question_title'] ?>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php echo $question_answer['question_content'] ?>
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
                                                            <span style="background-color: #e0eb37; margin-right: 20px;">
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
                                                    <div class="d-flex ">
                                                        <a href=" /admin/exam/detail-edit?question_id=<?php echo $question_answer['question_id']; ?>&exam_id=<?php echo $exam['id']; ?>" class="btn btn-primary text-white mx-1 ">Edit</a>
                                                        <button data-id="<?php echo $question_answer['question_id']; ?>" type="button" class="btn btn-danger btn-delete-exam-detail text-white ">Delete</button>
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
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?= $exam['id'] ?>&page=1" class="page-link">
                                            << </a>
                                    </li>
                                    <?php
                                    $next = $page;
                                    if ((int)$page > 1) {
                                    ?>
                                        <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?= $exam['id'] ?>&page=<?php $page--;
                                                                                                                                                echo $page; ?>" class="page-link">Previous</a></li>
                                    <?php
                                    }
                                    ?>
                                    <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                        <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/examDetail?exam_id=<?= $exam['id'] ?>&page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                    <?php }
                                    if ($next != $numbers_of_page) {
                                    ?>
                                        <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?= $exam['id'] ?>&page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>

                                    <?php
                                    }
                                    ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?= $exam['id'] ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>