<div class="d-flex">
    <div class="col-2 metismenu">
        <ul>
            <?php foreach ($question_titles as $question_title) { ?>
                <button style="" onclick="getQuestion('<?php echo $question_title['id']; ?>')" type="button" class=" dropdown-item "><?php echo $question_title['title'] ?></button>
            <?php } ?>
        </ul>
    </div>

    <div class="col-10 d-flex">
        <div id="questionList" class="col-12">
            <!-- Nơi để hiển thị danh sách câu hỏi sau khi AJAX được gọi -->

        </div>
    </div>
</div>

<script>
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

                    const content = result.question_content;

                    // Tạo các phần tử HTML tương ứng
                    const questionContainer = document.createElement('div');
                    questionContainer.className = 'col-12 d-flex mb-10';
                    questionContainer.style.border = '1px solid #000';

                    const questionText = document.createElement('div');
                    questionText.className = 'col-8';
                    questionText.style.border = '1px solid #000';
                    questionText.innerHTML = content;

                    const answerContainer = document.createElement('div');
                    answerContainer.className = 'col-4';
                    answerContainer.style.border = '1px solid #000';

                    const answerList = document.createElement('ul');
                    
                    const answers = result.answers;

                    // const answers = ['cau tra loi 1', 'cau tra loi 2', 'cau tra loi 3', 'cau tra loi 4'];
                    const myArray = answers.split(", ");
                    console.log(myArray);

                    answers.forEach(answer => {
                        const answerItem = document.createElement('li');
                        answerItem.textContent = answer;
                        answerList.appendChild(answerItem);
                    });

                    // Thêm các phần tử vào phần tử cha
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