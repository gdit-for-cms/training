<div class="container-fluid g-0">
<?php require_once 'modals.php' ?>
<?php require_once 'modals-link.php' ?>
    <div class="row">
        <div class="col-lg-12 p-0 ">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div class="line_icon open_miniSide d-none d-lg-block">
                    <img src="" alt="">
                </div>
                <div class="serach_field-area d-flex align-items-center">
                    <div class="search_inner">
                        <form action="#">
                            <div class="search_field">
                                <input type="text" placeholder="Search">
                            </div>
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="header_notification_warp d-flex align-items-center">
                    </div>
                    <div class="profile_info">
                        <?php if ($_SESSION['user']['avatar_image']) { ?>
                            <div class="rounded-circle border cursor-pointer flex items-center justify-center w-10 h-10 bg-gray-600 text-sm text-white font-bold align-middle"><?php echo strtoupper(substr($_SESSION['user']['name'], 0, 1)) ?></div>
                        <?php } else { ?>
                            <img src="/<?php echo $_SESSION['user']['avatar_image'] ?>" class="rounded-circle cursor-pointer border" alt="example placeholder" />
                        <?php } ?>
                        <div class="profile_info_iner border" style="top: 60px; right: -5px;">
                            <div class="profile_info_details">
                                <a href="/admin/admin/show">My Profile</a>
                                <a href="/admin/auth/logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>