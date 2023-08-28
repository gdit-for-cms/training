<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Add Question</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <!-- <form id="form_new_user" class="" action="create" method="POST"> -->
                <form id="form_add_question" class="" action="store?exam_id=<?php echo $exam['id']; ?>" method="POST">
                    <div class="col-md-4">
                        <label class="form-label" for="position">Question*</label>
                        <select id="questionSelect" name="question_id" onchange="loadAnswers()" class="form-control">
                            <option disabled selected value="">-- Choose question --</option>
                            <?php foreach ($questions as $question) { ?>
                                <option value="<?= $question['id'] ?>">
                                    <?= $question['content'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div id="answerList"></div>
                    </div>
            </div>
            <br>
            <button id="submit" type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
</div>
</div>
<!-- <div class="box-lightbox">
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
                        <button class="btn btn-primary" id="submit_confirm_btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<script>
    const answerList = document.getElementById('answerList')
    const answerListElement = document.createElement('div')

    function loadAnswers() {
        var questionId = document.getElementById("questionSelect").value;

        // alert(questionId);
        $.ajax({
            type: "GET",
            url: `/admin/answer/show?question_id=${questionId}`,

            success: function(data) {
                result = data['result']
                answerList.innerHTML = ''; // Xóa nội dung hiện tại của answerList

                // Tạo bảng
                var table = document.createElement('table');
                table.classList.add('table', 'table-bordered'); // Thêm class để định dạng bảng (sử dụng Bootstrap)

                // Tạo hàng tiêu đề của bảng
                var headerRow = document.createElement('tr');
                var headerCheckboxCell = document.createElement('th');
                headerCheckboxCell.textContent = 'Select';
                headerRow.appendChild(headerCheckboxCell);

                var headerContentCell = document.createElement('th');
                headerContentCell.textContent = 'Content';
                headerRow.appendChild(headerContentCell);

                var headerIsCorrectCell = document.createElement('th');
                headerIsCorrectCell.textContent = 'Is Correct';
                headerRow.appendChild(headerIsCorrectCell);

                table.appendChild(headerRow);

                // Tạo hàng cho mỗi câu trả lời
                for (var i = 0; i < result.length; i++) {
                    var object = result[i];

                    var id = object.id;
                    var content = object.content;
                    var isCorrect = object.is_correct;

                    var row = document.createElement('tr');

                    // Tạo ô chứa checkbox
                    var checkboxCell = document.createElement('td');
                    var checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = id;
                    checkbox.name = 'selected_answers[]';
                    checkboxCell.appendChild(checkbox);
                    row.appendChild(checkboxCell);

                    // Tạo ô chứa nội dung của câu trả lời
                    var contentCell = document.createElement('td');
                    contentCell.textContent = content;
                    row.appendChild(contentCell);

                    // Tạo ô chứa is_correct
                    var isCorrectCell = document.createElement('td');

                    if (isCorrect == 1) {
                        isCorrectCell.textContent = true;

                    } else {
                        isCorrectCell.textContent = false;

                    }
                    row.appendChild(isCorrectCell);

                    table.appendChild(row);
                }

                // Thêm bảng vào answerList
                answerList.appendChild(table);
            },
            cache: false,
            contentType: false,
            processData: false
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX request failed:", textStatus, errorThrown);
        });
    }

    // const submitBtn = document.querySelector('#submit')
    // const nameInput = document.querySelector('#name')
    // const emailInput = document.querySelector('#email')
    // const passwordInput = document.querySelector('#password')
    // const confirmPasswordInput = document.querySelector('#confirmPassword')

    // function start() {
    //     // checkChangeInput(nameInput)
    //     // checkChangeInput(emailInput)
    //     // checkChangeInput(passwordInput)
    //     // checkChangeInput(confirmPasswordInput)
    //     checkConfirmPassword()
    // }
    // start()

    // function validate() {
    //     if (nameInput.value.length <= 0 || emailInput.value == '' || passwordInput.value == '' || passwordInput.value != confirmPasswordInput.value) {
    //         submitBtn.disabled = true;
    //     } else {
    //         submitBtn.disabled = false;
    //     }
    // }

    // function checkChangeInput(input) {
    //     input.addEventListener('keyup', () => {
    //         validate()
    //     })
    // }

    // function checkConfirmPassword() {
    //     passwordInput.addEventListener('keyup', () => {
    //         if (confirmPasswordInput.value != passwordInput.value) {
    //             submitBtn.disabled = true
    //         } else {
    //             submitBtn.disabled = false
    //         }
    //     })
    //     confirmPasswordInput.addEventListener('keyup', () => {
    //         if (confirmPasswordInput.value != passwordInput.value) {
    //             submitBtn.disabled = true
    //         } else {
    //             submitBtn.disabled = false
    //         }
    //     })
    // }
</script>