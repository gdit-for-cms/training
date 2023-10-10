<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit question collection</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_update_question" class="ml-10 col-12" action="/admin/question-title/update" method="POST">
                    <input type="hidden" class="form-control" rows="3" value="<?php echo $question_title['id']; ?>" name="id" id="id" placeholder="Title..." />

                    <div class="mb-3 col-6">
                        <label class="form-label" for="title">Title<span style="color: red;">*</span></label>
                        <input class="form-control" rows="3" value="<?php echo $question_title['title']; ?>" name="title" id="title" placeholder="Title..." />
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label" for="title">Description</label>
                        <textarea class="form-control" rows="10" value="" name="description" id="description" placeholder="Description..."><?php echo isset($question_title['description']) ? $question_title['description'] : ''; ?></textarea>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
