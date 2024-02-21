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
                                    <input type="text" name="name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Tên tài khoản" <?php
                                                                                                                                                                    if (isset($pre_name)) {
                                                                                                                                                                        echo 'value="' . htmlspecialchars($pre_name) . '"';
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
                                <div class="mt-6 mb-2 pb-1 pt-1 text-center">
                                    <button class="inline-block w-full rounded px-6 pb-2 pt-2.5 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="submit" name="submit" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                        Đăng nhập
                                    </button>
                                </div>
                            </form>

                            <!-- Login with Facebook -->
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
                            <div class="mb-4">
                                <a href="<?php echo htmlspecialchars($loginUrl) ?> " class="flex items-center justify-center w-full px-4 py-2 space-x-3 text-sm text-center bg-blue-500 text-white transition-colors duration-200 transform border rounded  hover:bg-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                    </svg>
                                    <span class="text-sm text-white dark:text-gray-200">ĐĂNG NHẬP VỚI FACEBOOK</span></a>
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
</body>

</html>