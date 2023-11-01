<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New exam</h3>
                </div>
            </div>
        </div>
        <?php if (isset($_SESSION['msg'])) {
            $msg =  $_SESSION['msg']['message'];
            $type =  $_SESSION['msg']['type'];

            echo " <div class='alert alert-$type' role='alert'>
                                             $msg   
                                           </div>";
            unset($_SESSION['msg']);
        }
        ?>
        <div class="white_card_body" style="margin-left: 15px;">
            <div class="card-body">
                <div class="mb-3 col-10 mr-12">
                    <form id="form_create_exam" action="create" method="POST">
                        <input type="hidden" value="<?= $cur_user['user_id'] ?>" name="user_id">
                        <div>
                            <div class="mb-3 col-8 mr-7">
                                <label class="form-label" for="title">Title <span style="color: red;">*</span></label>
                                <input class="form-control" rows="3" name="title" id="title" placeholder="Title..." />
                            </div>
                            <div class="mb-3 col-8 mr-7">
                                <label class="form-label" for="title">Description</label>
                                <textarea class="form-control" rows="7" name="description" id="description" placeholder="Description..."></textarea>
                            </div>
                            <div class="mb-3 col-8 mr-7">
                                <label class="form-label" for="date start">Time start</label>
                                <input class="form-control" type="datetime-local" name="date_start" id="date_start" />
                            </div>
                            <div class="mb-3 col-8 mr-7">
                                <label class="form-label" for="date end">Time end</label>
                                <input class="form-control" type="datetime-local" name="date_end" id="date_end" />
                            </div>
                        </div>
                        <label class="form-label" for="email">Email participant</label>

                        <div class="col-12 d-flex">
                            <div id="answerContainer">
                                <div class="form-check mb-3" style="padding-left: 45px;">
                                    <div class="input-with-button">
                                        <input type="text" class="form-control input-answer" name="email[]" value="" placeholder="email...">
                                        <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <div class="input-add-answer col-3">
                                <button type="button" class="btn btn-info ml-3 text-white" style="margin-top: 3px;" onclick="addAnswer()">Add</button>
                            </div>
                        </div>
                        <button id="submit" type="submit" class="btn btn-primary ml-3 mt-3">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>