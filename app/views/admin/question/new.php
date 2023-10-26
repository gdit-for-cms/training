<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0 ">Collection question</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body" style="margin-left: 15px;">
            <div class="card-body d-flex">
                <div class="mb-3 col-10 mr-12">
                    <?php
                    if ($question_title != false) { ?>
                        <b><label class="form-label" for="title">Title : </label></b>
                        <?php echo $question_title['title']; ?>
                        <br>
                        <b><label class="form-label" for="title">Description : </label></b>
                        <?php echo isset($question_title['description']) ? $question_title['description'] : "" ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30" ">
        <div class=" white_card_header">
        <div class="box_header m-0">
            <div class="main-title">
                <h3 class="m-0">New questions</h3>
            </div>
        </div>
    </div>
    <div class="white_card_body">
        <div class="card-body">
            <form id="form_new_question" action="create" method="POST">
                <?php if (isset($exam_id)) {
                ?>
                    <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                <?php
                } ?>
                <?php if ($question_title != false) { ?>
                    <input type="hidden" name="question_title_id" value="<?php echo $question_title['id']; ?>">
                <?php } ?>
                <div class="mb-3">
                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea id="editor-edit-note" class="form-control" name="content" rows="3"><?php  ?></textarea>
                </div>


                <div class="mb-5">
                    <i class="bi bi-exclamation-circle"></i>
                    <span class="myDIV text-danger">* Note</span>
                    <div class="hide-note">
                        <p style="padding-left: 20px;">
                            Correct : Choose the correct answers<br>
                            Answer : Enter the answer to the question<br>
                            Button Add : Click the "add" button to add an answer
                        </p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="correct" style="margin-right: 30px;">Correct <span class="text-danger">*</span></label>
                    <label class="form-label" for="answer">Answer <span class="text-danger">*</span></label>
                    <div class="col-12 d-flex">
                        <div id="answerContainer">
                            <div class="form-check mb-3" style="padding-left: 45px;">
                                <input class="form-check-input col-1" style="margin-right: 50px; margin-top: 15px;" name="is_correct[]" type="checkbox" value="0" onchange="updateCheckboxValue(this)">
                                <div class="input-with-button">
                                    <input type="text" class="form-control input-answer" name="answer[]" value="" placeholder="answer..."></input>
                                    <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="input-add-answer col-3">
                            <button type="button" class="btn btn-info ml-3 text-white" style="margin-top: 3px;" onclick="addAnswer()">Add</button>
                        </div>
                    </div>

                </div>
                <button id="submit" type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        heightCkeditor();
    });
    // Biến tạm để lưu giá trị của ô input hiện tại
    var currentAnswerIndex = 1;
    // Mảng lưu vị trí các checkbox đã chọn
    var selectedPositions = [];
    const form = document.querySelector('#form_new_question');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        updateIsCorrectValues();
    })
</script>