<div class="container-fluid p-0 ">
  <div class="row">
    <div class="col-12">
      <div class="white_card card_box card_height_100 mb_30">
        <div class="white_box_tittle">
          <div class="main-title2 flex items-center justify-between">
            <h4 class="mb-2 nowrap">Create Table</h4>
            <div class="justify-between me-5">
              <form class="json_form" method="POST" action="/admin/preview/index" target="_blank" hidden>
                <input class="json_data" type="hidden" name="json">
              </form>
              <button type="button" class="btn btn-primary button_preview">
                Preview
              </button>
              <button type="button" class="btn btn-primary button_import_json">
                HTML <=> JSON
              </button>
              <button type="button" class="btn btn-success button_question_add">
                Create Question
              </button>
            </div>
          </div>
        </div>
        <div class="white_card_body">
          <div class="table-responsive m-b-30">
            <div class="content_question">
              <?php echo $questions ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>