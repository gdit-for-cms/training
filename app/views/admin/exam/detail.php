<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0 fs-2">Collection exam</h3>
                        </div>
                        <div class="top-right">
                            <?php
                            $startTime = strtotime($exam['time_start']);
                            $endTime = strtotime($exam['time_end']);
                            $check_status = false;
                            $currentTime = time();

                            if ($currentTime < $startTime || empty($startTime) || $exam['published'] != 1) {
                                $check_status = true; ?>
                                <?php
                            }
                            if ($cur_user['role_id'] != 3) {
                                if ($check_status) {
                                ?>
                                    <a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>"><button type="button" class="btn btn-info text-white mr-4">Edit</button></a>

                                    <a class="btn btn-primary mr-3" id="createFilesButton" href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit">Upload</a>
                                <?php
                                } elseif ($exam['published'] == 1 && !($currentTime >= $startTime && $currentTime <= $endTime)) {
                                ?>
                                    <a href="/admin/exam/unpublish?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit" class="btn btn-info text-white">UnPublish</a>
                            <?php }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ml-10">
                    <div class="card-body d-flex ">
                        <div class="mb-3 col-4 mr-11" style="border-right: 1px solid #dee2e6;">
                            <b><label class="form-label" for="title">Title : </label></b>
                            <?php echo $exam['title'] ?>
                            <br>
                            <b><label class="form-label" for="author">Author : </label></b>
                            <?php echo $user[0]['name'] ?>
                            <br>
                            <b><label class="form-label" for="status">Status : </label></b>
                            <?php
                            if ($currentTime < $startTime || empty($startTime)  || $exam['published'] != 1) {
                                $check_finished = true; ?>
                                <span style="color: #FF0000;">Not Started</span>
                            <?php
                            } elseif ($currentTime >= $startTime && $currentTime <= $endTime) {
                                $check_progress = true;
                            ?>
                                <span style="color: #3c7cdb;">In Progress</span>
                            <?php
                            } elseif ($endTime < $currentTime) {
                            ?>
                                <span style="color: #008000;">Finished</span>
                            <?php
                            }
                            ?>
                            <br>
                            <b><label class="form-label" for="status">Publish : </label></b>
                            <?php echo $exam['published'] == 1 ? "Đã upload lên server" : " Chưa upload lên server" ?>
                            <br>
                            <b><label class="form-label" for="time_start">Time start : </label></b>
                            <?php echo isset($exam['time_start']) ? $exam['time_start'] : "Chưa có thời gian làm bài!" ?>
                            <br>
                            <b><label class="form-label" for="time_end">Time end : </label></b>
                            <?php echo isset($exam['time_end']) ? $exam['time_end'] : "Chưa có thời gian làm bài!" ?>
                            <br>
                            <b><label class="form-label" for="description">Description : </label></b>
                            <?php echo isset($exam['description']) ? $exam['description'] : "Chưa có mô tả"; ?>
                            <br>
                        </div>
                        <div class="col-7 ml-15">
                            <b><label class="form-label" for="email">Participants : </label></b>
                            <table class="table table-striped table-bordered table-responsive">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">#</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Scores</th>
                                        <th scope="col">Link Exam</th>
                                    </tr>
                                </thead>
                                <tbody class="table-rule-body">
                                    <?php
                                    if (count($emails) > 0) {
                                        $stt = 1;
                                        foreach ($emails as $email) {
                                            $score = 0;
                                            if ($total_question_exam > 0) {
                                                $score = (float)($email['score'] / $total_question_exam) * 100;
                                                $score = round($score, 2);
                                            }

                                    ?>
                                            <tr class="text-center">
                                                <td><?php echo $stt++; ?></td>
                                                <td><?php echo $email['email'] ?></td>
                                                <td><?php echo $email['is_submit'] == 2 ? "<span class='text-danger'>Chưa nộp bài</span>" : "<span class='text-success'>Đã nộp bài</span>"; ?></td>
                                                <td><?php echo $score; ?></td>

                                                <td class="text-left">
                                                    <?php if ($exam['published'] == 1) {
                                                    ?>
                                                        <a style="color:#5d7cc1" href="#" class="copyLink ml-4 linkToCopy text-primary-hover" data-link="<?php echo $directory['domain'] . $exam['id'] . "/" . $email['random'] ?> "><?php echo $directory['domain'] . $exam['id'] . "/" . $email['random'] ?> </a>
                                                        <!-- <button onclick="copyLink('linkToCopy<?php echo $exam['id']; ?>')" class="ml-4 linkToCopy text-primary-hover copyLink" id="linkToCopy<?php echo $exam['id']; ?>" href="<?php echo $directory['domain'] . $exam['id'] . "/" . $email['random'] ?>"><?php echo $directory['domain'] . $exam['id'] . "/" . $email['random'] ?> </button> -->
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr class="text-center">
                                            <td colspan="4">Empty</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
                        <?php if ($check_status) {
                        ?>
                            <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Question</button></a>
                        <?php
                        } ?>
                    </div>
                    <div class="table-responsive m-b-30">
                        <table class="table table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <?php if ($check_status) { ?>
                                            <input type="checkbox" id="selectAll" class="selectAll" name="select_all">
                                        <?php } ?>
                                    </th>
                                    <th class="col-1" scope="col">#</th>
                                    <th class="col-5" scope="col">Content</th>
                                    <th class="col-4" scope="col">Answer</th>
                                    <?php
                                    if ($cur_user['role_id'] != 3) {
                                    ?>
                                        <th class="col-2" scope="col">Option</th>
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
                                                <?php if ($check_status) { ?>
                                                    <input type="checkbox" value="<?php echo $exam_detail['question_id']; ?>" name="item[]" class="checkbox">
                                                <?php } ?>
                                            </th>
                                            <th scope="row"><?php echo $st++; ?></th>
                                            <td>
                                                <div class="overflow-auto">
                                                    <?php echo $exam_detail['question_content'] ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="answer-container">
                                                    <ul>
                                                        <?php
                                                        $stt = 1;
                                                        $alphabet = range('A', 'Z');
                                                        $answerIndex = 0;
                                                        foreach ($answers as $answer) {
                                                            $answer = explode('-', $answer);

                                                            if ($answer['1'] == 1) {
                                                        ?>
                                                                <li class="text-ellipsis" style="color:#008000;"><?php echo  $alphabet[$answerIndex] . ". " . $answer[0] ?> </li>

                                                            <?php
                                                            } else { ?>
                                                                <li class="text-ellipsis"><?php echo $alphabet[$answerIndex] . ". " . $answer[0] ?> </li>
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
                                                if ($check_status) {
                                            ?>
                                                    <td class="col-2">
                                                        <a href="/admin/question/edit?question_id=<?php echo $exam_detail['question_id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                                                        <button data-question_id="<?php echo $exam_detail['question_id']; ?>" data-exam_id="<?php echo $exam['id']; ?>" type="button" class=" btn btn-danger text-white btn-delete-exam-detail">Delete</button>
                                                    </td>
                                            <?php
                                                }
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
                                    if ($page <= $numbers_of_page  && isset($exam_details[0]['question_content'])) {
                                    ?>

                                        <?php
                                        if ($page > 1) {
                                        ?>
                                            <li class=" cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=1" class="page-link">
                                                    << </a>
                                            </li>
                                            <li class="  cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php $page--;
                                                                                                                                                    echo $page; ?>" class="page-link">Previous</a></li>
                                        <?php
                                        }
                                        ?>
                                        <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                            <li class=" cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                        <?php }
                                        if ($next < $numbers_of_page) {
                                        ?>
                                            <li class=" cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>
                                            <li class=" cursor-pointer"><a href="/admin/exam/examDetail?exam_id=<?php echo $exam['id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
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
    </div>
</div>
<script>
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
    // const paginationContainer = document.getElementById("paginations");
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