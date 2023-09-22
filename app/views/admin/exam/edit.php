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
                    <h3 class="m-0">Edit collection exam</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_create_exam" class="" action="update" method="POST">
                    <input class="form-control" type="hidden" value="<?php echo $exam['id']; ?>" rows="3" name="id" />

                    <div class="col-lg-12">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0"></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <div class="card-body d-flex">
                                    <!-- <form id="form_new_question col-12" class="" action="create" method="POST"> -->
                                    <div class="mb-6 col-4 mr-12" style="">
                                        <div class="mb-3 mr-12">
                                            <label class="form-label" for="title">Title </label>
                                            <input class="form-control" name="title" value="<?php echo $exam['title'] ?>" rows="3" placeholder="title..." />
                                        </div>
                                        <div class="mb-3  mr-12">
                                            <label class="form-label" for="description">Description collection </label>
                                            <input class="form-control" name="description" value="<?php echo isset($exam['description']) ? $exam['description'] : "" ?>" rows="3" placeholder="description..." />
                                        </div>
                                    </div>

                                    <div class="mb-6 col-2 mr-12" style="">
                                        <div class="mb-3 ">
                                            <label class="form-label" for="duration">Duration (minutes) </label>
                                            <input class="form-control" name="duration" value="<?php echo $exam['duration'] ?>" rows="3" placeholder="duration..." />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="status">Status </label>
                                            <input class="form-control" disabled value="<?php echo $exam['published'] == 1 ? "Đã upload lên server" : " Chưa upload lên server" ?>" rows="3" placeholder="status..." />
                                        </div>
                                    </div>
                                    <div class="col-4 mr-7">

                                        <div id="answerContainer">
                                            <label class="form-label" for="email">Email participant</label>
                                            <!-- Ô input mặc định -->
                                            <?php if (count($emails) > 0) {
                                                foreach ($emails as $email) { ?>
                                                    <div class="form-check" style="padding-left: 45px;">
                                                        <div class="input-with-button">
                                                            <input type="text" class="form-control input-answer" name="email[]" value="<?php echo $email['email']; ?>" placeholder="Email...">
                                                            <button type="button" class="remove-button btn btn-danger delete-btn text-white" onclick="removeAnswer(this)">Delete</button>
                                                        </div>
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                        <div class="input-add-answer">
                                            <button type="button" class="btn btn-info m-2" onclick="addAnswer()">Thêm</button>
                                        </div>

                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>