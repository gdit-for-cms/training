<?php
// echo "<pre>";
// var_dump($exam);
// die();
?>
<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit collection exam</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_create_exam" class="" action="update" method="POST">
                    <input class="form-control" type="hidden" value="<?php echo $exam['id']; ?>" rows="3" name="id" />

                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="card-body d-flex">
                                    <!-- <form id="form_new_question col-12" class="" action="create" method="POST"> -->
                                    <div class="mb-6 col-4 mr-12" style="">
                                        <div class="mb-3 mr-12">
                                            <label class="form-label" for="title">Title </label>
                                            <input class="form-control" name="title" value="<?php echo $exam['title'] ?>" rows="3" placeholder="title..." />
                                        </div>
                                        <div class="mb-3  mr-12">
                                            <label class="form-label" for="description">Description collection </label>
                                            <input class="form-control" name="description" value="<?php echo isset($exam['description']) ? $exam['description'] : "" ?>" rows="3" placeholder="description..." />
                                        </div>
                                    </div>

                                    <div class="mb-6 col-2 mr-12" style="">
                                        <div class="mb-3 ">
                                            <label class="form-label" for="duration">Duration (minutes) </label>
                                            <input class="form-control" name="duration" value="<?php echo $exam['duration'] ?>" rows="3" placeholder="duration..." />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="status">Status </label>
                                            <input class="form-control" disabled value="<?php echo $exam['published'] == 1 ? "Đã upload lên server" : " Chưa upload lên server" ?>" rows="3" placeholder="status..." />
                                        </div>
                                    </div>
                                    <div class="col-4 mr-7">

                                        <div id="answerContainer">
                                            <label class="form-label" for="email">Email participant</label>
                                            <!-- Ô input mặc định -->
                                            <?php if (count($emails) > 0) {
                                                foreach ($emails as $email) { ?>
                                                    <div class="form-check" style="padding-left: 45px;">
                                                        <div class="input-with-button">
                                                            <input type="text" class="form-control input-answer" name="email[]" value="<?php echo $email['email']; ?>" placeholder="Email...">
                                                            <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                                        </div>
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                        <div class="input-add-answer">
                                            <button type="button" class="btn btn-info m-2" onclick="addAnswer()">Thêm</button>
                                        </div>

                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>

    </div>
</div>
<div class="col-lg-12">

    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit select questions</h3>
                    </div>
                    <div class="top-right">
                    <?php
                    if ($cur_user['role_id'] != 3) {
                    ?>
                        <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="table-responsive m-b-30">
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Content Question</th>
                            <th scope="col">Answer</th>

                            <?php
                            if ($cur_user['role_id'] != 3) {
                            ?>
                                <th scope="col">Option</th>
                            <?php
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody class="table-rule-body">
                        <?php
                        if (!empty($exam_details)) {
                            $st = 1;
                            foreach ($exam_details as $exam_detail) {
                                $answers = explode(',', $exam_detail['answers']);
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $st++; ?></th>
                                    <td>
                                        <div class="overflow-auto">
                                            <?php echo $exam_detail['question_content'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                            <?php
                                            $stt = 1;

                                            foreach ($answers as $answer) {
                                                $answer = explode('-', $answer);

                                                if ($answer['1'] == 1) {
                                            ?>
                                                    <span style="background-color: #e0eb37; margin-right: 20px;">
                                                        <?php
                                                        echo $stt++ . " ) " . $answer[0] . "<br>";
                                                        ?> </span>
                                                <?php
                                                } else {
                                                ?>
                                                    <span style="margin-right: 20px;">
                                                        <?php
                                                        echo $stt++ . " ) " . $answer[0] . "<br>";
                                                        ?> </span>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <?php
                                    if ($cur_user['role_id'] != 3) {
                                    ?>
                                        <td>
                                            <button data-question_id="<?php echo $exam_detail['question_id']; ?>" data-exam_id="<?php echo $exam['id']; ?>" type="button" class="btn btn-danger delete-btn btn-delete-exam-detail">Delete</button>


                                        </td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                            <?php }
                        } else {
                            ?>
                            <tr>
                                <td colspan="9" class='text-center h-100'>Empty</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="flex justify-center items-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            $next = $page;
                            if ($page <= $numbers_of_page) {
                            ?>
                                <li class="page-item cursor-pointer"><a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=1" class="page-link">
                                        << </a>
                                </li>
                                <?php
                                if ($page > 1) {
                                ?>
                                    <li class=" page-item cursor-pointer"><a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=<?php $page--;
                                                                                                                                        echo $page; ?>" class="page-link">Previous</a></li>
                                <?php
                                }
                                ?>
                                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                    <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                <?php }
                                if ($next < $numbers_of_page) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/edit/id=<?php echo $exam['id']; ?>&page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>

                                <?php
                                }
                                ?>
                                <li class="page-item cursor-pointer"><a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- <div class="white_card_body">
            <div class="card-body">
                <div class="d-flex">
                    <div class="col-2 metismenu" style="background-color: #dddcdc;text-align: center;margin-right: 15px;">

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
                            <button data-exam_id="<?php echo $exam['id']; ?>" id="select" type="submit" class="btn btn-primary btn-add_question_exam">Save</button>
                        </div>
                    </div>

                    <div class="col-10 d-flex">
                        <div id="questionList" class="col-12">

                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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