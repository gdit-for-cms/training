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
                    <div class="mb-3">
                        <label class="form-label" for="title">Title*</label>
                        <input class="form-control" rows="3" name="title" id="title" placeholder="Title..." />
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content*</label>
                        <textarea id="editor-edit-note" class="form-control h-120px" name="content" rows="3"><?php  ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="answer">Answer*</label>
                        <div id="answerContainer">
                            <!-- Ô input mặc định -->
                            <div class="form-check">
                                <input class="form-check-input" name="is_correct[]" type="checkbox" value="0" onchange="updateCheckboxValue(this)">
                                <div class="input-with-button">
                                    <input type="text" class="form-control input-answer" name="answer[]" value="" placeholder="Answer...">
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
    // chức năng thêm xóa câu hỏi 

    // Biến tạm để lưu giá trị của ô input hiện tại
    var currentAnswerIndex = 1;
    // Mảng lưu vị trí các checkbox đã chọn
    var selectedPositions = [];

    function addAnswer() {
        var answerContainer = document.getElementById("answerContainer");

        var newAnswerDiv = document.createElement("div");
        newAnswerDiv.classList.add("form-check");

        var answerCheckbox = document.createElement("input");
        answerCheckbox.classList.add("form-check-input");
        answerCheckbox.type = "checkbox";
        answerCheckbox.name = "is_correct[]";
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

        currentAnswerIndex++; // Tăng giá trị biến tạm lên để sử dụng cho ô input tiếp theo
    }

    function removeAnswer(button) {
        var answerContainer = document.getElementById("answerContainer");
        if (answerContainer.children.length > 1) {
            answerContainer.removeChild(button.parentElement.parentElement);
            updateCheckboxValues(); // Cập nhật lại giá trị của các checkbox sau khi xóa
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
    // Cập nhật giá trị is_correct trước khi gửi form
    function updateIsCorrectValues() {
        var checkboxes = document.querySelectorAll('input[name="is_correct[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].value = i; // Cập nhật lại giá trị cho các checkbox dựa trên vị trí của chúng
        }
    }

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
    const form = document.querySelector('#form_new_question');
    form.addEventListener('submit', function(event) {
        // Ngăn chặn việc gửi form mặc định để thực hiện xử lý tùy chỉnh
        event.preventDefault();

        // Gọi hàm để cập nhật giá trị is_correct trước khi submit
        updateIsCorrectValues();
    })
</script>