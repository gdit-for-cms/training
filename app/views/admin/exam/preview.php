<?php
$ftp_server = '192.168.1.209';
$ftp_username = 'gdit_ftp';
$ftp_password = 'gdit6385';

$connection = ftp_connect($ftp_server);
$login = ftp_login($connection, $ftp_username, $ftp_password);

if ($connection && $login) {
    // Đường dẫn đến thư mục "public"
    $public_directory = '/htdocs/BT1/training/public';
    // Tên thư mục bạn muốn tạo (nếu chưa tồn tại)
    $new_directory = 'file_exam';

    // Đường dẫn đầy đủ của thư mục bạn muốn tạo
    $full_new_directory = $public_directory . '/' . $new_directory;

    // Kiểm tra xem thư mục đã tồn tại hay chưa
    if (!ftp_nlist($connection, $full_new_directory)) {
        // Thư mục chưa tồn tại, tạo và cấp quyền truy cập
        if (ftp_mkdir($connection, $full_new_directory)) {
            ftp_chmod($connection, 0777, $full_new_directory);
        } else {
            echo "Error creating directory";
            exit;
        }
    }

    // Đường dẫn đến file trên máy local
    $local_path = '/htdocs/BT1/training/app/views/admin/exam/';
    $file = 'exam.csv';

    // Tải lên file từ máy local lên máy chủ
    if (ftp_put($connection, $full_new_directory . '/' . $file, $local_path . $file, FTP_BINARY)) {
        echo "File uploaded successfully";
    } else {
        echo "Error uploading file";
    }

    ftp_close($connection);
} else {
    echo 'FTP connection failed';
}
?>
<style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
</style>
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="row">
        <div class="col-12 text-center">
            <button id="createFilesButton" id="submit" class="btn btn-primary">Export</button>
        </div>
    </div>
</div>


<nav class="navbar navbar-expand-lg fixed-top navbar-white bg-white" aria-label="Main navigation">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Internship</a>
        <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
<div id="content">
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
                        <h5>
                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark"><?php echo $question_answer['question']['content']; ?></strong>
                            </p>
                        </h5>
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
    </main>
</div>
<div class="hidden" id="csv_answer"><?php echo $csv_answer; ?></div>
<script>
    const submitBtn = document.querySelector('#submit')



    $(document).ready(function() {
        $("#createFilesButton").click(function() {
            createFiles();
        });
    });

    function createFiles() {
        var filename = "exam";
        var content = document.getElementById('content');
        var csv_content = document.getElementById('csv_answer');
        if (csv_content) {
            csv_content = csv_content.innerHTML;
        }
        if (content) {
            content = content.innerHTML;
        }
        var html_content = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        </head>
        <body>
            ${content}
        </body>
        </html>
    `;


        $.ajax({
            type: "POST",
            url: `/admin/exam/export`, // Đường dẫn tới file xử lý trên server
            data: {
                htmlContent: htmlContent,
                csvContent: csvContent
            },
            success: function(response) {
                if (response === "success") {
                    alert("Publish successful");
                } else {
                    alert("Publish failed");
                }
            },
            error: function() {
                alert("An error occurred");
            }
        });

        // // Tạo file HTML và CSV bằng JavaScript
        // var html_blob = new Blob([html_content], {
        //     type: 'text/html'
        // });
        // var csv_blob = new Blob([csv_content], {
        //     type: 'text/csv'
        // });

        // var html_link = document.createElement('a');
        // var csv_link = document.createElement('a');

        // html_link.href = URL.createObjectURL(html_blob);
        // html_link.download = filename + '.html';
        // document.body.appendChild(html_link);
        // html_link.click();
        // document.body.removeChild(html_link);

        // csv_link.href = URL.createObjectURL(csv_blob);
        // csv_link.download = filename + '.csv';
        // document.body.appendChild(csv_link);
        // csv_link.click();
        // document.body.removeChild(csv_link);
    }

    function validate() {
        if (titleInput.value == '') {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }
</script>