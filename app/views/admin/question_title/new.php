<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New collection</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_new_question_title" class="ml-10 col-12" action="/admin/question-title/create" method="POST">
                    <div class="mb-3 col-10">
                        <label class="form-label" for="title">Title<span style="color: red;">*</span></label>
                        <input class="form-control" rows="3" name="title" id="title" placeholder="Title..." />
                    </div>
                    <div class="mb-3 col-10">
                        <label class="form-label" for="title">Description</label>
                        <textarea class="form-control" rows="10" name="description" id="description" placeholder="Description..."></textarea>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>