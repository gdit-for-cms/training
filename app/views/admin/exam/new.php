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
                <form id="form_create_exam" class="" action="create" method="POST">
                    <div class="flex">
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="title">Title <span style="color: red;">*</span></label>
                            <input class="form-control" rows="3" name="title" id="title" placeholder="Title..." />
                        </div>
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="minutes">Duration (minutes)<span style="color: red;">*</span></label>
                            <input class="form-control" type="number" name="duration" id="duration" placeholder="Duration..." min="0" />
                        </div>
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="title">Description</label>
                            <input class="form-control" rows="3" name="description" id="description" placeholder="Description..." />
                        </div>
                    </div>
                    <div id="answerContainer">
                        <label class="form-label" for="email">Email participant</label>
                        <!-- Ô input mặc định -->
                        <div class="form-check" style="padding-left: 45px;">
                            <div class="input-with-button">
                                <input type="text" class="form-control input-answer" name="emails[]" value="" placeholder="Email...">
                                <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="input-add-answer">
                        <button type="button" class="btn btn-info m-2" onclick="addAnswer()">Thêm</button>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function addAnswer() {
        var answerContainer = document.getElementById("answerContainer");

        var newAnswerDiv = document.createElement("div");
        newAnswerDiv.classList.add("form-check");
        newAnswerDiv.style = "padding-left: 45px;";

        var inputWithButton = document.createElement("div");
        inputWithButton.classList.add("input-with-button");
        var answerInput = document.createElement("input");
        answerInput.type = "text";
        answerInput.classList.add("form-control", "input-answer");
        answerInput.name = "emails[]";
        answerInput.value = "";
        answerInput.placeholder = "Email...";
        var removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.textContent = "Delete";
        removeButton.classList.add("remove-button", "btn", "btn-danger", "delete-btn", "text-white");
        removeButton.onclick = function() {
            removeAnswer(this);
        };
        inputWithButton.appendChild(answerInput);
        inputWithButton.appendChild(removeButton);
        newAnswerDiv.appendChild(inputWithButton);
        answerContainer.appendChild(newAnswerDiv);
    }

    function removeAnswer(button) {
        var answerContainer = document.getElementById("answerContainer");
        answerContainer.removeChild(button.parentElement.parentElement);
        updateCheckboxValues(); // Cập nhật lại giá trị của các checkbox sau khi xóa
        // updateCheckboxValues(); // Cập nhật lại giá trị của các checkbox sau khi xóa

    }
</script>