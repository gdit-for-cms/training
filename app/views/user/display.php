<!-- Cloudinary Upload Widget -->
<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript">
</script>

<?php
// Function to call the API and return data
function getBankData() {
    // API endpoint
    $url = 'https://api.vietqr.io/v2/banks';

    // Initialize a CURL session
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $url);
    // Return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string
    $output = curl_exec($ch);
    // Close CURL session
    curl_close($ch);

    // Convert JSON string to Array
    $result = json_decode($output, true);

    return $result['data'];
}

// Fetch the data
$banks = getBankData();
?>

<!-- Render user image -->
<?php
$imgSrc = '';
if (!empty($user_data[0]['img']) && $user_data[0]['img'] != null) {
    $imgSrc = $user_data[0]['img'];;
} else {
    $imgSrc = null;
} ?>

<!-- <script>
    function dragOverHandler(ev) {
        ev.preventDefault();
    }

    function dropHandler(ev) {
        ev.preventDefault();
        let dropZone = document.getElementById("drop_zone");
        dropZone.innerHTML = "";

        if (ev.dataTransfer.items) {
            for (let i = 0; i < ev.dataTransfer.items.length; i++) {
                if (ev.dataTransfer.items[i].kind === "file") {
                    let file = ev.dataTransfer.items[i].getAsFile();

                    console.log(file);

                    if (file.size > 100000) {
                        Swal.fire('Ảnh phải nhỏ hơn 140kB', 'Vui lòng thử lại', 'error').then(() => {
                            window.location.reload();
                        });
                        break;
                    }

                    let img = document.createElement("img");
                    img.classList.add("object-cover", "border-b", "rounded", "shadow-lg", "w-52", "h-52");
                    img.file = file;

                    dropZone.appendChild(img);

                    let reader = new FileReader();
                    reader.onload = (function(aImg) {
                        return function(e) {
                            aImg.src = e.target.result;
                            document.getElementById("image_data").value = e.target.result;
                        };
                    })(img);

                    reader.readAsDataURL(file);
                }
            }
        }
    }
</script> -->


