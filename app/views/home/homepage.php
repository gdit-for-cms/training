<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/front-css/main.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header id="header">
        <div class="header-main">
            <div class="box-left">
                <div class="item box-left-logo">
                    <a href="" style="line-height: 100%;">
                        <img src="{{ asset('img/Frame2.png') }}" alt="logo" width="200px">
                    </a>
                </div>
            </div>
            <div class="box-right">
                <div class="item login">
                    <?php 
                        if (isset($_SESSION['currentUser'])) { ?>
                            <strong>
                                <a href="/logout"class="text-black open-login">
                                    <?= $_SESSION['currentUser']['name']  ?>
                                </a>
                            </strong>
                    <?  } else { ?>
                            <span>Are you a member?</span>
                            <strong>
                                <a id="modal-trigger" class="text-black open-login">
                                    Register / Login
                                </a>
                            </strong>
                    <?  }  ?>
                    
                </div>
                <div class="item" id="Cart-or-something">
                    <a href="" class="button black">
                        <span>History</span>
                    </a>
                </div>
            </div>
            <div class="logo-header">
                <a href="" aria-label="pirots">
                    PHP INTERNSHIP 
                </a>
            </div>
        </div>
    </header>
</body>
</html>