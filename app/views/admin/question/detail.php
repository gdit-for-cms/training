<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0 fs-2">Collection question</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body" style="margin-left: 15px;">
            <div class="card-body d-flex">
                <div class="mb-3 col-10 mr-12" style="">
                    <b><label class="form-label" for="title">Title : </label></b>
                    <?php echo isset($question_title) ? $question_title['title'] : "Other question"; ?>
                    <br>
                    <b><label class="form-label" for="title">Description : </label></b>
                    <?php echo isset($question_title['description']) ? $question_title['description'] : "These are general questions that do not belong to any collection" ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Question list</h4>
        </div>
        <div class="white_card_body">
            <div class="input-button-group">
                <a href='/admin/question/new?ques-title=<?php echo isset($question_title['id']) ? $question_title['id'] : "other"; ?>'><button type="button" class="btn btn-success mb-3">Add question</button></a>
                <button type="button" data-path="question" data-id="select" class="btn btn-danger text-white btn-delete-select-all btn-delete-select" style="display: none;">Delete</button>
            </div>
            <div class="default-according" id="accordion2">

                <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">

                    <table id="<?= "1" ?>" class="table table-striped table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">
                                    <input type="checkbox" id="selectAll" class="selectAll" name="select_all">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">CONTENT</th>
                                <th scope="col">ANSWER</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="body_table_main">
                            <?php

                            if (!empty($question_titles)  && isset($question_titles[0]['question_content'])) {
                                $stt = 1;
                                foreach ($question_titles as $question_title) {
                            ?>
                                    <tr>
                                        <th class="text-center align-middle">
                                            <input type="checkbox" value="<?php echo $question_title['question_id']; ?>" name="item[]" class="checkbox">
                                        </th>
                                        <th class="align-middle"><?php echo $stt++; ?></th>
                                        <td class="col-4 align-middle">
                                            <?php echo $question_title['question_content'] ?>
                                        </td>
                                        <td class="">
                                            <div class="answer-container align-middle">
                                                <ul>
                                                    <?php
                                                    $st = 1;
                                                    $alphabet = range('A', 'Z');
                                                    $answerIndex = 0;
                                                    $answers = explode('|<@>|', $question_title['answers']);
                                                    foreach ($answers as $answer) {
                                                        $answer = explode('-', $answer);
                                                        if ($answer[0] == 1) {
                                                    ?>
                                                            <li class="text-ellipsis" style="color:#008000 "><?php echo  $alphabet[$answerIndex] . ". " . $answer[1] ?> </li>
                                                        <?php
                                                        } else { ?>
                                                            <li class="text-ellipsis" style=""><?php echo   $alphabet[$answerIndex] . ". " . $answer[1] ?> </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                        $answerIndex++;
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="col-2  align-middle">
                                            <a href="/admin/question/edit?question_title_id=<?php echo isset($question_title['id']) ? $question_title['id'] : "other";  ?>&question_id=<?php echo $question_title['question_id']; ?>"><button type="button" class="btn btn-info text-white">Edit</button></a>
                                            <button type="button" data-path="question" data-id="<?php echo $question_title['question_id']; ?>" class="btn btn-danger text-white btn-delete-question ">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                }
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
                                if ($page <= $numbers_of_page && isset($question_titles[0]['question_content'])) {
                                ?>

                                    <?php
                                    if ($page > 1) {
                                    ?>
                                        <li class=" cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo isset($question_titles[0]['question_title_id']) ? $question_titles[0]['question_title_id'] : "other"; ?>&page=1">
                                                << </a>
                                        </li>
                                        <li class="  cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo isset($question_titles[0]['question_title_id']) ? $question_titles[0]['question_title_id'] : "other";  ?>&page=<?php $page--;
                                                                                                                                                                                                                                            echo $page; ?>">Previous</a></li>
                                    <?php
                                    }
                                    ?>
                                    <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                        <li class=" cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/question/detail?question_id=<?php echo isset($question_titles[0]['question_title_id']) ? $question_titles[0]['question_title_id'] : "other";  ?>&page=<?php echo $i; ?>"><?= $i ?></a></li>
                                    <?php }
                                    if ($next < $numbers_of_page) {
                                    ?>
                                        <li class=" cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo isset($question_titles[0]['question_title_id']) ? $question_titles[0]['question_title_id'] : "other";  ?>&page=<?php echo $next += 1; ?>">Next</a></li>
                                        <li class=" cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo isset($question_titles[0]['question_title_id']) ? $question_titles[0]['question_title_id'] : "other";  ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>">>></a></li>
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
<script>
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