<div class="bg-white p-8">
    <div class="container mx-auto px-4 bg-white shadow-md rounded-lg" style="height: 70vh;"> <!-- Set 2/3 of viewport height -->
        <div class="py-4 px-8 text-2xl font-semibold border-b border-gray-300 text-gray-800 bg-yellow-200 rounded-full">Thông tin người dùng</div>
        <div class="w-full flex items-center justify-center bg-white mx-auto mt-5">
            <!-- User -->
            <div class="w-1/3 bg-white p-5 shadow rounded-lg flex-none">
                <h2 class="text-lg font-semibold mb-5">User settings</h2>
                <div class="mb-5 text-gray-800">
                    <div class="flex flex-col justify-center items-center">
                        <div id="drop_zone" class="d-flex justify-content-center align-items-start" ondragover="dragOverHandler(event);" ondrop="dropHandler(event);">
                            <img class="border-b border-gray-300 rounded shadow-lg w-52 h-52" src="<?php if (isset($imgSrc)) {
                                                                                                        echo $imgSrc;
                                                                                                    } else {
                                                                                                        echo 'https://static.vecteezy.com/system/resources/previews/009/734/564/original/default-avatar-profile-icon-of-social-media-user-vector.jpg';
                                                                                                    }  ?>" alt="">
                        </div>
                        <div class="mt-2">
                            <button id="upload_widget" class="bg-blue-300 hover:bg-blue-500 text-white py-1 px-4 rounded transition ease-in-out duration-150 flex gap-2 justify-between items-center font-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Đổi ảnh
                            </button>
                        </div>
                    </div>
                    <h3 class="text-center text-lg font-bold mt-2 flex flex-col">
                        <span class="text-base underline">Username</span>
                        <span><?php echo $user_data[0]['name']; ?></span>
                    </h3>
                </div>
            </div>

            <!-- Information -->
            <div class="w-2/3 p-5 flex-grow">
                <div class="bg-white p-5 text-gray-800">
                    <form id="update_form" class="w-full" action="/user/update" method="POST">
                        <!-- Input img -->
                        <input type="hidden" id="image_data" name="image_data" value="<?php if (isset($imgSrc)) {
                                                                                            echo $imgSrc;
                                                                                        } else {
                                                                                            echo null;
                                                                                        }  ?>">
                        <input type="hidden" id="image_code" name="image_code" value="<?php if (isset($user_data[0]['img_code']) && $user_data[0]['img_code'] != null) {
                                                                                            echo $user_data[0]['img_code'];
                                                                                        } else {
                                                                                            echo 'no_code';
                                                                                        }  ?>">
                        <div class="my-4">
                            <label for="display_name" class="block text-lg font-semibold mb-1">Tên hiển thị</label>
                            <input onchange="checkValidate()" type="text" id="display_name" name="display_name" value="<?php echo $user_data[0]['display_name']; ?>" class="w-full border rounded p-2" />
                            <div id="display_name_error" class="text-red-800 hidden">
                                <div class="flex gap-1 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    <span id="display_name_error_content">
                                        Error message here
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <label for="bank_bin" class="block text-lg font-semibold mb-1">Thông tin ngân hàng (BIN - Bank)</label>
                            <select class="border rounded p-2" name="bank_bin" id="bank_bin">
                                <option>
                                    Vui lòng chọn thông tin...
                                </option>
                                <?php foreach ($banks as $bank) : ?>
                                    <option value="<?php echo $bank['bin']; ?>" <?php echo $bank['bin'] == $user_data[0]['bank_bin'] ? 'selected' : ''; ?>>
                                        <?php echo $bank['bin'] . ' - ' . $bank['shortName']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="my-4">
                            <label for="bank_acc" class="block text-lg font-semibold mb-1">Số tài khoản</label>
                            <input type="text" id="bank_acc" name="bank_acc" placeholder="Vui lòng nhập số tài khoản" value="<?php echo $user_data[0]['bank_acc']; ?>" class="w-full border rounded p-2" />
                        </div>
                        <div class="flex gap-2">
                            <button onclick="submitUpdate()" type="button" class="bg-green-600 text-white rounded px-4 py-2 mt-4 w-28">Cập nhật</button>
                            <a href="/">
                                <button type="button" class="bg-blue-500 text-white rounded px-4 py-2 mt-4 w-28">Thoát</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- QR Code -->
            <div class="w-1/3 bg-white p-5 shadow rounded-lg flex-none">
                <h2 class="text-lg font-semibold mb-5">User settings</h2>
                <div class="mb-5 text-gray-800">
                    <div class="flex flex-col justify-center items-center">
                        <div id="drop_zone" class="d-flex justify-content-center align-items-start" ondragover="dragOverHandler(event);" ondrop="dropHandler(event);">
                            <img class="border-b border-gray-300 rounded shadow-lg w-64 h-64" src="<?php if (isset($user_data[0]['img_code']) && $user_data[0]['img_code'] != null) {
                                                                                                        echo $user_data[0]['img_code'];
                                                                                                    } else {
                                                                                                        echo '/img/no_QR_user.png';
                                                                                                    }  ?>" alt="">
                        </div>
                    </div>
                    <h3 class="text-center text-base italic font-bold mt-2 flex flex-col">
                        <span><?php if (isset($user_data[0]['img_code']) && $user_data[0]['img_code'] != null) {
                                    echo 'QR Code';
                                } else {
                                    echo 'Cập nhật thông tin Ngân hàng để hiển thị QR Code';
                                }  ?></span>
                    </h3>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var myWidget = cloudinary.createUploadWidget({
        cloudName: '<?php echo $_ENV['CLOUDINARY_CLOUD_NAME']; ?>',
        uploadPreset: '<?php echo $_ENV['CLOUDINARY_UPLOAD_PRESET']; ?>',
        cropping: true
    }, (error, result) => {
        if (!error && result && result.event === "success") {
            console.log('Done! Here is the image info: ', result.info);
            // Update the src attribute of the img tag
            document.querySelector("#drop_zone img").src = result.info.secure_url;
            // Set the value of the hidden input field
            document.getElementById("image_data").value = result.info.secure_url;
        }
    });

    document.getElementById("upload_widget").addEventListener("click", function() {
        myWidget.open();
    }, false);
