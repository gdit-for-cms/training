<?php
$exams = [];
foreach ($examsWithQuestions as $row) {
    $examId = $row['exam_id'];

    // Nếu chưa tồn tại bài thi trong mảng $exams, thêm mới
    if (!isset($exams[$examId])) {
        $exams[$examId] = [
            'exam_id' => $row['exam_id'],
            'exam_title' => $row['exam_title'],
            'questions' => []
        ];
    }

    // Nếu có câu hỏi, thêm vào danh sách câu hỏi của bài thi
    if ($row['question_id']) {
        $exams[$examId]['questions'][] = [
            'question_id' => $row['question_id'],
            'question_content' => $row['question_content'],
            'question_title' => $row['question_title']
        ];
    }
}

// echo "<pre>";
// var_dump($exams);
// die();
?>
<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Exam</h4>
            <a href='/admin/exam/new'><button type="button" class="btn btn-success">Create</button></a>
        </div>
    </div>
    <div class="box_body">
        <div class="default-according" id="accordion2">
            <?php
            foreach ($exams as $exam) {
            ?>
                <div class="card" data-name="<?= $exam['exam_title'] ?>">
                    <div class="card-header parpel_bg cursor-pointer" id="headingseven" data-id="<?= $exam['exam_id'] ?>">
                        <h5 class="mb-0 flex items-center justify-between">
                            <button class="btn text_white collapsed" data-bs-toggle="collapse" data-bs-target="#collapseseven" aria-expanded="false">
                                <div class="flex justify-center items-center">
                                    <span class="icon-show font-bold text-2xl mr-4">+</span>
                                    <?php echo $exam['exam_title']; ?>
                                </div>
                            </button>
                        </h5>
                    </div>
                    <div class="table_position collapse" id="collapseseven" aria-labelledby="headingOne" data-parent="#accordion2">
                        <div class="d-flex justify-content-end mt-2 mr-6">
                            <!-- <button data-id="<?php echo $exam['exam_id'] ?>" class="btn btn-primary btn-show-rule text-white mr-2">Exam Priview</button> -->
                            <button data-id="<?php echo $exam['exam_id']; ?>" type="button" class="btn btn-primary btn-show-priview-exam text-white  mr-2">Priview</button>
                            <a href='/admin/exam/edit?id=<?= $exam['exam_id'] ?>' class="edit-btn btn btn-info text-white mr-2">Edit</a>
                            <button type="button" data-id="<?= $exam['exam_id'] ?>" class="btn btn-danger delete-btn text-white">Delete</button>
                        </div>
                        <div class="card-body row justify-content-center" style="padding-top: 25px;">
                            <div class="col-lg-3">
                                <div class="card_box box_shadow position-relative mb_30">
                                    <div class="white_box_tittle">
                                        <div class="main-title2 ">
                                            <h4 class="mb-2 nowrap ">Description</h4>
                                        </div>
                                    </div>
                                    <div class="box_body">
                                        <p class="f-w-400 ">
                                            <?= empty($exam['exam_description']) ? 'Add description for exam...' : $exam['exam_description'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="white_card box_shadow card_height_100 mb_30">
                                    <div class="white_box_tittle">
                                        <div class="main-title2 ">
                                            <h4 class="mb-2 nowrap ">Question</h4>
                                        </div>
                                    </div>
                                    <div class="btn_sort_group d-flex justify-content-end align-items-center text-white mt-2 mr-2">
                                        <button type="button" disabled class="btn_sort btn_sort-pagi bg-gray-300 pe-none rounded border d-flex justify-content-end align-items-cente ml-2 hover:bg-gray-300">
                                            <box-icon name='list-plus'></box-icon>
                                        </button>
                                        <button type="button" class="btn_sort btn_sort-all rounded border d-flex justify-content-end align-items-cente ml-2 hover:bg-gray-300">
                                            <box-icon name='list-ul'></box-icon>
                                        </button>
                                    </div>
                                    <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">
                                        <table id="<?= $exam['exam_id'] ?>" class="table table-striped" style="width: 90% !important">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Question</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="body_table_main">

                                                <?php
                                                // if(count($exam ))
                                                $stt = 1;
                                                $check_question = array();
                                                foreach ($exam['questions'] as $question) {
                                                    if (!in_array($question['question_id'], $check_question)) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $stt++; ?></td>
                                                            <td>
                                                                <?php echo $question['question_title']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $question['question_content']; ?>

                                                            </td>
                                                            <td>
                                                                <button type="button" data-id="<?= $exam['exam_id'] ?>" class="btn btn-danger delete-btn text-white">Delete</button>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        array_push($check_question, $question['question_id']);
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- <button type="button" class="btn btn-info m-2">Thêm</button> -->
                                        <!-- <button data-id="<?php echo $exam['exam_id']; ?>" type="button" class="btn btn-primary btn-show-add-question text-white  mr-2">Show detail</button> -->
                                        <a href="/admin/exam/examDetail?exam_id=<?php echo $exam['exam_id'] ?>" class="btn btn-info m-2">View detail</a>

                                        <div class="flex justify-center items-center">
                                            <nav aria-label="Page navigation example">
                                                <ul class="pagination">

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- <div class="box-lightbox">
    <div class="col-lg-6">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title total_modal">
                        <h2 class="m-0">Add new topic</h2>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">
                    <table class="table" id="table_change">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Option</th>
                            </tr>
                        </thead>
                        <tbody class="table_change_body">

                        </tbody>
                    </table>
                    <div class="model-footer">
                        <button type="button" class="btn btn-secondary js-lightbox-close">Close</button>
                        <button class="btn btn-primary" id="change_member_btn">Change</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<script>
    const cartHeaderEles = document.querySelectorAll('.card-header')
    const editBtn = document.querySelectorAll('.edit-btn')
    const deleteBtn = document.querySelectorAll('.delete-btn')

    const btnShowRules = document.querySelectorAll('.btn-show-rule')

    const btnShowPriviewExam = document.querySelectorAll('.btn-show-add-question')
    const btnShowAddQuestion = document.querySelectorAll('.btn-show-priview-exam')

    const examDesciption = document.getElementById('rule-content')

    const descriptionElement = document.createElement('div')




    // const bodyTableEles = document.querySelectorAll('.body_table_main')

    function start() {
        showTable()
        preventDefault()
        // hiddenTable()
    }

    start()

    function showTable() {
        cartHeaderEles.forEach(ele => {
            ele.addEventListener('click', () => {
                ele.parentNode.querySelector('.table_position').classList.toggle('show')
                if (ele.parentNode.querySelector('.table_position').classList.contains('show')) {
                    ele.parentNode.querySelector('.icon-show').textContent = '-'
                } else {
                    ele.parentNode.querySelector('.icon-show').textContent = '+'
                }
            })
        })
    }

    function preventDefault() {
        editBtn.forEach(ele => {
            ele.addEventListener('click', event => {
                event.stopPropagation()
            })
        })
        deleteBtn.forEach(ele => {
            ele.addEventListener('click', event => {
                event.stopPropagation()
            })
        })
    };

    // function hiddenTable() {
    //     Array.prototype.slice.call(bodyTableEles).forEach(ele => {
    //         if (ele.childNodes.length == 1) {
    //             ele.parentNode.classList.add('hidden')
    //             ele.parentNode.parentNode.innerHTML = '<div class="box_body"><p class="f-w-400 ">No memeber</p></div>'
    //         }
    //     })
    // }




    btnShowAddQuestion.forEach((btn) => {
        btn.setAttribute('data-bs-toggle', 'modal')
        btn.setAttribute('data-bs-target', '#viewExamPriview')
        btn.addEventListener('click', (e) => {

            ruleId = btn.dataset.id
            $.ajax({
                type: "GET",
                // url: `/admin/rule/show?id=6085`,
                url: `/admin/exam/show?id=2`,

                success: function(data) {
                    result = data['result']

                    descriptionElement.textContent = result['description']
                    examDesciption.appendChild(descriptionElement)

                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function() {
                e.preventDefault()
            });
        })
    })
</script>