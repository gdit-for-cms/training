<div class="card_box box_shadow position-relative mb_30">
    <div class="white_box_tittle ">
        <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Question</h4>
            <a href='/admin/exam/new'><button type="button" class="btn btn-success">Create</button></a>
        </div>
    </div>
    <div class="box_body">
        <div class="default-according" id="accordion2">
            <div class="card" data-name="<?php  ?>">
                <div class="card-header parpel_bg cursor-pointer" id="headingseven" data-id="<?php  ?>">
                    <h5 class="mb-0 flex items-center justify-between">

                        <button class="btn text_white collapsed" data-bs-toggle="collapse" data-bs-target="#collapseseven" aria-expanded="false">
                            <div class="flex justify-center items-center">
                                <span class="icon-show font-bold text-2xl mr-4">+</span>
                                <?php ?>
                                <span style="padding-left: 30px;">
                                </span>
                            </div>
                        </button>
                    </h5>
                </div>
                <div class="table_position collapse" id="collapseseven" aria-labelledby="headingOne" data-parent="#accordion2">
                    <div class="d-flex  mt-2 mr-6">
                        <div class="col-lg-8 card-body">

                        </div>
                        <div class="col-lg-4 card-body">
                            <a href="/admin/exam/examDetail?exam_id=<?php echo $exam['exam_id'] ?>" class="btn btn-success text-white mr-2">View detail</a>
                            <a href='/admin/exam/edit?id=<?php ?>' class="edit-btn btn btn-info text-white mr-2">Edit</a>
                            <button type="button" data-id="<?php ?>" class="btn btn-danger btn-delete-question text-white">Delete</button>
                        </div>
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
                                    <table id="<?php ?>" class="table table-striped">
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
                                                            <div class="overflow-auto" style='width: 400px;height: 120px; max-height: 100%;'>
                                                                <?php echo $question['question_content']; ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" data-id="<?= $question['question_id'] ?>" class="btn btn-danger btn-delete-exam-detail text-white">Delete</button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    array_push($check_question, $question['question_id']);
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

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
            ?>
        </div>
    </div>
</div>