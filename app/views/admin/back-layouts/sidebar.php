<nav class="sidebar">
    <div class="logo d-flex justify-content-between">
        <a class="large_logo" href="/admin/dashboard"><img src="" alt=""></a>
        <a class="small_logo" href="/admin/dashboard"><img src="" alt=""></a>
        <div class="sidebar_close_icon d-lg-none">
            <i class="ti-close"></i>
        </div>
    </div>
    <ul id="sidebar_menu" class="metismenu">

        <?php
        if ($cur_user) {
            if ($cur_user['role_id'] == 1) {
        ?>
                <li class=" user">
                    <a class="has-arrow" href="/admin/user/index" aria-expanded="false">
                        <div class="nav_icon_small">
                            <img src="" alt="">
                        </div>
                        <div class="nav_title">
                            <span>User</span>
                        </div>
                    </a>
                </li>
                <li class=" room">
                    <a class="has-arrow" href="/admin/room/index" aria-expanded="false">
                        <div class="nav_icon_small">
                            <img src="" alt="">
                        </div>
                        <div class="nav_title">
                            <span>Room</span>
                        </div>
                    </a>
                </li>
                <li class="position">
                    <a class="has-arrow " href="/admin/position/index" aria-expanded="false">
                        <div class="nav_icon_small">
                            <img src="" alt="">
                        </div>
                        <div class="nav_title">
                            <span>Position</span>
                        </div>
                    </a>
                </li>
                <?php
            }

            if ($cur_user['permissions']) {
                foreach ($cur_user['permissions'] as $item) {
                    if ($item['controller'] != 'admin') {
                ?>
                        <li class="<?php echo $item['controller'] ?>">
                            <a class="has-arrow" href="/admin/<?php echo $item['controller'] ?>/index" aria-expanded="false">
                                <div class="nav_icon_small">
                                    <img src="" alt="">
                                </div>
                                <div class="nav_title">
                                    <span><?php
                                            if (isset($item['permisson_name'])) {
                                                echo $item['permisson_name'];
                                            } else {
                                                echo $item['name'];
                                            }
                                            ?></span>
                                </div>
                            </a>
                        </li>
        <?php
                    }
                }
            }
        }
        ?>
    </ul>
</nav>