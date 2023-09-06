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
                                <div>
                                    <form action="/admin/exam/export" class="" method="post">
                                        <input type="hidden" name="exam_id" value="<?php echo $exam['id'] ?>">
                                        <input type="hidden" name="exam_title" value="<?php echo htmlspecialchars($exam['title']); ?>">
                                    </form>
                                </div>
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

                                    foreach ($question_answers as $question_answer) { ?>
                                        <tr>
                                            <th scope="row">1</th>

                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php echo $question_answer['question']['title'] ?>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php echo $question_answer['question']['content'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                    <?php
                                                    $stt = 1;

                                                    foreach ($question_answer['answers'] as $answer) {
                                                        if ($answer['is_correct'] == 1) {
                                                    ?>
                                                            <span style="background-color: #e0eb37; margin-right: 20px;">
                                                                <?php
                                                                echo $stt++ . " ) " . $answer['content'] . "<br>";
                                                                ?> </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span style="margin-right: 20px;">
                                                                <?php
                                                                echo $stt++ . " ) " . $answer['content'] . "<br>";
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
                                                        <a href=" /admin/exam/edit?id=<?php echo $question_answer['question']['id']; ?>" class="btn btn-primary text-white mx-1 ">Edit</a>
                                                        <button data-id="<?php echo $question_answer['question']['id']; ?>" type="button" class="btn btn-danger btn-delete-rule text-white ">Delete</button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
