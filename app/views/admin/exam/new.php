<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New exam</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_new_exam col-12" class="" action="insert" method="POST">
                    <div class="flex">
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="title">Title <span style="color: red;">*</span></label>
                            <input class="form-control" rows="3" name="title" id="title" placeholder="Title..." />
                        </div>
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="minutes">Duration (minutes)<span style="color: red;">*</span></label>
                            <input class="form-control" type="number" name="duration" id="duration" placeholder="Duration..." min="0" />
                        </div>
                        <div class="mb-3 col-3 mr-7">
                            <label class="form-label" for="title">Description</label>
                            <input class="form-control" rows="3" name="description" id="description" placeholder="Description..." />
                        </div>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Creatse</button>
                </form>
            </div>
        </div>
    </div>
</div>