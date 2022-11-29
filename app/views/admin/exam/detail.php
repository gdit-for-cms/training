<div class="container-fluid p-0 ">
    <div class="row here">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0 justify-content-start">
                        <div class="main-title">
                            <h3 class="m-0">Question 1.</h3>
                        </div>
                        <div class="ml-3">
                            <button class="btn btn-outline-primary rounded-pill mb-3 create-q-btn">Create</button>
                            <button class="btn btn-outline-secondary rounded-pill mb-3 pick-q-btn">Pick from data available</button>
                        </div>
                    </div>
                </div>
                <div class="card-body mx-5 d-none  pb-3">
                    <form action="/question/create" method="post" class="add-question-form">
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <select class="form-control q-type" name="type">
                                    <option selected>Choose type</option>
                                    <option>Radio</option>
                                    <option>Checkbox</option>
                                    <option>Text</option>
                                    <option>Textarea</option>
                                </select>
                            </div>
                        </div>
                        <div class="before-select-type radio-checkbox">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="follow id">Question title (*)</label>
                                <input type="text" class="form-control add-question-name" name="name" placeholder="Ex: Test PHP" maxlength="225">
                            </div>
                            <div class="row mb-3">
                                <label for="opt-1" class="form-label col-sm-1 col-form-label">Option 1</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-1">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-2" class="form-label col-sm-1 col-form-label">Option 2</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-2">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-3" class="form-label col-sm-1 col-form-label">Option 3</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-3">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-4" class="form-label col-sm-1 col-form-label">Option 4</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-4">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-1" class="form-label col-sm-1 col-form-label">Answer</label>
                                <div class="col-sm-3">
                                    <select class="form-select select-answer" name="answer" >
                                        <option value="1" selected>Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary my-2 add-q-btn"  disabled>Confirm</button>
                        </div>
                        <div class="text-textarea col-sm-4">
                            <textarea class="form-control" maxlength="225" rows="3" name="maxlength-textarea" id="maxlength-textarea" placeholder="Features not released yet"></textarea> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row " id="add-exam-next-form">
        <div class="col-12">
            <div class="white_card card_height_100 mb_30">
                <div class="white_card_header">
                    <div class="box_header m-0 justify-content-start">
                        <div class="main-title">
                            <h3 class="m-0">Question 2.</h3>
                        </div>
                        <div class="ml-3">
                            <button class="btn btn-outline-primary rounded-pill mb-3 create-q-btn">Create</button>
                            <button class="btn btn-outline-secondary rounded-pill mb-3 pick-q-btn">Pick from data available</button>
                        </div>
                    </div>
                </div>
                <div class="card-body mx-5 d-none">
                    <form action="/question/create" method="post" class="add-question-form">
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <select class="form-control q-type" name="type">
                                    <option selected>Choose type</option>
                                    <option>Radio</option>
                                    <option>Checkbox</option>
                                    <option>Text</option>
                                    <option>Textarea</option>
                                </select>
                            </div>
                        </div>
                        <div class="before-select-type radio-checkbox" >
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="follow id">Question title</label>
                                <input type="text" class="form-control add-question-name" name="name" placeholder="Ex: Test PHP">
                            </div>
                            <div class="row mb-3">
                                <label for="opt-1" class="form-label col-sm-1 col-form-label">Option 1</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-1">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-2" class="form-label col-sm-1 col-form-label">Option 2</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-2">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-3" class="form-label col-sm-1 col-form-label">Option 3</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-3">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-4" class="form-label col-sm-1 col-form-label">Option 4</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="opt-4">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="opt-1" class="form-label col-sm-1 col-form-label">Answer</label>
                                <div class="col-sm-3">
                                    <select class="select-answer" name="answer" >
                                        <option selected>Choose</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                        <option value="4">Option 4</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id=""disabled>Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>