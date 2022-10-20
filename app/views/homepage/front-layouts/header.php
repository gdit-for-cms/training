<header id="header">
        <div class="header-main">
            <div class="box-left">
                <div class="item box-left-logo">
                    <a href="" style="line-height: 100%;">
                        <img src="" alt="logo" width="200px">
                    </a>
                </div>
            </div>
            <div class="box-right">
                <div class="item login">
                    <?php 
                        if (isset($_SESSION['currentUser'])) { ?>
                            <strong>
                                <a href="logout" class="text-black open-login">
                                    <?= $_SESSION['currentUser']['name']  ?> / Logout
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