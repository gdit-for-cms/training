<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="panel ">
                        <a href="new" class="btn btn-primary">Create</a>
                    </div>
                </div>
                <div class="white_card_body">
                    <div class="white_box_tittle list_header">
                        <h4>Exam List</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="serach_field_2">
                                <div class="search_inner">
                                    <form active="#">
                                        <div class="search_field">
                                            <input type="text" placeholder="Features not released yet">
                                        </div>
                                        <button type="submit"> <i class="ti-search"></i> </button>
                                    </form>
                                </div>
                            </div>
                            <div class="add_button ms-2">
                                <a href="#" data-toggle="modal" data-target="#addcategory" class="btn_1">search</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col" class="col-md-1">#</th>
                                    <th scope="col" class="col-md-3">Name</th>
                                    <th scope="col" class="col-md-1">Questions</th>
                                    <th scope="col" class="col-md-3">Topic</th>
                                    <th scope="col" class="col-md-1">Timelimit</th>
                                    <th scope="col" class="col-md-1">Action</th>
                                    <th scope="col" class="col-md-2">Created at</th>
                                </tr>
                            </thead>
                                <?php $i = 1;
                                foreach ($exams as $exam) { ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td><?= $exam['name'] ?></td>
                                        <td><?= $exam['count_q'] ?></td>
                                        <td><?= $exam['topic_id'] ?></td>
                                        <td><?= $exam['timelimit'] ?></td>
                                        <td><a class="btn btn-outline-primary mb-3 edit-topic-btn" >Edit</a></td>
                                        <td><?= $exam['created_at'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'edit.php' ?>