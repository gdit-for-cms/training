<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit collection</h3>
                </div>
                <div class="top-right">

                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_create_exam" class="ml-10" action="update" method="POST">
                    <input class="form-control" type="hidden" value="<?php echo $exam['id']; ?>" rows="3" name="id" />
                    <div class="">
                        <div class="mb-3 col-8 mr-7">
                            <label class="form-label" for="title">Title <span style="color: red;">*</span></label>
                            <input class="form-control" rows="3" name="title" value="<?= $exam['title'] ?>" id="title" placeholder="Title..." />
                        </div>
                        <div class="mb-3 col-8 mr-7">
                            <label class="form-label" for="title">Description</label>
                            <textarea class="form-control" rows="7" name="description" id="description" placeholder="Description..."><?= isset($exam['description']) ? $exam['description'] : "" ?></textarea>
                        </div>
                        <div class="mb-3 col-8 mr-7">
                            <label class="form-label" for="date start">Time start</label>
                            <input class="form-control" type="datetime-local" name="date_start" id="date_start" value="<?= isset($exam['time_start']) ? $exam['time_start'] : '' ?>" />
                        </div>
                        <div class="mb-3 col-8 mr-7">
                            <label class="form-label" for="date end">Time end</label>
                            <input class="form-control" type="datetime-local" name="date_end" id="date_end" value="<?= isset($exam['time_end']) ? $exam['time_end'] : '' ?>" />
                        </div>
                    </div>
                    <div id="answerContainer">
                        <label class="form-label" for="email">Email participant</label>
                        <?php if (count($emails) > 0) {
                            foreach ($emails as $email) { ?>
                                <div class="form-check" style="padding-left: 45px;">
                                    <div class="input-with-button">
                                        <input type="text" class="form-control input-answer" name="email[]" value="<?php echo $email['email']; ?>" placeholder="email...">
                                        <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                    <div class="input-add-answer">
                        <button type="button" class="btn btn-info m-2 text-white" onclick="addAnswer()">Add</button>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="white_card card_box card_height_100 mb_30">
        <div class="px-4 pt-4">
            <div class="main-title2 d-flex justify-content-between items-center ">
                <div class="top-left d-flex">
                    <h4 class="mb-2 nowrap">List question</h4>
                </div>
                <div class="input-button-group mr-2">
                    <button type="button" data-exam_id="<?php echo $exam['id']; ?>" data-path="exam-question/delete-question-all" data-id="select" class="btn btn-danger text-white btn-delete-select-all btn-delete-select" style="display: none;">Delete</button>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="input-button-group mb-3">
                <?php
                if ($cur_user['role_id'] != 3) {
                ?>
                    <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
                <?php
                }
                ?>
            </div>
            <div class="table-responsive m-b-30">
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center">
                                <input type="checkbox" id="selectAll" class="selectAll" name="select_all">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Content</th>
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
                                $answers = explode('|<@>|', $exam_detail['answers']);
                        ?>
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" value="<?php echo $exam_detail['question_id']; ?>" name="item[]" class="checkbox">
                                    </th>
                                    <th scope="row"><?php echo $st++; ?></th>
                                    <td>
                                        <div class="overflow-auto">
                                            <?php echo $exam_detail['question_content'] ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="overflow-auto">
                                            <ul>
                                                <?php
                                                $stt = 1;
                                                $alphabet = range('A', 'Z');
                                                $answerIndex = 0;
                                                foreach ($answers as $answer) {
                                                    $answer = explode('-', $answer);
                                                    if ($answer['1'] == 1) {
                                                ?>
                                                        <li class="text-ellipsis" style="color:#008000 "><?php echo  $alphabet[$answerIndex] . ". " . $answer[0] ?> </li>
                                                    <?php
                                                    } else { ?>
                                                        <li class="text-ellipsis"><?php echo   $alphabet[$answerIndex] . ". " . $answer[0] ?> </li>
                                                <?php
                                                    }
                                                    $answerIndex++;
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </td>
                                    <?php
                                    if ($cur_user['role_id'] != 3) {
                                    ?>
                                        <td class="col-2">
                                            <a href="/admin/question/edit?question_id=<?php echo $exam_detail['question_id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                                            <button data-question_id="<?php echo $exam_detail['question_id']; ?>" data-exam_id="<?php echo $exam['id']; ?>" type="button" class=" btn btn-danger text-white btn-delete-exam-detail">Delete</button>
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
                        <ul class="paginations">
                            <?php
                            $next = $page;
                            if ($page <= $numbers_of_page) {
                            ?>
                                <?php
                                if ($page > 1) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=1" class="page-link">
                                            << </a>
                                    </li>
                                    <li class=" page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php $page--;
                                                                                                                                                    echo $page; ?>" class="page-link">Previous</a></li>
                                <?php
                                }
                                ?>
                                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                    <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                <?php }
                                if ($next < $numbers_of_page) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>
                                    <li class="page-item cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
                                <?php
                                }
                                ?>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const paginationContainer = document.getElementById("paginations");

    //copy link
    var copyLinkButtons = document.querySelectorAll(".copyLink");

    copyLinkButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var linkToCopy = button.getAttribute("data-link");
            var inputElement = document.createElement("input");
            inputElement.value = linkToCopy;
            document.body.appendChild(inputElement);
            inputElement.select();
            inputElement.setSelectionRange(0, 99999);
            document.execCommand("copy");
            document.body.removeChild(inputElement);
            alert("Liên kết đã được sao chép: " + linkToCopy);
        });
    });
    //end coply link
    selectAll()

    function updateSelectedValues() {
        let checkboxes = document.getElementsByClassName("checkbox");
        let checkboxesArray = Array.from(checkboxes);
        let deleteButton = document.querySelector(".btn-delete-select");
        let selectedValues = [];
        checkboxesArray.forEach(function(checkbox) {
            if (checkbox.checked) {
                selectedValues.push(checkbox.value);
            }
        });
        if (selectedValues.length > 0) {
            deleteButton.style.display = "block";
        } else {
            deleteButton.style.display = "none";
        }
        console.log(selectedValues);
        return selectedValues;
    }

    function selectAll() {
        let selectAllCheckboxes = document.getElementsByClassName("selectAll");
        let checkboxes = document.getElementsByClassName("checkbox");
        let checkboxesArray = Array.from(checkboxes);

        // Sự kiện click cho checkbox "Select All"
        for (let i = 0; i < selectAllCheckboxes.length; i++) {
            selectAllCheckboxes[i].addEventListener("click", function() {
                checkboxesArray.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckboxes[i].checked;
                });
                updateSelectedValues();
            });
        }
        // Sự kiện click cho các input con
        checkboxesArray.forEach(function(checkbox) {
            checkbox.addEventListener("click", function() {
                updateSelectedValues();
            });
        });
    }
</script>