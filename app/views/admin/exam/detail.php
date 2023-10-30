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
                                if ($exam['published'] == 1 && ($startTime > $currentTime)) {
                                ?>
                                    <a href="/admin/exam/unpublish?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit" class="btn btn-danger text-white mr-3">UnPublish</a>
                                <?php
                                }
                                if ($check_status) {
                                ?>
                                    <a href="/admin/exam/edit?id=<?php echo $exam['id']; ?>"><button type="button" class="btn btn-info text-white mr-4">Edit</button></a>
                                    <?php if ($exam['published'] != 1) {
                                    ?>
                                        <a class="btn btn-primary mr-3" id="createFilesButton" href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit">Upload</a>

                                    <?php
                                    } else {
                                    ?>
                                        <a class="btn btn-primary mr-3" id="createFilesButton" href="/admin/exam/preview?exam_id=<?php echo $exam['id']; ?>" data-id="<?php echo $exam['id']; ?>" id="submit">Re-Upload</a>

                                    <?php }
                                    ?>
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
                    <div class="card-body">
                        <div class="mb-3 col-9 mr-2">
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
                            <?php echo isset($exam['time_start']) ? $exam['time_start'] : "Chưa có thời gian bắt đầu !" ?>
                            <br>
                            <b><label class="form-label" for="time_end">Time end : </label></b>
                            <?php echo isset($exam['time_end']) ? $exam['time_end'] : "Chưa có thời gian kết thúc !" ?>
                            <br>
                            <b><label class="form-label" for="description">Description : </label></b>
                            <?php echo isset($exam['description']) ? $exam['description'] : "Chưa có mô tả"; ?>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h4 class="mb-2 nowrap">List participant</h4>
                        </div>
                        <div class="input-button-group mr-2">
                            <?php if ($exam['published'] == 1) {
                            ?>
                                <button type="button" data-path="examParticipant" data-id="select" data-exam-id="<?php echo $exam['id']; ?>" class="btn btn-info text-white btn-send-mail btn-sendmail-select" style="display: none;">Send Mail All</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ml-10">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="input-button-group mb-3">
                                <?php if ($check_status) {
                                ?>
                                    <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success float-end">Add Participant</button></a>
                                <?php
                                } ?>
                            </div>
                            <table class="table table-striped table-bordered table-responsive">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center align-middle">
                                            <?php if ($check_status) { ?>
                                                <input type="checkbox" id="selectAll" class="selectAllSendMail" name="select_all">
                                            <?php } ?>
                                        </th>
                                        <th scope="col">#</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">
                                            <div class="custom-inline-grid">
                                                <label for="selectScores">Scores</label>
                                                <select class="text-medium border" id="selectScores" name="" aria-label="Default select example">
                                                    <option value="0">increase</option>
                                                    <option selected value="1">decrease</option>
                                                </select>
                                            </div>
                                        </th>
                                        <th scope="col">Link Exam</th>
                                        <th scope="col">Send Mail</th>
                                        <th scope="col">Option</th>
                                    </tr>
                                </thead>
                                <tbody class="table-rule-body">
                                    <?php
                                    if (count($emails) > 0) {
                                        $stt = 1;
                                        foreach ($emails as $email) {
                                            // echo "<pre>";
                                            // var_dump($email);
                                            // die();
                                            $score = 0;
                                            if ($total_question_exam > 0) {
                                                $score = $email['score'] . "/" . $total_question_exam;
                                            }
                                    ?>
                                            <tr class="text-center">
                                                <th class="text-center align-middle">
                                                    <?php if ($check_status) { ?>
                                                        <input type="checkbox" value="<?php echo $email['id']; ?>" name="item[]" class="checkboxSendMail">
                                                    <?php } ?>
                                                </th>
                                                <td><?php echo $stt++; ?></td>
                                                <td><?php echo $email['email'] ?></td>
                                                <td><?php echo $email['is_submit'] == 2 ? "<span class='text-danger'>Chưa nộp bài</span>" : "<span class='text-success'>Đã nộp bài</span>"; ?></td>
                                                <td><?php echo $score; ?></td>

                                                <td class="text-left">
                                                    <?php if ($exam['published'] == 1) {
                                                    ?>
                                                        <a style="color:#5d7cc1" href="#" class="copyLink ml-4 linkToCopy text-primary-hover" data-link="<?php echo $directory['domain'] . $exam['id'] . "/" . $email['random'] ?> "><?php echo $directory['domain'] . $exam['id'] . "/" . $email['random'] ?> </a>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $email['is_sendmail'] == 0 ? "<span class='text-danger'>Chưa gửi mail</span>" : "<span class='text-success'>Đã gửi mail</span>"; ?></td>

                                                <td>
                                                    <?php
                                                    if ($check_status) {
                                                    ?>
                                                        <?php if ($exam['published'] == 1) { ?>
                                                            <button type="button" data-path="examParticipant" data-exam-id="<?php echo $exam['id']; ?>" data-id="<?php echo $email['id']; ?>" class="btn btn-info text-white btn-send-mail mr-2">Send Mail</button>
                                                        <?php } ?>
                                                        <button type="button" data-path="examParticipant" data-id="<?php echo $email['id']; ?>" class="btn btn-danger text-white btn-delete-question mr-2">Delete</button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr class="text-center">
                                            <td colspan="6">Empty</td>
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
                            <button type="button" data-exam_id="<?php echo $exam['id']; ?>" data-path="exam-question/delete-question-all" data-id="select" class="btn btn-danger text-white btn-delete-select-all btn-delete-select" style="display: none;">Delete All</button>
                        </div>
                    </div>
                </div>
                <div class="white_card_body ml-10">
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
                                    <th class="text-center align-middle">
                                        <?php if ($check_status) { ?>
                                            <input type="checkbox" id="selectAll" class="selectAll" name="select_all">
                                        <?php } ?>
                                    </th>
                                    <th class="col-1 align-middle" scope="col">#</th>
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
                                            <th class="text-center align-middle">
                                                <?php if ($check_status) { ?>
                                                    <input type="checkbox" value="<?php echo $exam_detail['question_id']; ?>" name="item[]" class="checkbox">
                                                <?php } ?>
                                            </th>
                                            <th scope="row" class="align-middle"><?php echo $st++; ?></th>
                                            <td class="align-middle">
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
                                            if ($cur_user['role_id'] != 3 && $check_status) {
                                            ?>
                                                <td class="col-2 align-middle text-center">
                                                    <div class="d-flex justify-content-center">
                                                        <a href="/admin/question/edit?question_id=<?php echo $exam_detail['question_id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                                                        <div class="mx-2"></div> <!-- Khoảng cách ngang 2 đơn vị -->
                                                        <button data-question_id="<?php echo $exam_detail['question_id']; ?>" data-exam_id="<?php echo $exam['id']; ?>" type="button" class="btn btn-danger text-white btn-delete-exam-detail">Delete</button>
                                                    </div>
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
    selectAll("selectAll", "checkbox", ".btn-delete-select");
    selectAll("selectAllSendMail", "checkboxSendMail", ".btn-sendmail-select");

    function selectAll(classSelectAll, classCheckbox, classBtnSelectAll) {
        let selectAllCheckboxes = document.getElementsByClassName(classSelectAll);
        let checkboxes = document.getElementsByClassName(classCheckbox);
        let checkboxesArray = Array.from(checkboxes);

        // Sự kiện click cho checkbox "Select All"
        for (let i = 0; i < selectAllCheckboxes.length; i++) {
            selectAllCheckboxes[i].addEventListener("click", function() {
                checkboxesArray.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckboxes[i].checked;
                });
                updateSelectedValues1(classCheckbox, classBtnSelectAll);
            });
        }
        // Sự kiện click cho các input con
        checkboxesArray.forEach(function(checkbox) {
            checkbox.addEventListener("click", function() {
                updateSelectedValues1(classCheckbox, classBtnSelectAll);
            });
        });
    }

    function updateSelectedValues1(classCheckbox, classBtnSelectAll) {
        let checkboxes = document.getElementsByClassName(classCheckbox);
        let checkboxesArray = Array.from(checkboxes);
        let deleteButton = document.querySelector(classBtnSelectAll);
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

    //select Scores (increase,decrease)
    const score_id = "selectScores";
    const paramNameScore = "score";

    searchSelect(score_id, paramNameScore);

    function searchSelect(select, paramName) {
        var selectBox = document.getElementById(select);
        var currentURL = window.location.href;
        var match = currentURL.match(new RegExp("[\\?&]" + paramName + "=([^&]*)"));
        if (match) {
            var selectedValue = decodeURIComponent(match[1]);
            selectBox.value = selectedValue;
        }
        selectBox.addEventListener("change", function() {
            var newValue = this.value;
            var newURL;
            if (match) {
                newURL = currentURL.replace(new RegExp(paramName + "=[^&]*"), paramName + "=" + encodeURIComponent(newValue));
            } else {
                newURL = currentURL + (currentURL.includes("?") ? "&" : "?") + paramName + "=" + encodeURIComponent(newValue);
            }
            window.location.href = newURL;
        });
    }
</script>