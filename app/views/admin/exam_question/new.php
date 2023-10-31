<div class="d-flex">
    <div class="col-3">
        <div class=" metismenu" style="background-color: #dddcdc; margin-right: 15px;">
            <ul class="metismenu" style="padding: 15px 25px">
                <?php foreach ($question_titles as $question_title) { ?>
                    <li class="border has-arrow mb-1 collection_hover cursor-pointer" onclick="getQuestion('<?php echo $question_title['id']; ?>')">
                        <button type="button" class="text-left ">
                            <?php echo $question_title['title'] ?>
                        </button>
                        <!-- <span>3</span> -->
                    </li>
                <?php } ?>
                <li class="border has-arrow mb-1 collection_hover cursor-pointer" onclick="getQuestion('other')">
                    <button type="button" class="text-left">
                        Other
                    </button>
                </li>
            </ul>
            <div class="mb-5 ml-4">
                <i class="bi bi-exclamation-circle"></i>
                <span class="myDIV text-danger">* Note</span>
                <div class="hide-note">
                    <p style="padding-left: 20px;">
                        Select the button on the questions to add questions to the exam
                    </p>
                </div>
            </div>
            <div style=" padding-bottom: 10px;">
                <span style="margin-left: 20px; margin-right: 20px;">Số câu đã chọn : <span id="total_select">0</span> </span><br>
                <div style=" display: flex;justify-content: center;align-items: center;">
                    <a href='/admin/question/new?ques-title=other&exam_id=<?= $exam_id; ?>'><button type="button" class="btn btn-primary ">Quick add question</button></a>
                    <button style="width: 80px; margin: 15px;" data-exam_id="<?php echo $exam_id; ?>" id="select" type="submit" class=" btn btn btn-success btn-add_question_exam">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9 d-flex">
        <div id="questionList" class="col-12">

        </div>
    </div>
</div>

<script>
    let array_select_question = [];
    let array_select_all = [];
    let select = 0;

    function selectQuestion() {
        let total_select = document.getElementById("total_select");
        const checkboxes = document.querySelectorAll('.checkbox');
        checkboxes.forEach(function(checkbox) {
            const isChecked = array_select_question.includes(checkbox.value);
            if (isChecked) {
                checkbox.checked = true;
            }
            checkbox.addEventListener('click', function() {
                if (checkbox.checked) {
                    array_select_question.push(checkbox.value);
                    select++;
                } else {
                    array_select_question = array_select_question.filter(item => item !== checkbox.value);
                    select--;
                }
                if (total_select) {
                    total_select.innerHTML = select;
                }
            });
        });

        const selectAll = document.querySelectorAll('.selectAll');
        selectAll.forEach(function(checkboxAll) {
            const select_all_id = checkboxAll.getAttribute('data-question_title_id');
            const isCheckedAll = array_select_all.includes(select_all_id);

            if (isCheckedAll) {
                checkboxAll.checked = true;
            }
            checkboxAll.addEventListener('click', function() {
                if (checkboxAll.checked) {
                    array_select_all.push(select_all_id);

                    checkboxes.forEach(function(checkbox) {
                        const isChecked = array_select_question.includes(checkbox.value);
                        if (!isChecked) {
                            checkbox.checked = true;
                            array_select_question.push(checkbox.value);
                            select++;
                        }
                    })
                } else {
                    array_select_all = array_select_all.filter(item => item !== select_all_id);
                    checkboxes.forEach(function(checkbox) {
                        if (checkbox.checked) {
                            checkbox.checked = false;
                            array_select_question = array_select_question.filter(item => item !== checkbox.value);
                            select--;

                        }
                    })
                }
                console.log(array_select_question)
                // console.log(array_select_all);
                if (total_select) {
                    total_select.innerHTML = select;
                }
            })
        });
    }

    function getQuestion(question_title_id) {

        // Gọi AJAX để lấy danh sách câu hỏi từ server
        const exam = document.getElementById("select");
        const exam_id = exam.getAttribute("data-exam_id")
        $.ajax({
            type: "GET",
            url: `/admin/question-title/show?id=${question_title_id}&exam_id=${exam_id}`,
            success: function(data) {
                const results = data.result;
                const questionList = document.getElementById('questionList');
                let questionListHTML = '';
                let stt = 1;

                results.forEach(result => {
                    const question_id = result.question_id;
                    const answers = result.answers;
                    const myArray = answers.split(", ");
                    const resultArrayAnswer = [];
                    myArray.forEach(subArray => {
                        const subArrayElements = subArray.split('|<@>|');
                        resultArrayAnswer.push(subArrayElements);
                    });
                    let answerListHTML = '';
                    var alphabet = [];
                    for (var i = 'A'.charCodeAt(0); i <= 'Z'.charCodeAt(0); i++) {
                        alphabet.push(String.fromCharCode(i));
                    }
                    for (let i = 0; i < resultArrayAnswer['0'].length; i++) {
                        const item = resultArrayAnswer[0][i];
                        const splitArray = item.split(' - ');

                        var answerHTML = '';
                        if (splitArray[0] == 1) {
                            answerHTML += `
                        <li class="text-ellipsis" style="color:#008000">${alphabet[i]}. ${splitArray[1]}</li>
                    `;
                        } else {
                            answerHTML += `
                        <li class="text-ellipsis">${alphabet[i]}. ${splitArray[1]}</li>
                    `;
                        }

                        answerListHTML += answerHTML
                    }
                    const content = result.question_content;
                    const questionHTML =
                        `
                        <tr>
                            <th class="text-center col-1">
                                <input type="checkbox" value="${question_id}" name="item[]" class="checkbox" id="">
                            </th>
                            <td class="col-1 text-center">${stt++}</td>
                            <td class="col-4 text-ellipsis ">
                            ${content}
                            </td>
                            <td class="col-6">
                                <div class="answer-container">
                                    <ul style="padding-left:0">
                                        ${answerListHTML}
                                    </ul>
                                </div>
                            </td>
                        </tr>`;
                    questionListHTML += questionHTML;
                });
                let inputSelectAll = '';
                if (questionListHTML !== "") {
                    inputSelectAll = `
                                            <input type="checkbox" data-question_title_id="${question_title_id}" id="selectAll" class="selectAll" name="select_all">
                                        `;
                }

                let table = ` <table class="table table-striped table-bordered table-responsive">
                                <thead>
                                    <tr>
                                    <th class="text-center col-1">${inputSelectAll}</th>
                                        <th class="text-center col-1" scope="col">#</th>
                                        <th class="col-4" scope="col">CONTENT</th>
                                        <th class="col-6" scope="col">ANSWER</th>
                                    </tr>
                                </thead>
                                <tbody class="body_table_main" id="">
                                    ${questionListHTML}
                                </tbody>
                            </table>`;
                questionList.innerHTML = table;
                selectQuestion()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
            }
        });
    }
</script>