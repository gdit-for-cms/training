<div class="box-lightbox">
    <div class="col-lg-6">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h2 class="m-0">Add new topic</h2>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">
                    <form action="create" method="post" id="add-topic-form">
                        <input type="hidden" name="id" class="form-control" id="id-cate" >
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="name">Name Category</label>
                            <input type="text" name="name" class="form-control" id="name-cate" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="slug">slug</label>
                            <input type="text" name="slug" id="slug-cate" class="form-control" >
                        </div>
                        <div class="model-footer">
                            <button type="button" class="btn btn-secondary js-lightbox-close" >Close</button>
                            <button class="btn btn-primary" id="updateCategory" disabled>Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



