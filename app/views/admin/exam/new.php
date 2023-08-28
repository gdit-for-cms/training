<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New exam</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_new_position" class="" action="insert" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title*</label>
                        <input class="form-control" rows="3" name="title" id="title" placeholder="Title..." />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="title">description</label>
                        <input class="form-control" rows="3" name="description" id="description" placeholder="Description..." />
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="box-lightbox">
    <div class="col-lg-4">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title total_modal">
                        <h2 class="m-0">Confirm Information</h2>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">

                    <div class="model-footer">
                        <button type="button" class="btn btn-secondary js-lightbox-close">Close</button>
                        <button class="btn btn-primary" id="submit_confirm_btn">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="/ckeditor/ckeditor.js"></script>
<script src="/ckfinder/ckfinder.js"></script> -->
<script>
    // CKFinder.setupCKEditor();
    // CKEDITOR.replace('description');
</script>
<script>
    // var currentAnswerIndex = 0; // Biến tạm để lưu giá trị của ô input hiện tại
    // var selectedPositions = []; // Mảng lưu vị trí các checkbox đã chọn

    // function addAnswer() {
    //     var answerContainer = document.getElementById("answerContainer");

    //     var newAnswerDiv = document.createElement("div");
    //     newAnswerDiv.classList.add("form-check");

    //     var answerCheckbox = document.createElement("input");
    //     answerCheckbox.classList.add("form-check-input");
    //     answerCheckbox.type = "checkbox";
    //     answerCheckbox.name = "is_correct[]";
    //     answerCheckbox.value = currentAnswerIndex; // Gán giá trị của ô input hiện tại
    //     answerCheckbox.addEventListener("change", function() {
    //         updateCheckboxValue(this);
    //     });

    //     var inputWithButton = document.createElement("div");
    //     inputWithButton.classList.add("input-with-button");

    //     var answerInput = document.createElement("input");
    //     answerInput.type = "text";
    //     answerInput.classList.add("form-control", "input-answer");
    //     answerInput.name = "answer[]";
    //     answerInput.value = "";
    //     answerInput.placeholder = "Answer...";

    //     var removeButton = document.createElement("button");
    //     removeButton.type = "button";
    //     removeButton.textContent = "Xóa";
    //     removeButton.classList.add("remove-button", "btn", "btn-danger", "delete-btn", "text-white");
    //     removeButton.onclick = function() {
    //         removeAnswer(this);
    //     };

    //     inputWithButton.appendChild(answerInput);
    //     inputWithButton.appendChild(removeButton);

    //     newAnswerDiv.appendChild(answerCheckbox);
    //     newAnswerDiv.appendChild(inputWithButton);

    //     answerContainer.appendChild(newAnswerDiv);

    //     currentAnswerIndex++; // Tăng giá trị biến tạm lên để sử dụng cho ô input tiếp theo
    // }

    // function removeAnswer(button) {
    //     var answerContainer = document.getElementById("answerContainer");
    //     if (answerContainer.children.length > 1) {
    //         answerContainer.removeChild(button.parentElement.parentElement);
    //         updateCheckboxValues(); // Cập nhật lại giá trị của các checkbox sau khi xóa
    //     } else {
    //         alert("Phải có ít nhất một câu trả lời.");
    //     }
    // }

    // function updateCheckboxValue(checkbox) {
    //     const answerIndex = parseInt(checkbox.value);

    //     if (checkbox.checked) {
    //         if (!selectedPositions.includes(answerIndex)) {
    //             selectedPositions.push(answerIndex);
    //         }
    //     } else {
    //         const indexToRemove = selectedPositions.indexOf(answerIndex);
    //         if (indexToRemove > -1) {
    //             selectedPositions.splice(indexToRemove, 1);
    //         }
    //     }
    // }

    // function updateCheckboxValues() {
    //     var checkboxes = document.querySelectorAll('input[name="is_correct[]"]');
    //     for (var i = 0; i < checkboxes.length; i++) {
    //         checkboxes[i].value = i; // Cập nhật lại giá trị cho các checkbox dựa trên vị trí của chúng
    //     }
    // }
</script>
<script>
    const submitBtn = document.querySelector('#submit')
    const nameInput = document.querySelector('#name')
    const descriptionInput = document.querySelector('#description')

    function start() {
        checkChangeInput(nameInput)
        checkChangeInput(descriptionInput)
    }
    // start()

    function validate() {
        if (nameInput.value == '') {
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