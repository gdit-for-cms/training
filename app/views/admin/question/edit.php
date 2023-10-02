<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit questions</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_update_question" class="" action="update" method="POST">
                    <input id="id" name="id" value="<?= $question['id'] ?>" type="hidden" class="form-control">
                    <div class="mb-3">
                        <label for="content" class="form-label">Content*</label>
                        <textarea id="editor-edit-note" class="form-control h-120px" name="content" rows="3"><?php  ?>
                            <?php echo $question['content']; ?>
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <p>* Note</p>
                        <p class="" style="padding-left: 20px;">
                            Correct : Choose the correct answers<br>
                            Answer : Enter the answer to the question<br>
                            Button Add : Click the "add" button to add an answer
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="margin-right: 30px;" for="correct">Correct*</label>
                        <label class="form-label" for="answer">Answer*</label>
                        <div id="answerContainer">
                            <!-- Ô input mặc định -->
                            <?php
                            foreach ($answers as $answer) {
                            ?>
                                <div class="form-check" style="padding-left: 45px;">
                                    <input class="form-check-input" style="margin-right: 50px;" name="is_correct[]" type="checkbox" <?php if ($answer['is_correct'] == 1) {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> value="<?php echo $answer['is_correct'] ?>" onchange="updateCheckboxValue(this)">
                                    <div class="input-with-button">
                                        <input type="text" class="form-control input-answer" name="answer[]" value="<?php echo $answer['content'] ?>" placeholder="Answer...">
                                        <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                        <div class="input-add-answer">
                            <button type="button" class="btn btn-info m-2 text-white" onclick="addAnswer()">Add</button>
                        </div>
                    </div>
                    <a class="btn btn-danger" href="/admin/question/index" class="page-link">Back</a>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
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
    var currentAnswerIndex = 0;
    // Mảng lưu vị trí các checkbox đã chọn
    var selectedPositions = [];

    const form = document.querySelector('#form_update_question');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        updateIsCorrectValues();
    })
</script>