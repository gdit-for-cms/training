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

                            <form class="w-full my-4" action="/auth/loginProcess" method="POST">
                                <p class="mb-4 text-3xl text-center uppercase text-black">Đăng nhập</p>
                                <!--Username input-->
                                <div class="relative mt-4">
                                    <input type="text" name="name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Tên tài khoản" <?php
                                                                                                                                                                    if (isset($pre_name)) {
                                                                                                                                                                        echo 'value="' . $pre_name . '"';
                                                                                                                                                                    }
                                                                                                                                                                    ?> />
                                </div>

                                <div class="relative mt-2 mx-5">
                                    <p class="w-full h-fit text-sm text-red-500 ">
                                        <?php if (isset($name_error)) {
                                            echo $name_error;
                                        } ?>
                                    </p>
                                </div>

                                <!--Password input-->
                                <div class="relative mt-4">
                                    <input type="password" name="pass" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Mật khẩu" />
                                </div>

                                <div class="relative mt-2 mx-5">
                                    <p class="w-full h-fit text-sm text-red-500">
                                        <?php if (isset($pass_error)) {
                                            echo $pass_error;
                                        } ?>
                                    </p>
                                </div>

                                <!--Submit button-->
                                <div class="mt-6 mb-12 pb-1 pt-1 text-center">
                                    <button class="mb-3 inline-block w-full rounded px-6 pb-2 pt-2.5 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="submit" name="submit" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                        Đăng nhập
                                    </button>
                                </div>
                            </form>

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
</body>

</html>