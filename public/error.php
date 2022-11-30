<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link href="/css//bootstrap/error.css" rel="stylesheet">
    <title>Error</title>
</head>

<body>
    <main>
        <?php if ($line != '') { ?>
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h2>Message: <?php echo $message ?></h2>
                    <h3>Thrown in <?php echo $file ?> on line <?php echo $line ?></h3>
                    <a href="javascript:history.back()" class="btn green">Back</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <h1>404</h1>
                        <h2>UH OH! You're lost.</h2>
                        <p>The page you are looking for does not exist.
                            How you got here is a mystery. But you can click the button below
                            to go back to the homepage.
                        </p>
                        <a href="javascript:history.back()" class="btn green">HOME</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </main>
</body>
</html>