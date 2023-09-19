<div class="d-flex">
    <div class="col-2 metismenu" style="background-color: #dddcdc;
    text-align: center;
    margin-right: 15px;">

        <ul class="metismenu" style="padding: 15px 25px">
            <?php foreach ($question_titles as $question_title) { ?>
                <li class="border border-dark text-center has-arrow mb-1" onclick="getQuestion('<?php echo $question_title['id']; ?>')"><button class="" style="" type="button" class=" dropdown-item "><?php echo $question_title['title'] ?></button></li>
            <?php } ?>
        </ul>
        <div>
            <span>Số câu đã chọn : <span id="total_select">2</span> </span>
            <button id="select" type="submit" class="btn btn-primary">Select</button>
        </div>
    </div>

    <div class="col-10 d-flex">
        <div id="questionList" class="col-12">
            <!-- Nơi để hiển thị danh sách câu hỏi sau khi AJAX được gọi -->

        </div>
    </div>
</div>

<style>
    .selected {
        border: 1px solid #c4c8d9;
        /* Màu khi được chọn */
    }
</style>
<script>
    const array_select_question = [];
    const newArray = []
    let check_click = false;
    
    function select_question() {
        let questionID = $(this).data('question_id');
        // alert(questionID)
        if (!array_select_question.includes(questionID)) {
            array_select_question.push(questionID);
        } else {
            // newArray = array_select_question.filter(item => item !== questionID);
        }

        const questionContainer = document.getElementsByClassName("ques_exam")
        // const questionContainer = $this.get("#ques_exam")
        console.log(questionContainer)
        if (check_click) {
            questionContainer.classList.remove("selected")
            check_click = false;
        } else {
            questionContainer.classList.add("selected")
            check_click = true;
        }

        // console.log(typeof(array_select_question))
        console.log((array_select_question))

    };


    function getQuestion(question_title_id) {
        // Gọi AJAX để lấy danh sách câu hỏi từ server
        $.ajax({
            type: "GET",
            url: `/admin/question-title/show?id=${question_title_id}`,
            success: function(data) {

                const results = data.result;
                const questionList = document.getElementById('questionList');

                // Xóa bất kỳ nội dung cũ nào trong danh sách câu hỏi
                questionList.innerHTML = '';

                // Lặp qua mảng các câu hỏi và hiển thị chúng trên trang
                results.forEach(result => {
                    // console.log(result)

                    const content = result.question_content;

                    // Tạo các phần tử HTML tương ứng
                    const questionContainer = document.createElement('div');
                    questionContainer.className = 'col-12 d-flex mb-10';
                    questionContainer.style.border = '1px solid #000';
                    questionContainer.classList.add ("ques_exam");
                    questionContainer.setAttribute('data-question_id', result['question_id']);
                    questionContainer.onclick = select_question


                    const questionText = document.createElement('div');
                    questionText.className = 'col-8';
                    questionText.style.border = '1px solid #000';
                    questionText.innerHTML = content;

                    const answerContainer = document.createElement('div');
                    answerContainer.className = 'col-4';
                    answerContainer.style.border = '1px solid #000';

                    const answerList = document.createElement('ul');

                    const answers = result.answers;

                    const myArray = answers.split(", ");
                    const resultArray = [];

                    myArray.forEach(subArray => {
                        const subArrayElements = subArray.split(',');

                        resultArray.push(subArrayElements);
                    });

                    // console.log(resultArray);
                    const resultArray2 = [];

                    for (let i = 0; i < resultArray['0'].length; i++) {
                        const item = resultArray[0][i];
                        const splitArray = item.split(' - ');
                        const answer = document.createElement('li')
                        answer.textContent = splitArray[1]
                        answerList.appendChild(answer)

                        // console.log((splitArray))
                    }
                    answerContainer.appendChild(answerList);
                    questionContainer.appendChild(questionText);
                    questionContainer.appendChild(answerContainer);
                    questionList.appendChild(questionContainer);
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX request failed:", textStatus, errorThrown);
            }
        });
    }
</script>