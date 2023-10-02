<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit collection</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_create_exam" class="" action="update" method="POST">
                    <input class="form-control" type="hidden" value="<?php echo $exam['id']; ?>" rows="3" name="id" />

                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="card-body d-flex">
                                    <!-- <form id="form_new_question col-12" class="" action="create" method="POST"> -->
                                    <div class="mb-6 col-4 mr-12" style="">
                                        <div class="mb-3 mr-12">
                                            <label class="form-label" for="title">Title </label>
                                            <input class="form-control" name="title" value="<?php echo $exam['title'] ?>" rows="3" placeholder="title..." />
                                        </div>
                                        <div class="mb-3  mr-12">
                                            <label class="form-label" for="description">Description collection </label>
                                            <input class="form-control" name="description" value="<?php echo isset($exam['description']) ? $exam['description'] : "" ?>" rows="3" placeholder="description..." />
                                        </div>
                                    </div>

                                    <div class="mb-6 col-2 mr-12" style="">

                                        <div class="mb-3">
                                            <label class="form-label" for="status">Status </label>
                                            <input class="form-control" disabled value="<?php echo $exam['published'] == 1 ? "Đã upload lên server" : " Chưa upload lên server" ?>" rows="3" placeholder="status..." />
                                        </div>
                                    </div>
                                    <div class="col-4 mr-7">

                                        <div id="answerContainer">
                                            <label class="form-label" for="email">Email participant</label>
                                            <!-- Ô input mặc định -->
                                            <?php if (count($emails) > 0) {
                                                foreach ($emails as $email) { ?>
                                                    <div class="form-check" style="padding-left: 45px;">
                                                        <div class="input-with-button">
                                                            <input type="text" class="form-control input-answer" name="email[]" value="<?php echo $email['email']; ?>" placeholder="Email...">
                                                            <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                                        </div>
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                        <div class="input-add-answer">
                                            <button type="button" class="btn btn-info m-2 text-white" onclick="addAnswer()">Add</button>
                                        </div>

                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

    </div>
</div>
<div class="col-lg-12">

    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit select questions</h3>
                </div>
                <div class="top-right">
                    <?php
                    if ($cur_user['role_id'] != 3) {
                    ?>
                        <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
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
                                        <div class="overflow-auto">
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
                                            <button data-question_id="<?php echo $exam_detail['question_id']; ?>" data-exam_id="<?php echo $exam['id']; ?>" type="button" class="btn btn-danger delete-btn btn-delete-exam-detail">Delete</button>
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
                        <ul class="paginations">
                            <?php
                            $next = $page;
                            if ($page <= $numbers_of_page) {
                            ?>

                                <?php
                                if ($page > 1) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=1" class="page-link">
                                            << </a>
                                    </li>
                                    <li class=" page-item cursor-pointer"><a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=<?php $page--;
                                                                                                                                        echo $page; ?>" class="page-link">Previous</a></li>
                                <?php
                                }
                                ?>
                                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                    <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                <?php }
                                if ($next < $numbers_of_page) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/edit/id=<?php echo $exam['id']; ?>&page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>

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