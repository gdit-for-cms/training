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