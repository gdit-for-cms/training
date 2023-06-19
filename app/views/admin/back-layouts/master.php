<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link href="/css/back-css/dashboard.css" rel="stylesheet">
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
    </link>
    <link href="/css/back-css/style.css" rel="stylesheet">
    <script src="/js/front-js/jquery.min.js"></script>
    <script src="/ckeditor5-build-classic/ckeditor.js"></script>
    <script type="text/javascript">
        (function() {
            var css = document.createElement('link');
            css.href = 'https://use.fontawesome.com/releases/v6.2.0/css/all.css';
            css.rel = 'stylesheet';
            css.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>
</head>

<body class="crm_body_bg">
    <?php require_once 'sidebar.php' ?>
    <section class="main_content dashboard_part large_header_bg">
        <?php require_once 'header.php' ?>
        <div class="main_content_iner overly_inner ">
            <?php require_once '../app/views/admin/' . $content . '.php' ?>
        </div>
        </div>
        <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
        <script src="/js/front-js/sweetalert2.all.min.js"></script>
        <script src="/js/back-js/main.js"></script>
        <script src="/js/boostrap/bootstrap.min.js"></script>
        <script>
            const url = window.location.href
            console.log(url);
            const controller = url.split('/')[4]
            var navItem = ''
            navItem = document.querySelector(`.${controller}`)
            navItem.querySelector('a').classList.add('fw-bold', 'list-group-item', 'active')
        </script>
</body>

</html>