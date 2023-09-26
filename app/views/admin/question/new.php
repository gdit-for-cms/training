<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Collection question</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body d-flex">
                <div class="mb-3 col-5 mr-12" style="">
                    <label class="form-label" for="title">Title collection </label>
                    <input class="form-control" rows="3" disabled value="<?php echo $question_title['title']; ?>" placeholder="Title..." />
                </div>
                <div class="mb-3 col-5">
                    <label class="form-label" for="title">Description collection </label>
                    <input class="form-control" disabled value="<?php echo isset($question_title['description']) ? $question_title['description'] : "" ?>" rows="3" placeholder="description..." />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New questions</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_new_question" class="" action="create" method="POST">
                    <input type="hidden" name="question_title_id" value="<?php echo $question_title['id']; ?>">
                    <div class="mb-3">
                        <label for="content" class="form-label">Content*</label>
                        <textarea id="editor-edit-note" class="form-control h-120px" name="content" rows="3"><?php  ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="correct" style="margin-right: 30px;">Correct*</label>
                        <label class="form-label" for="answer">Answer*</label>
                        <div id="answerContainer">
                            <div class="form-check" style="padding-left: 45px;">
                                <input class="form-check-input" style="margin-right: 50px;" name="is_correct[]" type="checkbox" value="0" onchange="updateCheckboxValue(this)">
                                <div class="input-with-button">
                                    <input type="text" class="form-control input-answer" name="answer[]" value="" placeholder="answer...">
                                    <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="input-add-answer">
                            <button type="button" class="btn btn-info m-2" onclick="addAnswer()">Thêm</button>
                        </div>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Biến tạm để lưu giá trị của ô input hiện tại
    var currentAnswerIndex = 1;
    // Mảng lưu vị trí các checkbox đã chọn
    var selectedPositions = [];


    function start() {
        checkChangeInput(titleInput)
        checkChangeInput(contentInput)
    }

    function validate() {
        if (titleInput.value == '') {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }

    function checkChangeInput(input) {
        input.addEventListener('keyup', () => {
            validate()
        })
    }
    const form = document.querySelector('#form_new_question');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        updateIsCorrectValues();
    })
</script>