<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PHP FoodCode - Login</title>
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="stylesheet" href="/css/style.css">
    <link href="/css/tailwind/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include jQuery from a CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

    <div class="h-screen" style="font-family: 'Source Sans Pro', sans-serif;">
        <div class="container mx-auto h-full">
            <div class="flex h-full w-full flex-wrap items-center justify-center">
                <div class="block rounded-lg shadow-lg lg:flex lg:flex-wrap" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593)">

                    <!-- Left column container-->
                    <div class="px-4 md:px-0 lg:w-6/12 flex items-center justify-center">
                        <div class="md:m-6 md:p-12 w-3/4 rounded-lg px-4 my-4" style="background: white">

                            <form class="w-full mt-4" action="/auth/loginProcess" method="POST">
                                <p class="mb-4 text-3xl text-center uppercase text-black">Đăng nhập</p>
                                <!--Username input-->
                                <div class="relative mt-4">
                                    <input id="username" type="text" name="name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Tên tài khoản" <?php
                                                                                                                                                                                    if (isset($_SESSION['pre_name'])) {
                                                                                                                                                                                        echo 'value="' . $_SESSION['pre_name'] . '"';
                                                                                                                                                                                    }
                                                                                                                                                                                    unset($_SESSION['pre_name']);
                                                                                                                                                                                    ?> />
                                </div>

                                <?php if (isset($_SESSION['name_error'])) : ?>
                                    <script>
                                        Swal.fire({
                                            title: '<?php echo $_SESSION['name_error']; ?>',
                                            text: 'Vui lòng thử lại',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                    <?php unset($_SESSION['name_error']) ?>
                                <?php endif; ?>


                                <!--Password input-->
                                <div class="relative mt-4">
                                    <input type="password" name="pass" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Mật khẩu" />
                                </div>

                                <?php if (isset($_SESSION['pass_error']) && isset($_SESSION['pre_name_pass'])) : ?>
                                    <script>
                                        Swal.fire({
                                            title: '<?php echo $_SESSION['pass_error']; ?>',
                                            text: 'Vui lòng thử lại',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                        document.getElementById('username').value = '<?php echo $_SESSION['pre_name_pass']; ?>'
                                        <?php unset($_SESSION['name_error']);
                                        unset($_SESSION['pre_name_pass']) ?>
                                    </script>
                                <?php endif; ?>

                                <!-- Forgot password button -->
                                <div class="flex justify-end">
                                    <div class="px-4 inline-block mt-4">
                                        <button type="button" id="forgotPasswordButton" class="text-base text-blue-500 hover:text-blue-700 focus:outline-none focus:underline transition duration-150 ease-in-out">Quên mật khẩu?</button>
                                    </div>
                                </div>

                                <!--Submit button-->
                                <div class="mt-4 mb-2 pb-1 pt-1 text-center">
                                    <button class="inline-block w-full rounded px-6 pb-2 pt-2.5 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="submit" name="submit" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                        Đăng nhập
                                    </button>
                                </div>
                            </form>

                            <!-- Login with Facebook -->
                            <div class="mb-4">
                                <div onclick="loginFacebookSubmit()" class="flex items-center justify-center w-full px-4 py-2 space-x-3 text-sm text-center bg-blue-500 text-white transition-colors duration-200 transform border rounded  hover:bg-blue-600 hover:cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                    </svg>
                                    <span class="text-sm text-white dark:text-gray-200">ĐĂNG NHẬP VỚI FACEBOOK</span>
                                </div>
                            </div>

                            <!--Register button-->
                            <form action="/register/register" class="flex items-center justify-between pb-6">
                                <p class="mb-0 mr-2 text-black ">Bạn chưa có tài khoản?</p>
                                <button type="submit" class="inline-block rounded px-6 pb-[6px] pt-2 text-sm font-medium uppercase leading-normal text-white" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                    Đăng ký
                                </button>
                            </form>
                        </div>

                    </div>

                    <!-- Right column container with background and description-->
                    <div class="flex items-center rounded-b-lg lg:w-6/12 lg:rounded-r-lg lg:rounded-bl-none">
                        <div class="px-4 py-6 md:mx-6 md:p-12">
                            <img src="../img/PHP_Food_Code_logo_large.png" alt="PHP FoodCode">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="forgotPasswordModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay, show modal backdrop -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal panel, show modal content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                Quên Mật Khẩu
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Vui lòng nhập username của bạn để nhận liên kết đặt lại mật khẩu.
                                </p>
                                <form id="emailForm" action="/auth/send-mail" method="POST">
                                    <input onchange="checkValidateName()" id='usernameModal' type="text" name="username" class="mt-3 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline w-full" placeholder="Username của bạn">
                                    <div class="mt-2hidden" id="username_error">
                                        <p class="w-full h-fit text-xs text-red-500" id="username_error_content">
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button onclick="submitMail()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" id="sendEmailButton">
                        Gửi
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="closeModalButton">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Validate Form Login -->
    <script>
        document.querySelector('form').onsubmit = function(e) {
            var name = document.querySelector('input[name="name"]').value.trim();
            var pass = document.querySelector('input[name="pass"]').value;
            if (!name || !pass) {
                Swal.fire('Vui lòng nhập đầy đủ thông tin', '', 'warning');
                e.preventDefault();
            }
        };
    </script>

    <script>
        function loginFacebookSubmit() {
            Swal.fire({
                title: 'Lưu ý',
                text: 'Bạn phải có tài khoản Facebook Developers và được add vào môi trường dev để trải nghiệm chức năng này. Liên hệ nếu chưa thực hiện thao tác trên',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tiếp tục đăng nhập',
                cancelButtonText: 'Đóng'
            }).then((result) => {
                if (result.isConfirmed) {
                    <?php
                    $fb = new Facebook\Facebook([
                        'app_id' => $_ENV['FACEBOOK_APP_ID'],
                        'app_secret' => $_ENV['FACEBOOK_APP_SECRET'],
                        'default_graph_version' => 'v2.10',
                    ]);

                    $helper = $fb->getRedirectLoginHelper();

                    $permissions = ['email'];
                    $loginUrl = $helper->getLoginUrl($_ENV['FACEBOOK_URL_LOGIN'], $permissions);
                    ?>
                    console.log("<?php echo $loginUrl ?>");
                    window.location.href = "<?php echo $loginUrl ?>";
                }
            });
        }
    </script>

    <!-- Modal forgot password -->
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const modal = document.getElementById('forgotPasswordModal');
            const openModalButton = document.getElementById('forgotPasswordButton');
            const closeModalButton = document.getElementById('closeModalButton');

            openModalButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });

            closeModalButton.addEventListener('click', () => {
                modal.classList.add('hidden');
                document.getElementById('email').value = '';
                document.getElementById('email_error').classList.add('hidden');
                document.getElementById('email_error_content').textContent = '';
            });
        });
    </script>

    <!-- Notification when have error login FB -->
    <?php if (isset($_SESSION['fb_login_err'])) : ?>
        <script>
            Swal.fire({
                title: '<?php echo $_SESSION['fb_login_err']; ?>',
                text: 'Vui lòng thử cách đăng nhập khác',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['fb_login_err']); ?>
        </script>
    <?php endif; ?>

    <script>
        function checkValidateName() {
            var usernameEl = document.getElementById('usernameModal').value;
            var usernameError = document.getElementById('username_error');
            var usernameErrorContent = document.getElementById('username_error_content');

            if (usernameEl.trim() === '') {
                usernameError.classList.remove('hidden');
                usernameErrorContent.textContent = 'Tên đăng nhập không được để trống.';
                return false;
            } else if (!/^[a-zA-Z0-9\S]+$/i.test(usernameEl.trim())) {
                usernameError.classList.remove('hidden');
                usernameErrorContent.textContent = 'Tên đăng nhập không được chứa khoảng trắng.';
                return false;
            } else if (usernameEl.trim().length < 3 || usernameEl.trim().length > 50) {
                usernameError.classList.remove('hidden');
                usernameErrorContent.textContent = 'Tên đăng nhập có độ dài từ 3 đến 50 ký tự.';
                return false;
            } else {
                usernameError.classList.add('hidden');
                return true;
            }
        }

        function submitMail() {
            if (checkValidateName()) {
                document.getElementById('emailForm').submit();
            }
        }
    </script>

    <?php if (isset($_SESSION['sent_email_status'])) : ?>
        <script>
            let sent_mail_status = '<?php echo $_SESSION['sent_email_status'] ?>';
            switch (sent_mail_status) {
                case "not_register":
                    Swal.fire('Tài khoản chưa được đăng ký', 'Vui lòng đăng ký tài khoản hoặc thử lại', 'error');
                    break;
                case "error":
                    Swal.fire('Đã có lỗi xảy ra', '', 'error');
                    break;
                case "token_error":
                    Swal.fire('Đường link đã hết hạn hoặc không có hiệu lực', 'Vui lòng thử lại', 'error');
                    break;
                case "success":
                    Swal.fire('Link tạo lại mật khẩu đã được gửi qua email của quý Anh/Chị', '', 'success');
                    break;
                case "change_pass_success":
                    Swal.fire('Đã đổi password thành công', '', 'success');
                    break;
                default:
                    break;
            }
        </script>
        <?php unset($_SESSION['sent_email_status']) ?>
    <?php endif; ?>

</body>

</html>