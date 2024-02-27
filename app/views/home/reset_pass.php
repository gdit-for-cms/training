<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PHP FoodCode - Change Password</title>
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="stylesheet" href="/css/style.css">
    <link href="/css/tailwind/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include jQuery from a CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
</head>

<body>

    <div class="h-screen" style="font-family: 'Source Sans Pro', sans-serif;">
        <div class="container mx-auto h-full">
            <div class="flex h-full w-full flex-wrap items-center justify-center">
                <div class="block rounded-lg shadow-lg lg:flex lg:flex-wrap" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593)">

                    <!-- Left column container-->
                    <div class="px-4 md:px-0 lg:w-6/12 flex items-center justify-center">
                        <div class="md:m-6 md:p-12 w-3/4 rounded-lg px-4 my-4" style="background: white">

                            <form action="/auth/change-pass" id="change_pass_form" class="w-full my-3" method="POST" x-data="{password: '',password_confirm: ''}" enctype="multipart/form-data">
                                <p class="mb-4 text-3xl text-center uppercase">Đổi mật khẩu</p>

                                <?php if (isset($_SESSION['email'])) : ?>
                                    <input type="text" name='email' hidden value='<?php echo $_SESSION['email'] ?>'>
                                    <?php unset($_SESSION['email']) ?>
                                <?php endif; ?>
                                <!-- Decrypted Email -->

                                <!--Password input-->
                                <div class="relative mt-4">
                                    <input onchange="checkValidatePass()" type="password" name="pass" id="pass" x-model="password" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Mật khẩu" />
                                </div>

                                <div class="relative mt-2 mx-5 hidden" id="pass_error">
                                    <p class="w-full h-fit text-xs text-red-500" id="pass_error_content">
                                    </p>
                                </div>

                                <!--Password confirm-->
                                <div class="relative mt-4">
                                    <input type="password" name="pass_confirm" id="pass_confirm" x-model="password_confirm" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Xác nhận mật khẩu" />
                                </div>

                                <!-- Input hidden default image -->
                                <input type="hidden" id="image_data" name="image_data" value="https://static.vecteezy.com/system/resources/previews/009/734/564/original/default-avatar-profile-icon-of-social-media-user-vector.jpg">

                                <div class="flex justify-start mt-3 ml-4 p-1 min-h-10">
                                    <ul>
                                        <li class="flex items-center py-1">
                                            <div :class="{'bg-green-200 text-green-700': password == password_confirm, 'bg-red-200 text-red-700':password != password_confirm, 'hidden': password.length == 0 || password_confirm.length == 0 }" class=" rounded-full p-1 fill-current ">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path x-show="password == password_confirm && password.length > 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    <path x-show="password != password_confirm || password.length == 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                            <span :class="{'text-green-700': password == password_confirm, 'text-red-700':password != password_confirm, 'hidden': password.length == 0 || password_confirm.length == 0}" class="font-medium text-sm ml-3" x-text="password == password_confirm ? 'Mật khẩu trùng khớp' : 'Mật khẩu không trùng khớp' "></span>
                                        </li>
                                    </ul>
                                </div>

                                <!--Submit button-->
                                <div class="mt-2 mb-12 pb-1 pt-1 text-center">
                                    <div onclick="submitChangePass()" class="hover:cursor-pointer mb-2 inline-block w-full rounded px-6 py-2 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="button" onclick="submitButton()" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                        Đổi mật khẩu
                                    </div>
                                </div>
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

    <script>
        function checkValidatePass() {
            var passEl = document.getElementById('pass').value;
            var passConfirm = document.getElementById('pass_confirm').value;
            var passError = document.getElementById('pass_error');
            var passErrorContent = document.getElementById('pass_error_content');

            if (passEl === '') {
                passError.classList.remove('hidden');
                passErrorContent.textContent = 'Mật khẩu không được để trống.';
                return false;
            } else if (!/^[a-zA-Z0-9\S]{6,}$/.test(passEl)) {
                passError.classList.remove('hidden');
                passErrorContent.textContent = 'Mật khẩu phải có ít nhất 6 ký tự và không chứa khoảng trắng.';
                return false;
            } else if (passEl !== passConfirm) {
                return false;
            } else {
                passError.classList.add('hidden');
                return true;
            }
        }

        function submitChangePass() {
            if (checkValidatePass()) {
                document.getElementById('change_pass_form').submit();
            } else {
                Swal.fire('Nhập mật khẩu chưa hợp lệ', '', 'warning');
            }
        }
    </script>
</body>

</html>