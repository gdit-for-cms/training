<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0 ">Exam</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body" style="margin-left: 15px;">
            <div class="card-body d-flex">
                <div class="mb-3 col-10 mr-12">
                    <?php
                    if ($exam != false) { ?>
                        <b><label class="form-label" for="title">Title : </label></b>
                        <?php echo $exam['title']; ?>
                        <br>
                        <b><label class="form-label" for="title">Description : </label></b>
                        <?php echo isset($exam['description']) ? $exam['description'] : "" ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class=" white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">New participant</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_create_exam" action="update" method="POST">
                    <input type="hidden" name="exam_id" value="<?php echo $exam['id']; ?>">
                    <div class="col-12 d-flex">
                        <div id="answerContainer">
                            <input type="hidden" name="total_email_db" value="<?php echo count($emails); ?>">
                            <?php if (count($emails) > 0) {
                            ?>
                                <?php
                                foreach ($emails as $email) { ?>
                                    <div class="form-check  mb-3" style="padding-left: 45px;">
                                        <div class="input-with-button">
                                            <input type="text" class="form-control input-answer" name="email[]" value="<?php echo $email['email']; ?>" placeholder="email...">
                                            <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <div class="form-check  mb-3" style="padding-left: 45px;">
                                    <div class="input-with-button">
                                        <input type="text" class="form-control input-answer" name="email[]" value="" placeholder="email...">
                                        <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                    </div>
                                </div>
                            <?php
                            } ?>
                        </div>
                        <div class="input-add-answer col-3">
                            <button type="button" class="btn btn-info ml-3 text-white" style="margin-top: 3px;" onclick="addAnswer()">Add</button>
                        </div>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary ml-3 mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
