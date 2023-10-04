<div class="d-flex">
    <div class="col-3">
        <div class=" metismenu" style="background-color: #dddcdc; margin-right: 15px;">
            <ul class="metismenu" style="padding: 15px 25px">
                <?php foreach ($question_titles as $question_title) { ?>
                    <li class="border has-arrow mb-1 collection_hover" style="display: flex;
    justify-content: space-between;" onclick="getQuestion('<?php echo $question_title['id']; ?>')">
                        <button class="" style="" type="button" class=" dropdown-item ">
                            <?php echo $question_title['title'] ?>
                        </button>
                        <span>3</span>
                    </li>
                <?php } ?>

                <li class="border has-arrow mb-1 collection_hover" style="" onclick="getQuestion('orther')">
                    <button class="" style="" type="button" class=" dropdown-item ">
                        Orther
                    </button>
                </li>
                <!-- <a style="" data-exam_id="<?php echo $exam_id; ?>" id="select" type="submit" class=" btn btn-edit btn-add_question_exam ">Add quick question</a> -->

            </ul>
            <div style=" padding-bottom: 10px;">
                <span style="margin-left: 20px; margin-right: 20px;">Số câu đã chọn : <span id="total_select">0</span> </span><br>
                <div style=" display: flex;justify-content: center;align-items: center;">
                    <a href='/admin/question/new?ques-title=other&exam_id=<?= $exam_id; ?>'><button type="button" class="btn btn-primary ">Add quick question</button></a>
                    <button style="width: 80px; margin: 15px;" data-exam_id="<?php echo $exam_id; ?>" id="select" type="submit" class=" btn btn btn-success btn-add_question_exam">Select</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9 d-flex">
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