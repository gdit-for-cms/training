<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- Start: top -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Internship</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                </ul>
            </div>
        </div>
    </nav>
    <!-- End: top -->
    <!-- Start: main -->
    <main class="container">
        <div class="bg-body-tertiary p-5 rounded">
            <form id="form_exam">
                <?php for ($i = 1; $i <= 10; $i++) { ?>
                    <h4>Câu <?php echo ($i) ?>:</h4>
                    <p class="lead">Click the button below to add 1 million rows of DB and how long it takes to add?</p>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_A">
                                <label class="form-check-label" for="<?php echo ($i) ?>_A">
                                    <strong>A:</strong> Default radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_C">
                                <label class="form-check-label" for="<?php echo ($i) ?>_C">
                                    <strong>C:</strong> Default checked radio
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_B">
                                <label class="form-check-label" for="<?php echo ($i) ?>_B">
                                    <strong>B:</strong> Default radio
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo ($i) ?>" id="<?php echo ($i) ?>_D">
                                <label class="form-check-label" for="<?php echo ($i) ?>_D">
                                    <strong>D:</strong> Default checked radio
                                </label>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <button id="btn_submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <!-- End: main -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="/index.js"></script>
    <!-- <script src="/server.js"></script> -->
</body>

</html>