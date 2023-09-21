<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Collection question</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body d-flex">
                <!-- <form id="form_new_question col-12" class="" action="create" method="POST"> -->
                <div class="mb-3 col-5 mr-12" style="">
                    <label class="form-label" for="title">Title collection </label>
                    <input class="form-control" rows="3" disabled value="<?php echo $question_title['title']; ?>" placeholder="Title..." />
                </div>
                <div class="mb-3 col-5">
                    <label class="form-label" for="title">Description collection </label>
                    <input class="form-control" disabled value="<?php echo isset($question_title['description']) ? $question_title['description'] : "" ?>" rows="3" placeholder="description..." />
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>

<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Question detail</h4>
            <a href='/admin/question/new?ques-title=<?php echo $question_titles[0]['question_title_id']; ?>'><button type="button" class="btn btn-success">Add question</button></a>
        </div>
    </div>
    <div class="box_body white_card_body">
        <div class="default-according" id="accordion2">

            <div class="flex col-4 mb-6">
                <input id="search_input" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button id="search_btn" type="button" disabled class="btn btn-primary">search</button>
                <button id="delete_search" type="button" class="btn btn-danger text-white ml-2">X</button>
            </div>

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
                                    <td class="col-3 " style='height: 100px; max-height: 100%;'>
                                        <?php
                                        $st = 1;
                                        $answers = explode(',', $question_title['answers']);
                                        foreach ($answers as $answer) {
                                            $answer = explode('-', $answer);
                                        ?>
                                            <span style="background-color:<?php echo $answer[0] == 1 ? 'yellow' : '' ?>;"><?php echo  $answer[1] ?> </span><br>
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
                                                    <button type="button" data-id="<?php echo $question_title['question_id']; ?>" class="dropdown-item btn-delete-question ">Delete</button>
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
                        <ul class="pagination">
                            <?php
                            $next = $page;
                            if ($page <= $numbers_of_page && isset($question_titles[0]['question_content'])) {
                            ?>
                                <li class="page-item cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo $question_titles[0]['question_title_id']; ?>&page=1" class="page-link">
                                        << </a>
                                </li>
                                <?php
                                if ($page > 1) {
                                ?>
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

                                <?php
                                }
                                ?>
                                <li class="page-item cursor-pointer"><a href="/admin/question/detail?question_id=<?php echo $question_titles[0]['question_title_id']; ?>&page=<?php echo $numbers_of_page < 1 ? 1 : $numbers_of_page; ?>" class="page-link">>></a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>