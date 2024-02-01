<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>PHP FoodCode - Register</title>
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
                        <div class="md:mx-6 md:p-12 w-3/4 rounded-lg px-4 my-4" style="background: white">
                            <form action="/register/registerProcess" class="w-full my-3" method="POST" x-data="{password: '',password_confirm: ''}" enctype="multipart/form-data">
                                <p class="mb-4 text-3xl text-center uppercase">Đăng ký</p>

                                <!--Username input-->
                                <div class="relative mt-4">
                                    <input type="text" name="name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" id="exampleFormControlInput1" placeholder="Tên tài khoản" required <?php
                                                                                                                                                                                                            if (isset($pre_name)) {
                                                                                                                                                                                                                echo 'value="' . $pre_name . '"';
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?> />
                                </div>

                                <div class="relative mt-2 mx-5">
                                    <p class="w-full h-fit text-sm text-red-500">
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

                                <div class="relative mt-2 mx-5">
                                    <p class="w-full h-fit text-sm text-red-500">
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
                                <!-- <div class="relative mt-4">
                                    <div class="flex items-center w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5 text-gray-400">
                                        <label for="img_code">Mã QR của bạn: &nbsp;</label>
                                        <input type="file" name="img_code" id="exampleFormControlInput11" accept="image/*" />
                                    </div>
                                </div> -->

                                <!-- Input hidden default image -->
                                <input type="hidden" id="image_data" name="image_data" value="data:image/png;base64,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">

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
                                <div class="mt-6 mb-12 pb-1 pt-1 text-center">
                                    <button class="mb-2 inline-block w-full rounded px-6 py-2 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="submit" name="submit" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
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

                            <!--Back login page button-->
                            <form action="/" class="flex items-center justify-between pb-6">
                                <p class="mb-0 mr-2 text-black ">Bạn đã có tài khoản?</p>
                                <button type="submit" name="back_login" class="inline-block rounded px-6 pb-[6px] pt-2 text-sm font-medium uppercase leading-normal text-white" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                    Đăng nhập
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
</body>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

<script>
    let create_success = <?php echo json_encode($create_success); ?>;
    let pre_name = <?php echo json_encode($pre_name); ?>;

    if (create_success == 'Register success') {
        register_alert();
    }

    function register_alert() {
        let message = 'Bạn đã đăng ký thành công';
        Swal.fire({
            title: 'Đăng ký',
            text: message,
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Xác nhận',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/auth/login?pre_name=' + pre_name;
            }
        });
    }
</script>

</html>