<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Exam template</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

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


    <!-- Custom styles for this template -->
    <link href="/css/offcanvas.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg fixed-top navbar-white bg-white" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Internship</a>
            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-primary rounded shadow-sm">
            <img class="me-3" src="https://media.licdn.com/dms/image/C560BAQFqUuRAIwl4wg/company-logo_200_200/0/1590046309117?e=2147483647&v=beta&t=C2Rga75MUGjLdkTZ5ZkcdKibHqNO0TI86HSpBY2QaFA" alt="" width="48" height="48">
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1">Global Design Information Technology</h1>
                <small>Title here...</small>
            </div>
        </div>
        <form id="form_exam">
            <?php for ($i = 1; $i <= 10; $i++) { ?>
                <div class="my-3 p-3 bg-body rounded shadow-sm">
                    <h5 class="border-bottom pb-2 mb-0">Câu <?php echo ($i) ?>:</h5>
                    <div class="d-flex text-muted pt-3">
                        <h5>
                            <p class="pb-3 mb-0 small lh-sm border-bottom">
                                <strong class="d-block text-gray-dark">Click the button below to add 1 million rows of DB and how long it takes to add?</strong>
                            </p>
                        </h5>
                    </div>
                    <div class="d-flex text-muted pt-3">
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_A">
                                <label class="form-check-label" for="<?php echo ($i) ?>_A">
                                    <strong>A:</strong> Default radio
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_B">
                                <label class="form-check-label" for="<?php echo ($i) ?>_B">
                                    <strong>B:</strong> Default checked radio
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_C">
                                <label class="form-check-label" for="<?php echo ($i) ?>_C">
                                    <strong>C:</strong> Default checked radio
                                </label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_D">
                                <label class="form-check-label" for="<?php echo ($i) ?>_D">
                                    <strong>D:</strong> Default checked radio
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="row">
                    <div class="col-12 text-center">
                        <button id="btn_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
</body>

</html>