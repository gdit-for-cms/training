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
  <div class="d-flex justify-content-between">
    <div class="w-50 mx-5">
      <h5 class="text-center border">Select Database</h5>
      <div class="content_question">
        <?php echo $questions ?>
      </div>
    </div>
    <div class="w-50 mx-5">
      <h5 class="text-center border">Import Json</h5>
      <div class="content_import_json mb-5">

      </div>
    </div>
  </div>

  <!-- Modal question add -->
  <div class="modal_question_add modal">
    <div class="modal-content">
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
    <div class="modal-content">
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
    <div class="modal-content">
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
    <div class="modal-content">
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
  <!-- End modal alert delete -->


  <!-- Modal import json -->
  <div class="modal_import_json modal">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Import Json</h6>
        <span class="close_modal_import_json close">&times;</span>
      </div>
      <div class="modal-body">
        <textarea class="input_import_json input-group form-control" rows="8" type="text"></textarea>
      </div>
      <div class="modal-footer">
        <span class="close_modal_import_json btn btn-secondary">Back</span>
        <button type="button" class="submit_import_json btn btn-primary">Import</button>
      </div>
    </div>
  </div>
  <!-- End modal import json -->


  <!-- Modal step-->
  <!-- <div class="modal_step modal">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Create 1 or more steps</h6>
        <span class="close_modal_step close">&times;</span>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-dark">
          <thead>
            <tr>
              <th scope="col">Select</th>
              <th scope="col">Number</th>
              <th scope="col">Content steps</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><input data-step="Content step 1.1" data-id="1-1" type="checkbox"></th>
              <td>1-1</td>
              <td>Content step 1.1</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.2" data-id="1-2" type="checkbox"></th>
              <td>1-2</td>
              <td>Content step 1.2</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.3" data-id="1-3" type="checkbox"></th>
              <td>1-3</td>
              <td>Content step 1.3</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.4" data-id="1-4" type="checkbox"></th>
              <td>1-4</td>
              <td>Content step 1.4</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.5" data-id="1-5" type="checkbox"></th>
              <td>1-5</td>
              <td>Content step 1.5</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.6" data-id="1-6" type="checkbox"></th>
              <td>1-6</td>
              <td>Content step 1.6</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.7" data-id="1-7" type="checkbox"></th>
              <td>1-7</td>
              <td>Content step 1.7</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.8" data-id="1-8" type="checkbox"></th>
              <td>1-8</td>
              <td>Content step 1.8</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.9" data-id="1-9" type="checkbox"></th>
              <td>1-9</td>
              <td>Content step 1.9</td>
            </tr>
            <tr>
              <th><input data-step="Content step 1.10" data-id="1-10" type="checkbox"></th>
              <td>1-10</td>
              <td>Content step 1.10</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <span class="close_modal_step btn btn-secondary">Back</span>
        <button type="button" class="submit it_step btn btn-primary">Thêm</button>
      </div>
    </div>
  </div> -->
  <!-- End modal step-->


  <script src="/js/front-js/jquery.min.js"></script>
  <script src="/js/bootstrap/bootstrap.min.js"></script>
  <script src="/js/back-js/create-table.js"></script>
</body>

</html>