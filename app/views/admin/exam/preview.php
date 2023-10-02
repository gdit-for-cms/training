<div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="row">
        <div class="col-12 text-center">
            <a class="btn btn-danger" href="/admin/exam/examDetail?exam_id=<?php echo $exam['id'] ?>" class="page-link">Back</a>
            <button id="createFilesButton" data-id="<?php echo $exam['id'] ?>" <?php echo count($question_answers) > 0 ? "" : "disabled" ?> id="submit" class="btn btn-primary btn-upload-file-ftp">Publish To Server</button>
            <!-- <a href="/admin/exam-question/new?exam_id=<?php echo $exam['id']; ?>"><button type=" button" class="btn btn-success">Add Question</button></a> -->
        </div>
    </div>
</div>
<div id="content_exam">
    <nav class="navbar navbar-expand-lg fixed-top navbar-white bg-white" aria-label="Main navigation">
        <div class="container-fluid">
            <div id="view_time" class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                <div id="countdown" class="lh-1">
                </div>
            </div>
            <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                <Strong class="me-1">Email: </Strong>
                <div id="show_email" class="me-2"></div>
                <Strong class="me-1">Name: </Strong>
                <div id="show_name"></div>
            </div>
        </div>
    </nav>
    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-primary rounded shadow-sm">
            <img class="me-3" src="https://media.licdn.com/dms/image/C560BAQFqUuRAIwl4wg/company-logo_200_200/0/1590046309117?e=2147483647&v=beta&t=C2Rga75MUGjLdkTZ5ZkcdKibHqNO0TI86HSpBY2QaFA" alt="" width="48" height="48">
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1">Global Design Information Technology</h1>
                <small><?php echo $exam['title']; ?></small>
            </div>
        </div>
        <form id="form_exam">
            <?php
            $csv_answer = "";
            $stt = 1;
            $alphabet = range('A', 'Z');
            foreach ($question_answers as $question_answer) { ?>
                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h5 class="border-bottom">
                        <div class="d-flex text-muted pt-3">
                            <?php echo $question_answer['question']['content']; ?>
                        </div>
                    </h5>
                    <div class="d-flex text-muted pt-3">
                        <?php $answerIndex = 0;
                        foreach ($question_answer['answers'] as $answer) {
                            if ($answer['is_correct'] == 1) {
                                $csv_answer .= "$stt,$alphabet[$answerIndex]\n";
                            }
                        ?>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="<?php echo $stt; ?>" id="<?php echo $stt; ?>_<?php echo $alphabet[$answerIndex]; ?>" />
                                    <label class="form-check-label " for="<?php echo $stt; ?>_<?php echo $alphabet[$answerIndex]; ?>">
                                        <strong><?php echo $alphabet[$answerIndex] ?>:</strong> <?php echo $answer['content'] ?>
                                    </label>
                                </div>
                            </div>
                        <?php $answerIndex++;
                        } ?>
                    </div>
                </div>
            <?php
                $stt++;
            }
            ?>
        </form>
        <div class="my-3 p-3 bg-body rounded">
            <div class="row">
                <div class="col-12 text-center">
                    <button id="btn_submit" class="btn btn-primary" disabled>Submit</button>
                </div>
            </div>
        </div>
        <div class="modal" id="accept_submit" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="anchor-nameLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-accept-submit">
                    <div class="modal-header" style="margin-top: -18px;">
                        <h5 class="modal-title">Warning</h5>
                        <button type="button" class="btn-close" id="btn_close_accept_submit"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h5 id="message">Are you sure to submit?</h5>
                    </div>
                    <div class="modal-footer" style="margin-bottom: -18px;">
                        <button id="btn_accept_submit" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<div class="hidden" id="csv_answer"><?php echo $csv_answer; ?></div>
<!-- exam participants -->
<?php
$participants = "";
if (count($exam_participants) > 0) {
    foreach ($exam_participants as $exam_participant) {
        $participants .= $exam_participant['email'] . "," . $exam_participant['is_login'] . "," . $exam_participant['is_submit'] . "\n";
    }
}
?>
<div class="hidden" id="csv_exam_participants"><?php echo $participants; ?></div>
<script>
    const submitBtn = document.querySelector('#submit')

    function validate() {
        if (titleInput.value == '') {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }
</script>