</script>

<script>
    function checkValidate() {
        var displayName = document.getElementById('display_name').value;
        var errorDiv = document.getElementById('display_name_error');
        var errorMessageDiv = document.getElementById('display_name_error_content');

        if (displayName.trim() === '') {
            errorDiv.classList.remove('hidden');
            errorMessageDiv.textContent = 'Tên hiển thị không được để trống.';
            return false;
        } else if (!/^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/.test(displayName.trim())) {
            errorDiv.classList.remove('hidden');
            errorMessageDiv.textContent = 'Tên hiển thị chỉ được chứa chữ cái và khoảng trắng.';
            return false;
        } else if (displayName.trim().length < 3 || displayName.trim().length > 50) {
            errorDiv.classList.remove('hidden');
            errorMessageDiv.textContent = 'Tên hiển thị phải có độ dài từ 3 đến 50 ký tự.';
            return false;
        } else {
            errorDiv.classList.add('hidden');
            return true;
        }
    }

    function submitUpdate() {
        let bankBin = document.getElementById('bank_bin').value;
        let bankAcc = document.getElementById('bank_acc').value;
        let imgQRLink = "";
        if (bankBin === "Vui lòng chọn thông tin..." || bankAcc === "") {
            imgQRLink = "no_code";
        } else {
            imgQRLink = "https://img.vietqr.io/image/" + bankBin + "-" + bankAcc + "-qr_only.png";
        }
        document.getElementById('image_code').value = imgQRLink;
        if (checkValidate()) {
            Swal.fire({
                title: 'Xác nhận cập nhật',
                text: 'Các thông tin là chính xác và tiến hành cập nhật?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Không'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('update_form').submit();
                }
            });
        }
    }
</script>

<script>
    // Alert update status
    const updateStatus = <?php if (isset($update_status)) {
                                echo json_encode($update_status);
                            } else {
                                echo '';
                            } ?>;
    if (updateStatus === 'true') {
        Swal.fire('Cập nhật thành công', '', 'success')
            .then(() => {
                window.history.pushState({}, '', '/user/show');
            });
    } else if (updateStatus === 'false') {
        Swal.fire('Cập nhật thất bại', 'Vui lòng thử lại', 'error')
            .then(() => {
                window.history.pushState({}, '', '/user/show');
            });
    }
</script>

<?php if (isset($_SESSION['existed_name'])) {
    $existed_name = htmlspecialchars($_SESSION['existed_name'], ENT_QUOTES, 'UTF-8');
    if ($existed_name != '?') {
        echo "<script>
        Swal.fire('Tên hiển thị \"{$existedName}\" đã được sử dụng', 'Vui lòng thử tên khác', 'error');
      </script>";
    } else {
        echo "<script>
        Swal.fire('Đã có lỗi xảy ra trong quá trình thực hiện', 'Vui lòng thử lại sau', 'error');
      </script>";
    }
    unset($_SESSION['existed_name']);
} ?>


<!-- Check account name via bank and account number -->
<!-- <script>
    document.getElementById('checkButton').addEventListener('click', function() {
        var bankBin = document.getElementById('bank_bin').value;
        var accountNumber = document.getElementById('bank_acc').value;

        // Here we use the Fetch API to POST data to your server-side script
        fetch('/user/lookup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'bin=' + encodeURIComponent(bankBin) + '&accountNumber=' + encodeURIComponent(accountNumber)
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    // Parse the JSON string in the response
                    var innerData = JSON.parse(response.data);

                    // Now innerData is a JavaScript object, and you can access its properties
                    if (innerData.code === "00" && innerData.data) {
                        var accountName = innerData.data.accountName;
                        document.getElementById('accountInfo').textContent = 'Account Name: ' + accountName;
                    } else {
                        document.getElementById('accountInfo').textContent = 'Error: ' + innerData.desc;
                    }
                } else {
                    // Handle the case where the API does not return success
                    document.getElementById('accountInfo').textContent = 'Error: ' + response.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('accountInfo').textContent = 'An error occurred while fetching the account name.';
            });
    });
</script> -->