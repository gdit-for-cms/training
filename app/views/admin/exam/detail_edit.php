<div class="col-lg-12">
    <div class="white_card card_height_100 mb_30">
        <div class="white_card_header">
            <div class="box_header m-0">
                <div class="main-title">
                    <h3 class="m-0">Edit Question</h3>
                </div>
            </div>
        </div>
        <div class="white_card_body">
            <div class="card-body">
                <form id="form_edit_detail_exam" class="" action="edit-detail-exam" method="POST">
                    <input id="quesion_id" name="question_id" value="<?php echo  $question['id'] ?>" type="hidden" class="form-control">
                    <input id="exam_id" name="exam_id" value="<?php echo  $exam_id; ?>" type="hidden" class="form-control">

                    <div class="col-md-4">
                        <label class="form-label font-weight-bold" for="position">Question*</label>
                        <?php echo $question['content']; ?>
                        <div id="answerList">
                            <table class="table table-border">
                                <tr>
                                    <th>Select</th>
                                    <th>Content</th>
                                    <th>Is Correct</th>
                                </tr>
                                <?php
                                foreach ($answers as $answer) {
                                    $check = false;
                                    $check = $check || in_array($answer['id'], array_column($exam_questions, 'answer_id'));
                                ?>
                                    <tr>
                                        <td>
                                            <input <?php echo $check ? 'checked' : 'check';  ?> value="<?php echo $answer['id']; ?>" type="checkbox" name="selected_answer[]">
                                        </td>
                                        <td><?php echo $answer['content']; ?></td>
                                        <td><?php echo ($answer['is_correct'] == 1) ? "true" : "false"; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                    <br>
                    <!-- <button id="submit" data-id="<?php echo $exam_id; ?>" type="submit" class="btn btn-edit-detail-exam btn-primary">Edit</button> -->
                    <button id="submit" type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>