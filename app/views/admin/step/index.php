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
    <a href="/admin/table/index" type="button" class="btn btn-danger">Back Table</a>
    <button type="button" class="btn btn-success button_create">
      Create Step
    </button>
  </div>
  <h4 class="m-5">Steps</h4>
  <div class="content m-5">
    <?php foreach ($steps as $step) { ?>
      <div class="wrapper_step bg-step p-3 d-flex justify-content-between align-items-center">
        <div class="step d-flex justify-content-between align-items-center w-75">
          <div class="step_id w-25"><?php echo $step["step_id"] ?></div>
          <div class="step_name w-75"><?php echo $step["step_name"] ?></div>
        </div>
        <div>
          <button data-step-id="<?php echo $step["step_id"] ?>" type="button" class="mx-1 btn btn-primary button_edit">Edit</button>
          <button data-step-id="<?php echo $step["step_id"] ?>" type="button" class="mx-1 btn btn-danger button_delete">Delete</button>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Modal create-->
  <div class="modal_create modal">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Create step</h6>
        <span class="close_modal_create close">&times;</span>
      </div>
      <div class="modal-body">
        <label for="input_create_id">Step ID</label>
        <input id="input_create_id" class="input-group form-control" type="text">
        <br>
        <label for="input_create_name">Step Name</label>
        <input id="input_create_name" class="input-group form-control" type="text">
      </div>
      <div class="modal-footer">
        <span class="close_modal_create btn btn-secondary">Back</span>
        <button type="button" class="submit_create btn btn-primary">Save</button>
      </div>
    </div>
  </div>
  <!-- End modal create-->

  <!-- Modal edit-->
  <div class="modal_edit modal">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Edit step</h6>
        <span class="close_modal_edit close">&times;</span>
      </div>
      <div class="modal-body">
        <label for="input_edit_id">Step ID</label>
        <input id="input_edit_id" class="input-group form-control" type="text">
        <br>
        <label for="input_edit_name">Step Name</label>
        <input id="input_edit_name" class="input-group form-control" type="text">
      </div>
      <div class="modal-footer">
        <span class="close_modal_edit btn btn-secondary">Back</span>
        <button type="button" class="submit_edit btn btn-primary">Save</button>
      </div>
    </div>
  </div>
  <!-- End modal edit-->

  <!-- Modal alert delete-->
  <div class="modal_alert_delete modal">
    <div class="modal-content">
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
  <!-- End modal alert delete-->

  <script src="/js/front-js/jquery.min.js"></script>
  <script src="/js/bootstrap/bootstrap.min.js"></script>
  <script src="/js/back-js/step.js"></script>
</body>

</html>