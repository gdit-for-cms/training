<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="/css/front-css/main.css" rel="stylesheet">
    <title><?= $title ?></title>
</head>
<body>
    <?php require_once 'header.php' ?>
    <?php require_once 'modal.php' ?>
    <div id="container">
        <?php require_once '../app/views/homepage/'.$content.'.php' ?>
    </div>
    <?php require_once 'footer.php' ?>

    <script src="/js/front-js/jquery.min.js"></script>
    <script src="/js/front-js/sweetalert2.all.min.js"></script>
    <script src="/js/front-js/main.js"></script>
    <script>
        $(document).ready(function () {
            $('#modal-trigger').click(function () {
                event.preventDefault();
                $('.box-lightbox').addClass('open');
            })
            $('#js-login').click(function (event) {
                event.preventDefault();
                $('.cd-login').addClass('active');
                $('.cd-signup').removeClass('active');
            })
            $('#js-register').click(function (event) {
                event.preventDefault();
                $('.cd-signup').addClass('active');
                $('.cd-login').removeClass('active');
            })
            $('.js-lightbox-close').click(function () {
                $('.box-lightbox').removeClass('open');
            })
        });
    </script>
</body>

</html>