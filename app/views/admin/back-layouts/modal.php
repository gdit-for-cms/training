<!-- Modal question add -->
<div class="modal_question_add modal">
    <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
            <h5 class="modal-title">Create question</h5>
            <span class="close_modal_question_add close">&times;</span>
        </div>
        <div class="modal-body">
            <input class="input_question_add input-group form-control mb-3" type="text">
            <div class="form-check">
                <input class="input_question_add_required form-check-input" type="checkbox" id="input_question_add_required" checked>
                <label class="form-check-label" for="input_question_add_required">
                    Question has only 1 answer
                </label>
            </div>
            <div class="form-check">
                <input class="input_question_add_multi form-check-input" type="checkbox" id="input_question_add_multi">
                <label class="form-check-label" for="input_question_add_multi">
                    Questions with multiple answers
                </label>
            </div>
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
            <h5 class="modal-title">Edit question</h5>
            <span class="close_modal_question_edit close">&times;</span>
        </div>
        <div class="modal-body">
            <input class="input_question_edit input-group form-control mb-3" type="text">
            <div class="form-check">
                <input class="input_question_edit_required form-check-input" type="checkbox" id="input_question_edit_required">
                <label class="form-check-label" for="input_question_edit_required">
                    Question has only 1 answer
                </label>
            </div>
            <div class="form-check">
                <input class="input_question_edit_multi form-check-input" type="checkbox" id="input_question_edit_multi">
                <label class="form-check-label" for="input_question_edit_multi">
                    Questions with multiple answers
                </label>
            </div>
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
            <h5 class="modal-title">Create answer</h5>
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
            <h5 class="modal-title">Edit answer</h5>
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
            <h5 class="modal-title">Are you sure?</h5>
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
            <h5 class="modal-title">Import Json</h5>
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
            <h5 class="modal-title">Create step</h5>
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


<!-- Modal disable-->
<div class="modal_disable_add modal">
    <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
            <h5 class="modal-title">Selection control</h5>
            <span class="close_modal_disable_add close">&times;</span>
        </div>
        <div class="modal-body">
            <h5 class="modal-title mb-3">Disable the following options:</h5>
            <table class="table table-striped table-disable">
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
            <span class="close_modal_disable_add btn btn-secondary">Back</span>
            <button type="button" class="submit_disable_add btn btn-primary">Save</button>
        </div>
    </div>
</div>
<!-- End modal disable-->


<!-- Modal create step-->
<div class="modal_create_step modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create step</h5>
            <span class="close_modal_create_step close">&times;</span>
        </div>
        <div class="modal-body">
            <label for="input_create_id_step">Step ID</label>
            <input id="input_create_id_step" class="input-group form-control" type="text">
            <br>
            <label for="input_create_name_step">Step Name</label>
            <input id="input_create_name_step" class="input-group form-control" type="text">
        </div>
        <div class="modal-footer">
            <span class="close_modal_create_step btn btn-secondary">Back</span>
            <button type="button" class="submit_create_step btn btn-primary">Save</button>
        </div>
    </div>
</div>
<!-- End modal create step-->


<!-- Modal edit step-->
<div class="modal_edit_step modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit step</h5>
            <span class="close_modal_edit_step close">&times;</span>
        </div>
        <div class="modal-body">
            <label for="input_edit_id_step">Step ID</label>
            <input id="input_edit_id_step" class="input-group form-control" type="text">
            <br>
            <label for="input_edit_name_step">Step Name</label>
            <input id="input_edit_name_step" class="input-group form-control" type="text">
        </div>
        <div class="modal-footer">
            <span class="close_modal_edit_step btn btn-secondary">Back</span>
            <button type="button" class="submit_edit_step btn btn-primary">Save</button>
        </div>
    </div>
</div>
<!-- End modal edit step-->


<!-- Modal alert delete step-->
<div class="modal_alert_delete_step modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Are you sure?</h5>
            <span class="close_modal_alert_delete_step close">&times;</span>
        </div>
        <div class="modal-footer">
            <span class="close_modal_alert_delete_step btn btn-secondary">Back</span>
            <button type="button" class="submit_modal_alert_delete_step btn btn-danger">Yes, delete it</button>
        </div>
    </div>
</div>
<!-- End modal alert delete step-->