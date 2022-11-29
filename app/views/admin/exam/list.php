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
                                    <th scope="row"><?php echo $i++ ?></th>
                                    <td><?php echo $exam['name'] ?></td>
                                    <td><?php echo $exam['count_q'] ?></td>
                                    <td><?php echo $exam['topic_name'] ?></td>
                                    <td><?php echo $exam['timelimit'] ?></td>
                                    <td>
                                        <a class="btn btn-outline-primary mb-3" id="testnhaaaa">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                            </svg>
                                        </a>
                                        <a class="btn btn-outline-danger mb-3 delete-exam" data-id="<?php echo $exam['id'] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash2-fill" viewBox="0 0 16 16">
                                                <path d="M2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td><?php echo $exam['created_at'] ?></td>
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