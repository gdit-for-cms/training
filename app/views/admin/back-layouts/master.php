<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="/css/back-css/dashboard.css" rel="stylesheet">

</head>
<body>
    <?php require_once 'header.php' ?>
    <div class="container-fluid main-container">
        <div class="fixed mt-20">
            <?php require_once 'menu.php' ?>
        </div>
        <div class="flex w-full ml-50">
            <?php require_once '../app/views/admin/'.$content.'.php'?> 
        </div>
    </div>
    
    
    <script src="/js/front-js/jquery.min.js"></script>
    <script src="/js/front-js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="/js/header.js"></script>
    <script type="text/javascript" src="/js/dashboard.js"></script>
    <script src="/js/back-js/main.js"></script>
</body>
</html>