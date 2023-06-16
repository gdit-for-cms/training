<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?></title>
  <!-- Bootstrap CSS -->
  <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="/css/back-css/create-table.css" rel="stylesheet">
</head>

<body>
  <div class="d-flex justify-content-between m-5">
    <a href="/admin" type="button" class="btn btn-danger">
      Back Admin
    </a>
    <button type="button" class="btn btn-primary button_question_add">
      Create Question
    </button>
    <button type="button" class="btn btn-primary button_import_json">
      HTML <=> JSON
    </button>
    <a href="/admin/step/index" type="button" class="btn btn-success">
      Steps
    </a>
  </div>
  <div class="mx-5">
    <h5 class="text-center border">Table</h5>
    <div class="content_question">
      <?php echo $questions?>
    </div>
  </div>

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


  <script src="/js/front-js/jquery.min.js"></script>
  <script src="/js/bootstrap/bootstrap.min.js"></script>
  <script src="/js/back-js/create-table.js"></script>
</body>

</html>