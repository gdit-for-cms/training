<div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="row">
        <div class="col-12 text-center">
            <button id="createFilesButton" data-id="<?php echo $exam['id'] ?>" id="submit" class="btn btn-primary btn-upload-file-ftp">Export</button>
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
                    <h5 class="border-bottom pb-2 mb-0">Câu <?php echo $stt; ?>:</h5>
                    <div class="d-flex text-muted pt-3">
                        <?php echo $question_answer['question']['content']; ?>
                    </div>
                    <div class="d-flex text-muted pt-3">
                        <?php $answerIndex = 0;
                        foreach ($question_answer['answers'] as $answer) {
                            if ($answer['is_correct'] == 1) {
                                $csv_answer .= "$stt,$alphabet[$answerIndex]\n";
                            }
                        ?>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?php echo $stt; ?>" id="<?php echo $stt; ?>_<?php echo $alphabet[$answerIndex]; ?>" />
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
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="row">
                    <div class="col-12 text-center">
                        <button id="btn_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal modal-lg" id="accept_submit" data-bs-backdrop="false" data-bs-keyboard="false" tabindex="-1" aria-labelledby="anchor-nameLabel" aria-hidden="true" style="margin-left: 550px; margin-top: 300px;">
            <div class="modal-dialog">
                <div class="modal-content modal-accept-submit">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Warning</h5>
                        <button type="button" class="btn-close" id="btn_close_accept_submit"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 id="message">Are you sure to submit?</h4>
                        <button id="btn_accept_submit" class="btn btn-danger mt-1">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<div class="hidden" id="csv_answer"><?php echo $csv_answer; ?></div>
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