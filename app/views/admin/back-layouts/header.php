<div class="container-fluid g-0">
    <!-- Modal question add -->
    <div class="modal_question_add modal">
        <div class="modal-content modal-dialog modal-lg">
            <div class="modal-header">
                <h6 class="modal-title">Create question</h6>
                <span class="close_modal_question_add close">&times;</span>
            </div>
            <div class="modal-body">
                <input class="input_question_add input-group form-control" type="text">
            </div>
            <div class="modal-footer">
                <span class="close_modal_question_add btn btn-secondary">Back</span>
                <button type="button" class="submit_question_add btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    <!-- End modal question add -->


    <!-- Modal question edit -->
    <div class="modal_question_edit modal">
        <div class="modal-content modal-dialog modal-lg">
            <div class="modal-header">
                <h6 class="modal-title">Edit question</h6>
                <span class="close_modal_question_edit close">&times;</span>
            </div>
            <div class="modal-body">
                <input class="input_question_edit input-group form-control" type="text">
            </div>
            <div class="modal-footer">
                <span class="close_modal_question_edit btn btn-secondary">Back</span>
                <button type="button" class="submit_question_edit btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    <!-- End modal question edit -->


    <!-- Modal answer add -->
    <div class="modal_answer_add modal">
        <div class="modal-content modal-dialog modal-lg">
            <div class="modal-header">
                <h6 class="modal-title">Create answer</h6>
                <span class="close_modal_answer_add close">&times;</span>
            </div>
            <div class="modal-body">
                <input class="input_answer_add input-group form-control" type="text">
            </div>
            <div class="modal-footer">
                <span class="close_modal_answer_add btn btn-secondary">Back</span>
                <button type="button" class="submit_answer_add btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    <!-- End modal answer add -->


    <!-- Modal answer edit -->
    <div class="modal_answer_edit modal">
        <div class="modal-content modal-dialog modal-lg">
            <div class="modal-header">
                <h6 class="modal-title">Edit answer</h6>
                <span class="close_modal_answer_edit close">&times;</span>
            </div>
            <div class="modal-body">
                <input class="input_answer_edit input-group form-control" type="text">
            </div>
            <div class="modal-footer">
                <span class="close_modal_answer_edit btn btn-secondary">Back</span>
                <button type="button" class="submit_answer_edit btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    <!-- End modal answer edit -->


    <!-- Modal alert delete -->
    <div class="modal_alert_delete modal">
        <div class="modal-content modal-dialog">
            <div class="modal-header">
                <h6 class="modal-title">Are you sure?</h6>
                <span class="close_modal_alert_delete close">&times;</span>
            </div>
            <div class="modal-footer">
                <span class="close_modal_alert_delete btn btn-secondary">Back</span>
                <button type="button" class="submit_modal_alert_delete btn btn-danger">Yes, delete it</button>
            </div>
        </div>
    </div>
    <!-- End modal alert delete -->


    <!-- Modal import json -->
    <div class="modal_import_json modal">
        <div class="modal-content modal-dialog modal-lg">
            <div class="modal-header">
                <h6 class="modal-title">Import Json</h6>
                <span class="close_modal_import_json close">&times;</span>
            </div>
            <div class="modal-body">
                <textarea class="input_import_json input-group form-control" rows="18" type="text"></textarea>
            </div>
            <div class="modal-footer">
                <span class="close_modal_import_json btn btn-secondary">Back</span>
                <button type="button" class="submit_import_json btn btn-primary">Import</button>
            </div>
        </div>
    </div>
    <!-- End modal import json -->


    <!-- Modal step-->
    <div class="modal_step_add modal">
        <div class="modal-content modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-header">
                <h6 class="modal-title">Create step</h6>
                <span class="close_modal_step_add close">&times;</span>
            </div>
            <div class="modal-body">
                <label for="search_step">Search by ID or keyword</label>
                <input id="search_step" class="input-group form-control mb-5" type="text">
                <table class="table table-striped table-step">
                    <thead>
                        <tr>
                            <th scope="col">Select</th>
                            <th scope="col">ID step</th>
                            <th scope="col">Content step</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($steps as $step) { ?>
                            <tr>
                                <th>
                                    <input data-step-name="<?php echo  $step['step_name'] ?>" data-id="<?php echo  $step['step_id'] ?>" type="checkbox">
                                </th>
                                <td>
                                    <?php echo  $step['step_id'] ?>
                                </td>
                                <td>
                                    <?php echo  $step['step_name'] ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span class="close_modal_step_add btn btn-secondary">Back</span>
                <button type="button" class="submit_step_add btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    <!-- End modal step-->

    <!-- Modal dialog-->
    <div class="modal_dialog_add modal">
        <div class="modal-content modal-dialog modal-lg">
            <div class="modal-header">
                <h6 class="modal-title">Selection control</h6>
                <span class="close_modal_dialog_add close">&times;</span>
            </div>
            <div class="modal-body">
                <h6 class="modal-title mb-3">Disable the following options:</h6>
                <table class="table table-striped table-dialog">
                    <thead>
                        <tr>
                            <th scope="col">Select</th>
                            <th scope="col">Content answer</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <span class="close_modal_dialog_add btn btn-secondary">Back</span>
                <button type="button" class="submit_dialog_add btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    <!-- End modal dialog-->

    <div class="row">
        <div class="col-lg-12 p-0 ">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div class="line_icon open_miniSide d-none d-lg-block">
                    <img src="" alt="">
                </div>
                <div class="serach_field-area d-flex align-items-center">
                    <div class="search_inner">
                        <form action="#">
                            <div class="search_field">
                                <input type="text" placeholder="Search">
                            </div>
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="header_notification_warp d-flex align-items-center">
                    </div>
                    <div class="profile_info">
                        <?php if ($_SESSION['user']['avatar_image'] == '') { ?>
                            <div class="rounded-circle border cursor-pointer flex items-center justify-center w-10 h-10 bg-gray-600 text-sm text-white font-bold align-middle"><?php echo strtoupper(substr($_SESSION['user']['name'], 0, 1)) ?></div>
                        <?php } else { ?>
                            <img src="/<?php echo $_SESSION['user']['avatar_image'] ?>" class="rounded-circle cursor-pointer border" alt="example placeholder" />
                        <?php } ?>
                        <div class="profile_info_iner border" style="top: 60px; right: -5px;">
                            <div class="profile_info_details">
                                <a href="/admin/admin/show">My Profile</a>
                                <a href="/admin/auth/logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>