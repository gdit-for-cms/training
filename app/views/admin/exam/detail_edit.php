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
                <form id="form_create_exam" class="" action="store?exam_id=<?php echo $exam['id']; ?>" method="POST">
                    <div class="col-md-4">
                        <label class="form-label" for="position">Question*</label>
                        <select id="questionSelect" name="question_id" onchange="loadAnswers()" class="form-control">
                            <option disabled selected value="">-- Choose question --</option>
                            <?php foreach ($questions as $question) { ?>
                                <option value="<?= $question['id'] ?>">
                                    <?= $question['content'] ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div id="answerList"></div>
                    </div>
                    <br>
                    <button id="submit" type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    const answerList = document.getElementById('answerList')
    const answerListElement = document.createElement('div')
</script>