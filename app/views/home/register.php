<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Page</title>
    <link href="/css/tailwind/output.css" rel="stylesheet">

</head>

<body>


    <div class="h-screen">
        <div class="container mx-auto h-full">
            <div class="flex h-full w-full flex-wrap items-center justify-center">
                <div class="block rounded-lg shadow-lg lg:flex lg:flex-wrap" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593)">

                    <!-- Left column container-->
                    <div class="px-4 md:px-0 lg:w-6/12 flex items-center justify-center">
                        <div class="md:mx-6 md:p-12 w-3/4 rounded-lg px-4 my-4" style="background: white">
                            <a href="/">
                                <button type="submit" name="back_login" class="relative rounded p-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                    ← Đăng nhập
                                </button>
                            </a>


                            <form action="/user/registerProcess" class="w-full my-4" method="POST" x-data="{password: '',password_confirm: ''}" enctype="multipart/form-data">

                                <p class="mb-4 text-3xl text-center uppercase">Đăng ký</p>

                                <!--Username input-->
                                <div class="relative mt-4">
                                    <input type="text" name="name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" id="exampleFormControlInput1" placeholder="Tên tài khoản" required <?php
                                                                                                                                                                                                            if (isset($pre_name)) {
                                                                                                                                                                                                                echo 'value="' . $pre_name . '"';
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?> />
                                </div>

                                <div class="relative">
                                    <p class="w-full h-fit text-xs text-red-500">
                                        <?php if (isset($name_error)) {
                                            echo $name_error;
                                        } ?>
                                    </p>
                                </div>

                                <!--Your display name-->
                                <div class="relative mt-4">
                                    <input type="text" name="display_name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" id="exampleFormControlInput11" placeholder="Tên hiển thị" required <?php
                                                                                                                                                                                                                    if (isset($pre_display_name)) {
                                                                                                                                                                                                                        echo 'value="' . $pre_display_name . '"';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                    ?> />
                                </div>

                                <div class="relative">
                                    <p class="w-full h-fit text-xs text-red-500">
                                        <?php if (isset($display_name_error)) {
                                            echo $display_name_error;
                                        } ?>
                                    </p>
                                </div>

                                <!--Password input-->
                                <div class="relative mt-4">
                                    <input type="password" name="pass" x-model="password" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" id="exampleFormControlInput11" placeholder="Mật khẩu" required />
                                </div>

                                <!--Password confirm-->
                                <div class="relative mt-4">
                                    <input type="password" name="pass_confirm" x-model="password_confirm" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" id="exampleFormControlInput11" placeholder="Xác nhận mật khẩu" required />
                                </div>

                                <!--QR code-->
                                <div class="relative mt-4">
                                    <div class="flex items-center w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5 text-gray-400">
                                        <label for="img_code">Mã QR của bạn: &nbsp;</label>
                                        <input type="file" name="img_code" id="exampleFormControlInput11" accept="image/*" />
                                    </div>
                                </div>

                                <div class="flex justify-start mt-3 ml-4 p-1">
                                    <ul>
                                        <li class="flex items-center py-1">
                                            <div :class="{'bg-green-200 text-green-700': password == password_confirm && password.length > 0, 'bg-red-200 text-red-700':password != password_confirm || password.length == 0}" class=" rounded-full p-1 fill-current ">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path x-show="password == password_confirm && password.length > 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    <path x-show="password != password_confirm || password.length == 0" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

                                                </svg>
                                            </div>
                                            <span :class="{'text-green-700': password == password_confirm && password.length > 0, 'text-red-700':password != password_confirm || password.length == 0}" class="font-medium text-sm ml-3" x-text="password == password_confirm && password.length > 0 ? 'Mật khẩu trùng khớp' : 'Mật khẩu không trùng khớp' "></span>
                                        </li>
                                        <!-- <li class="flex items-center py-1">
                                            <div :class="{'bg-green-200 text-green-700': password.length > 7, 'bg-red-200 text-red-700':password.length < 7 }" class=" rounded-full p-1 fill-current ">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path x-show="password.length > 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    <path x-show="password.length < 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

                                                </svg>
                                            </div>
                                            <span :class="{'text-green-700': password.length > 7, 'text-red-700':password.length < 7 }" class="font-medium text-sm ml-3" x-text="password.length > 7 ? 'Độ dài mật khẩu hợp lệ' : 'Độ dài mật khẩu cần tối thiểu 8 ký tự' "></span>
                                        </li> -->
                                    </ul>
                                </div>

                                <!--Submit button-->
                                <div class="mt-4 mb-12 pb-1 pt-1 text-center">
                                    <button class="mb-3 inline-block w-full rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="submit" name="submit" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                        Đăng ký
                                    </button>
                                </div>

                                <div class="relative">
                                    <p class="w-full h-fit text-xs text-red-500">
                                        <?php if (isset($create_success)) {
                                            echo $create_success;
                                        } ?>
                                    </p>
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
</body>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

</html>