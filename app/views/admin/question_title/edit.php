<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit question collection</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_update_question" class=" col-12" action="/admin/question-title/update" method="POST">
                    <input type="hidden" class="form-control" rows="3" value="<?php echo $question_title['id']; ?>" name="id" id="id" placeholder="Title..." />

                    <div class="mb-3 col-6" style="">
                        <label class="form-label" for="title">Title<span style="color: red;">*</span></label>
                        <input class="form-control" rows="3" value="<?php echo $question_title['title']; ?>" name="title" id="title" placeholder="Title..." />
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="title">Description</label>
                        <input class="form-control" rows="3" value="<?php echo isset($question_title['description']) ? $question_title['description'] : ''; ?>" name="description" id="description" placeholder="Description..." />
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Question list</h4>
            <a href='/admin/question/new?ques-title=<?php echo $question_titles[0]['question_title_id']; ?>'><button type="button" class="btn btn-success">Add question</button></a>
        </div>
    </div>
    <div class="box_body white_card_body">
        <div class="default-according" id="accordion2">

            <div class="table_member_body table-responsive m-b-30 flex flex-col items-center justify-center">
                <table id="<?= "1" ?>" class="table table-striped">
                    <thead>
                        <tr>
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
                                    <td class="col-1"><?php echo $stt++; ?></td>
                                    <td class="col-6">
                                        <?php echo $question_title['question_content'] ?>
                                    </td>
                                    <td class="col-3 " style='max-height: 100%;'>
                                        <?php
                                        $st = 1;
                                        $answers = explode(',', $question_title['answers']);
                                        foreach ($answers as $answer) {
                                            $answer = explode('-', $answer);
                                        ?>
                                            <span style="font-weight:<?php echo $answer[0] == 1 ? 'bold' : '' ?>;"><?php echo  $answer[1] ?> </span><br>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="col-1">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="/admin/question/edit?question_id=<?php echo $question_title['question_id']; ?>">Edit</a></li>
                                                <li>
                                                    <button type="button" data-path="question" data-id="<?php echo $question_title['question_id']; ?>" class="dropdown-item btn-delete-question ">Delete</button>
                                                </li>
                                            </ul>
                                        </div>
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
                        <ul class="paginations" id="paginations">
                            <?php
                            $next = $page;
                            if ($page <= $numbers_of_page && isset($question_titles[0]['question_content'])) {
                            ?>

                                <?php
                                if ($page > 1) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo $question_titles[0]['question_title_id']; ?>&page=1" class="page-link">
                                            << </a>
                                    </li>
                                    <li class=" page-item cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo $question_titles[0]['question_title_id']; ?>&page=<?php $page--;
                                                                                                                                                                                    echo $page; ?>" class="page-link">Previous</a></li>
                                <?php
                                }
                                ?>
                                <?php for ($i = 1; $i <= $numbers_of_page; $i++) { ?>
                                    <li class="page-item cursor-pointer"><a style="<?php if ($next == $i) { ?>background-color: rgb(197, 197, 197)<?php } ?>;" href="/admin/question/detail?question_id=<?php echo $question_titles[0]['question_title_id']; ?>&page=<?php echo $i; ?>" class="page-link"><?= $i ?></a></li>
                                <?php }
                                if ($next < $numbers_of_page) {
                                ?>
                                    <li class="page-item cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo $question_titles[0]['question_title_id']; ?>&page=<?php echo $next += 1; ?>" class="page-link">Next</a></li>
                                    <li class="page-item cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo $question_titles[0]['question_title_id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>

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
</div> -->