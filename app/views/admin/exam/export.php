<?php
// $ftp_server = 'ftp.example.com';
// $ftp_username = 'your_ftp_username';
// $ftp_password = 'your_ftp_password';
// $ftp_directory = '/path/to/destination/directory/';

// $local_html_file = 'path/to/local/file.html';
// $local_csv_file = 'path/to/local/file.csv';

// $remote_html_file = $ftp_directory . 'file.html';
// $remote_csv_file = $ftp_directory . 'file.csv';

// $conn_id = ftp_connect($ftp_server);
// $login_result = ftp_login($conn_id, $ftp_username, $ftp_password);

// if ($conn_id && $login_result) {
//     if (
//         ftp_put($conn_id, $remote_html_file, $local_html_file, FTP_BINARY) &&
//         ftp_put($conn_id, $remote_csv_file, $local_csv_file, FTP_BINARY)
//     ) {
//         echo "Files uploaded successfully.";
//     } else {
//         echo "File upload failed.";
//     }

//     ftp_close($conn_id);
// } else {
//     echo "Could not connect to FTP server.";
// }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Files</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <button id="createFilesButton">Create Filesss\\\</button>

    <script>
        $(document).ready(function() {
            $("#createFilesButton").click(function() {
                createFiles();
            });
        });

        function createFiles() {
            var filename = "exam"; // Tên của file (không có phần mở rộng)
            var html_content = '<html><head><title>Examssss</title></head><body><h1>Exam Content</h1></body></html>';
            var csv_content = '1, C' + '\n' + '2, A' + '\n' + '3, D';

            // Tạo file HTML và CSV bằng JavaScript
            var html_blob = new Blob([html_content], {
                type: 'text/html'
            });
            var csv_blob = new Blob([csv_content], {
                type: 'text/csv'
            });

            var html_link = document.createElement('a');
            var csv_link = document.createElement('a');

            html_link.href = URL.createObjectURL(html_blob);
            html_link.download = filename + '.html';
            document.body.appendChild(html_link);
            html_link.click();
            document.body.removeChild(html_link);

            csv_link.href = URL.createObjectURL(csv_blob);
            csv_link.download = filename + '.csv';
            document.body.appendChild(csv_link);
            csv_link.click();
            document.body.removeChild(csv_link);
        }
    </script>
</body>

</html>