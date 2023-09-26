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
                            <button type="button" class="btn btn-info m-2" onclick="addAnswer()">Add</button>
                        </div>
                    </div>
                    <a class="btn btn-danger" href="/admin/question/index" class="page-link">Back</a>
                    <button id="submit" type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Biến tạm để lưu giá trị của ô input hiện tại
    var currentAnswerIndex = 0;
    // Mảng lưu vị trí các checkbox đã chọn
    var selectedPositions = [];

    function addAnswer() {
        var answerContainer = document.getElementById("answerContainer");

        var newAnswerDiv = document.createElement("div");
        newAnswerDiv.classList.add("form-check");
        newAnswerDiv.style = "padding-left: 45px;";

        var answerCheckbox = document.createElement("input");
        answerCheckbox.classList.add("form-check-input");
        answerCheckbox.type = "checkbox";
        answerCheckbox.name = "is_correct[]";
        answerCheckbox.style = "margin-right: 50px;";
        answerCheckbox.value = currentAnswerIndex; // Gán giá trị của ô input hiện tại
        answerCheckbox.addEventListener("change", function() {
            updateCheckboxValue(this);
        });

        var inputWithButton = document.createElement("div");
        inputWithButton.classList.add("input-with-button");

        var answerInput = document.createElement("input");
        answerInput.type = "text";
        answerInput.classList.add("form-control", "input-answer");
        answerInput.name = "answer[]";
        answerInput.value = "";
        answerInput.placeholder = "Answer...";

        var removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.textContent = "Delete";
        removeButton.classList.add("remove-button", "btn", "btn-danger", "delete-btn", "text-white");
        removeButton.onclick = function() {
            removeAnswer(this);
        };

        inputWithButton.appendChild(answerInput);
        inputWithButton.appendChild(removeButton);

        newAnswerDiv.appendChild(answerCheckbox);
        newAnswerDiv.appendChild(inputWithButton);

        answerContainer.appendChild(newAnswerDiv);

        currentAnswerIndex++;
    }

    function removeAnswer(button) {
        var answerContainer = document.getElementById("answerContainer");
        if (answerContainer.children.length > 1) {
            answerContainer.removeChild(button.parentElement.parentElement);
            updateCheckboxValues();
        } else {
            alert("Phải có ít nhất một câu trả lời.");
        }
    }

    function updateCheckboxValue(checkbox) {
        const answerIndex = parseInt(checkbox.value);

        if (checkbox.checked) {
            if (!selectedPositions.includes(answerIndex)) {
                selectedPositions.push(answerIndex);
            }
        } else {
            const indexToRemove = selectedPositions.indexOf(answerIndex);
            if (indexToRemove > -1) {
                selectedPositions.splice(indexToRemove, 1);
            }
        }
    }

    function updateCheckboxValues() {
        var checkboxes = document.querySelectorAll('input[name="is_correct[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].value = i;
        }
    }
    //end chức năng thêm xóa answer

    function updateIsCorrectValues() {
        var checkboxes = document.querySelectorAll('input[name="is_correct[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].value = i;
        }
    }

    const form = document.querySelector('#form_update_question');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        updateIsCorrectValues();
    })

    const submitBtn = document.querySelector('#submit')
    const titleInput = document.querySelector('#title')
    const contentInput = document.querySelector('#editor-edit-note')

    function start() {
        checkChangeInput(titleInput)
        checkChangeInput(contentInput)
    }
    // start()

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
</script>