<div class="container-fluid p-0 ">
    <div class="row">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0">
                        <div class="main-title">
                            <h3 class="m-0">Add new Exam</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body mx-5">
                    <form action="create" method="post" class="add-exam-form">
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <select class="form-select" id="select-topic" name="topic_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="follow id">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Ex: Test PHP">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="follow id">Number of questions</label>
                            <input type="number" class="form-control" name="count_q" min="1" max="100">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="follow id">Time Limit (min)</label>
                            <input type="number" class="form-control" name="timelimit" min="5" max="100" step="5">
                        </div>
                        <button type="submit" class="btn btn-primary" id="">Next</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>