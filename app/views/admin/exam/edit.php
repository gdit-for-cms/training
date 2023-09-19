<?php
// echo "<pre>";
// var_dump($exam);
// die();
?>
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
                <input class="form-control" type="hidden" value="<?php echo $exam['id']; ?>" rows="3" name="id"  />

                    <div class="flex">
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="title">Title <span style="color: red;">*</span></label>
                            <input class="form-control" value="<?php echo $exam['title']; ?>" rows="3" name="title" id="title" placeholder="Title..." />
                        </div>
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="minutes">Duration (minutes)<span style="color: red;">*</span></label>
                            <input class="form-control" type="number" value="<?php echo $exam['duration']; ?>" name="duration" id="duration" placeholder="Duration..." min="0" />
                        </div>
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="title">Description</label>
                            <input class="form-control" rows="3" value="<?php echo $exam['description']; ?>" name="description" id="description" placeholder="Description..." />
                        </div>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>