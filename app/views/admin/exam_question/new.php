<div class="d-flex">
    <div class="col-2 metismenu" style="background-color: #dddcdc;
    text-align: center;
    margin-right: 15px;">

        <ul class="metismenu" style="padding: 15px 25px">
            <?php foreach ($question_titles as $question_title) { ?>
                <li class="border text-center has-arrow mb-1 collection_hover" style="" onclick="getQuestion('<?php echo $question_title['id']; ?>')">
                    <button class="" style="" type="button" class=" dropdown-item ">
                        <?php echo $question_title['title'] ?>
                    </button>
                </li>
            <?php } ?>
        </ul>
        <div style="display: grid;">
            <span>Số câu đã chọn : <span id="total_select">0</span> </span>
            <button data-exam_id="<?php echo $exam_id; ?>" id="select" type="submit" class="btn btn-primary btn-add_question_exam">Select</button>
        </div>
    </div>

    <div class="col-10 d-flex">
        <div id="questionList" class="col-12">
            <!-- Nơi để hiển thị danh sách câu hỏi sau khi AJAX được gọi -->

        </div>
    </div>
</div>

<style>

</style>
<script>
    const newArray = []
    let check_click = false;
    let array_select_question = [];
    let select = 0;


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
                results.forEach(result => {



                    const question_id = result.question_id;

                    const answers = result.answers;
                    const myArray = answers.split(", ");
                    const resultArrayAnswer = [];

                    myArray.forEach(subArray => {
                        const subArrayElements = subArray.split(',');

                        resultArrayAnswer.push(subArrayElements);
                    });

                    let answerListHTML = '';

                    for (let i = 0; i < resultArrayAnswer['0'].length; i++) {
                        const item = resultArrayAnswer[0][i];
                        const splitArray = item.split(' - ');
                        const answerHTML = `
                                <li>${splitArray[1]}</li>
                            `;

                        answerListHTML += answerHTML
                    }
                    let bg_question = "";

                    if (array_select_question.includes(question_id)) {
                        bg_question = "selected"
                    }
                    const content = result.question_content;
                    const questionHTML = `<div class="col-12 d-flex mb-10 ques_exam ${bg_question}" onclick="select_ques_to_exam('${question_id}')" id="select_ques${question_id}" data-question_id="${question_id}" style="border: 1px solid rgb(0, 0, 0);">
                                                <div class="col-8" style="border: 1px solid rgb(0, 0, 0);">
                                                    ${content}
                                                </div>
                                                <div class="col-4" style="border: 1px solid rgb(0, 0, 0);">
                                                    <ul  id="answerList">
                                                        ${answerListHTML}
                                                    </ul>
                                                </div>
                                            </div>`;
                    questionListHTML += questionHTML;
                });
                questionList.innerHTML = questionListHTML;

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
            }
        });
    }

    function select_ques_to_exam(questionID) {

        get_question_id = 'select_ques' + questionID;
        const questionContainer = document.getElementById(get_question_id)

        // Kiểm tra xem questionID có tồn tại trong mảng không
        if (!array_select_question.includes(questionID)) {
            array_select_question.push(questionID);
            questionContainer.classList.add("selected")
            select++;

        } else {
            // Nếu đã tồn tại, loại bỏ nó khỏi mảng
            array_select_question = array_select_question.filter(item => item !== questionID);
            questionContainer.classList.remove("selected")
            select--
        }

        const select_total = document.getElementById("total_select")
        select_total.textContent = select
        // console.log(select_total.textContent);

    }
</script>