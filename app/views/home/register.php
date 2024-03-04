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
                            <form action="/register/registerProcess" id="register_form" class="w-full my-3" method="POST" x-data="{password: '',password_confirm: ''}" enctype="multipart/form-data">
                                <p class="mb-4 text-3xl text-center uppercase">Đăng ký</p>

                                <!--Username input-->
                                <div class="relative mt-4">
                                    <input id='name' onchange="checkValidateName()" type="text" name="name" id="name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Tên tài khoản" />
                                </div>

                                <div class="relative mt-2 mx-5 hidden" id="name_error">
                                    <p class="w-full h-fit text-xs text-red-500" id="name_error_content">
                                    </p>
                                </div>

                                <!--Your display name-->
                                <div class="relative mt-4">
                                    <input id='display_name' onchange="checkValidateDisplayName()" type="text" name="display_name" id="display_name" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Tên hiển thị" />
                                </div>

                                <div class="relative mt-2 mx-5 hidden" id="display_name_error">
                                    <p class="w-full h-fit text-xs text-red-500" id="display_name_error_content">
                                    </p>
                                </div>

                                <!--Your gmail-->
                                <div class="relative mt-4">
                                    <input type='text' onchange="checkValidateEmail()" id='email' name="email" id="email" class="w-full rounded-lg shadow-lg leading-normal px-6 pb-2 pt-2.5" placeholder="Email" />
                                </div>

                                <div class="relative mt-2 mx-5 hidden" id="email_error">
                                    <p class="w-full h-fit text-xs text-red-500" id="email_error_content">
                                    </p>
                                </div>

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
                                    <button class="mb-2 inline-block w-full rounded px-6 py-2 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="button" onclick="submitButton()" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
                                        Đăng ký
                                    </button>
                                </div>

                            </form>

                            <!--Back login page button-->
                            <form action="/" class="flex items-center justify-between pb-6">
                                <p class="mb-0 mr-2 text-black ">Bạn đã có tài khoản?</p>
                                <button type="submit" class="inline-block rounded px-6 pb-[6px] pt-2 text-sm font-medium uppercase leading-normal text-white" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);">
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

    <form action="/register/resend-email" id="resend_email_form" method="POST">
        <input type="text" name="email" id="email_resend" hidden>
    </form>
</body>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

