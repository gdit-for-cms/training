<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question</title>
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/css/back-css/preview.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="content_question my-5" data-question-id="1" data-question-required="0">
            <div class="wrapper_question p-3">
                <img src="/img/1.png" alt="" width="50px" height="50px">
                <h5 class="question">Question</h5>
                <h5 class="question_title p-3">
                    引越をされる方(複数選択可）
                </h5>
            </div>
            <div class="content_answer row">
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_1" data-answer-id="1" data-disable-answer="2, 3, " data-step="1-1, ">
                        <label class="answer_content h5 p-3" for="answer_1">
                            成人（高校生も含む）
                        </label>
                    </div>
                </div>
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_2" data-answer-id="2" data-disable-answer="" data-step="1-2, ">
                        <label class="answer_content h5 p-3" for="answer_2">
                            成人（高校生も含む）
                        </label>
                    </div>
                </div>
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_3" data-answer-id="3" data-disable-answer="" data-step="1-3, 1-4, " data-question-id="2">
                        <label class="answer_content h5 p-3" for="answer_3">
                            小中学生
                        </label>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="content_question my-5" data-parent-answer-id="3" data-question-id="2" data-question-required="1">
            <div class="wrapper_question p-3">
                <img src="/img/1.png" alt="" width="50px" height="50px">
                <h5 class="question">Question</h5>
                <h5 class="question_title p-3">
                    前住所について
                </h5>
            </div>
            <div class="content_answer row">
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_4" data-answer-id="4" data-disable-answer="" data-step="1-3, 1-4, ">
                        <label class="answer_content h5 p-3" for="answer_4">
                            他市区町村からの転入
                        </label>
                    </div>
                </div>
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_5" data-answer-id="5" data-disable-answer="" data-step="1-5, ">
                        <label class="answer_content h5 p-3" for="answer_5">
                            国外からの転入
                        </label>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="content_question my-5" data-question-id="3" data-question-required="1">
            <div class="wrapper_question p-3">
                <img src="/img/1.png" alt="" width="50px" height="50px">
                <h5 class="question">Question</h5>
                <h5 class="question_title p-3">
                    新住所について(複数選択不可）
                </h5>
            </div>
            <div class="content_answer row">
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_6" data-answer-id="6" data-disable-answer="" data-step="1-6, ">
                        <label class="answer_content h5 p-3" for="answer_6">
                            市営住宅、県営住宅に入居する
                        </label>
                    </div>
                </div>
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_7" data-answer-id="7" data-disable-answer="" data-step="1-7, ">
                        <label class="answer_content h5 p-3" for="answer_7">
                            介護施設に入所する
                        </label>
                    </div>
                </div>
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_8" data-answer-id="8" data-disable-answer="" data-step="1-8, ">
                        <label class="answer_content h5 p-3" for="answer_8">
                            新築住宅に住む(集合住宅を含む)
                        </label>
                    </div>
                </div>
                <div class="wrapper_answer col-4">
                    <div class="answer d-flex flex-row m-3 p-2">
                        <input class="ms-3" type="checkbox" id="answer_9" data-answer-id="9" data-disable-answer="" data-step="1-9, ">
                        <label class="answer_content h5 p-3" for="answer_9">
                            既存住宅に住む(集合住宅を含む)
                        </label>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="d-flex justify-content-end mb-5">
            <button type="button" class="btn btn-primary button_view_result">
                View result
            </button>
        </div>
    </div>

    <script src="/js/front-js/jquery.min.js"></script>
    <script src="/js/boostrap/bootstrap.min.js"></script>
</body>

</html>