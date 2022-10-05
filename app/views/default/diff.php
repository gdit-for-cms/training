
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Task</title>
    <style>
        .container {
            display: flex;
        }

        .left,
        .right {
            flex: 1;
            padding: 0 90px;
            border-right: 1px solid #ccc;
            font-size: 32px;
        }
    </style>
</head>

<body>
    <form action="compare" method="post" enctype="multipart/form-data">
        <input type="file" name="file1" />
        <input type="file" name="file2" />
        <input type="submit" class="btn btn-primary" name="importSubmit" value="Import(CSV)">
    </form>


</body>

</html>

