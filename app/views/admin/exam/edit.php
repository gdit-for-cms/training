<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit exam</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_edit_exam" class="" action="update" method="POST">
                    <input id="id" name="id" value="<?php echo $exam['id'] ?>" type="hidden" class="form-control">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title*</label>
                        <input class="form-control" rows="3" value="<?php echo $exam['title'] ?>" name="title" id="title" placeholder="Title..." />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="title">description</label>
                        <input class="form-control" rows="3" name="description" value="<?php echo $exam['description'] ?>" id="description" placeholder="Description..." />
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>