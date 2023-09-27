<div class="d-flex">
    <div class="col-2 metismenu" style="background-color: #dddcdc;
    text-align: center;
    margin-right: 15px;">
        <ul class="metismenu" style="padding: 15px 25px">
            <?php foreach ($question_titles as $question_title) { ?>
                <li class="border text-center has-arrow mb-1 collection_hover" style="" onclick="getQuestion('<?php echo $question_title['id']; ?>')">
                    <button class="" style="" type="button" class=" dropdown-item ">
                        <?php echo $question_title['title'] ?>
                    </button>
                </li>
            <?php } ?>
        </ul>
        <div style="display: grid;">
            <span>Số câu đã chọn : <span id="total_select">0</span> </span>
            <button data-exam_id="<?php echo $exam_id; ?>" id="select" type="submit" class="btn btn-primary btn-add_question_exam">Select</button>
        </div>
    </div>
    <div class="col-10 d-flex">
        <div id="questionList" class="col-12">
            <!-- Nơi để hiển thị danh sách câu hỏi sau khi AJAX được gọi -->
        </div>
    </div>
</div>
<script>
    const newArray = []
    let check_click = false;
    let array_select_question = [];
    let select = 0;
</script>