<script>
    function checkValidateName() {
        var nameEl = document.getElementById('name').value;
        var nameError = document.getElementById('name_error');
        var nameErrorContent = document.getElementById('name_error_content');

        if (nameEl.trim() === '') {
            nameError.classList.remove('hidden');
            nameErrorContent.textContent = 'Tên đăng nhập không được để trống.';
            return false;
        } else if (!/^[\w]+$/i.test(nameEl)) {
            nameError.classList.remove('hidden');
            nameErrorContent.textContent = 'Tên đăng nhập chỉ chứa chữ cái, số và gách dưới.';
            return false;
        } else if (nameEl.trim().length < 3 || nameEl.trim().length > 50) {
            nameError.classList.remove('hidden');
            nameErrorContent.textContent = 'Tên đăng nhập có độ dài từ 3 đến 50 ký tự.';
            return false;
        } else {
            nameError.classList.add('hidden');
            return true;
        }
    }

    function checkValidateDisplayName() {
        var displayNameEl = document.getElementById('display_name').value;
        var displayNameError = document.getElementById('display_name_error');
        var displayNameErrorContent = document.getElementById('display_name_error_content');

        if (displayNameEl.trim() === '') {
            displayNameError.classList.remove('hidden');
            displayNameErrorContent.textContent = 'Tên hiển thị không được để trống.';
            return false;
        } else if (!/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/.test(displayNameEl.trim())) {
            displayNameError.classList.remove('hidden');
            displayNameErrorContent.textContent = 'Tên hiển thị chỉ được chứa chữ cái và khoảng trắng.';
            return false;
        } else if (displayNameEl.trim().length < 3 || displayNameEl.trim().length > 50) {
            displayNameError.classList.remove('hidden');
            displayNameErrorContent.textContent = 'Tên hiển thị phải có độ dài từ 3 đến 50 ký tự.';
            return false;
        } else {
            document.getElementById('display_name').value = displayNameEl.trim();
            displayNameError.classList.add('hidden');
            return true;
        }
    }

    function checkValidatePass() {
        var passEl = document.getElementById('pass').value;
        var passError = document.getElementById('pass_error');
        var passErrorContent = document.getElementById('pass_error_content');

        if (passEl === '') {
            passError.classList.remove('hidden');
            passErrorContent.textContent = 'Mật khẩu không được để trống.';
            return false;
        } else if (!/^[\w!@#$%^&*()+=<>?.]{6,}$/.test(passEl)) {
            passError.classList.remove('hidden');
            passErrorContent.textContent = 'Mật khẩu chứa ít nhất 6 ký tự và không chứa khoảng trắng.';
            return false;
        } else {
            passError.classList.add('hidden');
            return true;
        }
    }

    function checkValidateEmail() {

        var emailEl = document.getElementById('email').value;
        var emailError = document.getElementById('email_error');
        var emailErrorContent = document.getElementById('email_error_content');


        if (emailEl.trim() === '') {
            emailError.classList.remove('hidden');
            emailErrorContent.textContent = 'Email không được để trống.';
            return false;
        } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/gi.test(emailEl)) {
            emailError.classList.remove('hidden');
            emailErrorContent.textContent = 'Email phải có dạng [your-email]@[domain]';
            return false;
        } else {
            emailError.classList.add('hidden');
            return true;
        }
    }

    // submit function when don't caching any error on FE
    function submitButton() {

        let name = document.getElementById('name').value;
        let display_name = document.getElementById('display_name').value;
        let pass = document.getElementById('pass').value;
        let pass_confirm = document.getElementById('pass_confirm').value;
        let email = document.getElementById('email').value;
        let flag = true;


        if (name.trim() == "" || display_name.trim() == "" || pass == "" || pass_confirm == "" || email == "") {
            Swal.fire('Vui lòng nhập đầy đủ thông tin', '', 'warning');
            flag = false;
        } else {
            if (!checkValidateName()) {
                Swal.fire('Tên đăng nhập chưa hợp lệ', '', 'warning');
                flag = false;
            } else if (!checkValidateDisplayName()) {
                Swal.fire('Tên hiển thị chưa hợp lệ', '', 'warning');
                flag = false;
            } else if (!checkValidatePass()) {
                Swal.fire('Mật khẩu chưa hợp lệ', '', 'warning');
                flag = false;
            } else if (!checkValidateEmail()) {
                Swal.fire('Email chưa hợp lệ', '', 'warning');
                flag = false;
            } else if (pass != pass_confirm) {
                Swal.fire('Mật khẩu không trùng khớp', '', 'warning');
                flag = false;
            }
        }
        if (flag) {

            document.getElementById("register_form").submit();
        }
    }

    // Instructor register state and register error variable
    let register_state = <?php if (isset($_SESSION['register_state'])) {
                                echo json_encode($_SESSION['register_state']);
                                unset($_SESSION['register_state']);
                            } else echo '""';

                            ?>;

    let register_error = <?php if (isset($_SESSION['register_error'])) {
                                echo json_encode($_SESSION['register_error']);
                                unset($_SESSION['register_error']);
                            } else echo '""';
                            ?>;

    // Handle when submit success or failed
    if (register_state == "success") {
        Swal.fire({
            title: 'Đăng ký thành công',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Chuyển tới trang Đăng nhập',
        }).then(() => {
            window.location.href = '/auth/login';
        });
    } else if (register_state == "send_mail_success") {
        Swal.fire({
            title: 'Đã gửi link xác thực tài khoản đến email của bạn',
            text: 'Vui lòng kiểm tra email và xác nhận ở bên dưới',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Đã nhận email',
            showDenyButton: true,
            denyButtonText: 'Gửi lại email',
            denyButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/auth/login';
            } else if (result.isDenied) {
                document.getElementById("resend_email_form").submit();
            }
        })
    } else if (register_state == "send_mail_expire") {
        Swal.fire('Link hoặc thông tin đăng ký hết hiệu lực', 'Vui lòng đăng ký lại', 'error');
    } else {
        switch (register_error) {
            case "none_register_value":
                Swal.fire('Vui lòng nhập đầy đủ thông tin', '', 'warning');
                break;
            case "both_name_existed":
                Swal.fire('Tên đăng nhập và Tên hiển thị đã được sử dụng', '', 'warning');
                break;
            case "name_existed":
                Swal.fire('Tên đăng nhập đã được sử dụng', '', 'warning');
                break;
            case "display_name_existed":
                Swal.fire('Tên hiển thị đã được sử dụng', '', 'warning');
                break;
            case "email_existed":
                Swal.fire('Email đã được sử dụng', '', 'warning');
                break;
            case "send mail error":
                Swal.fire('Đã có lỗi trong quá trình gửi email', '', 'error');
                break;
            default:
                console.log("ebc");
        }
    }

    <?php if (isset($_SESSION['data_input'])) : ?>
        document.getElementById('name').value = '<?php echo htmlspecialchars($_SESSION['data_input']['pre_name']); ?>';
        document.getElementById('display_name').value = '<?php echo htmlspecialchars($_SESSION['data_input']['pre_display_name']); ?>';
        document.getElementById('email').value = '<?php echo htmlspecialchars($_SESSION['data_input']['email']); ?>';
        document.getElementById('email_resend').value = '<?php echo htmlspecialchars($_SESSION['data_input']['email']); ?>';
        <?php unset($_SESSION['data_input']) ?>
    <?php endif; ?>
</script>

</html>