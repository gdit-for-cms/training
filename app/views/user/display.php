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
<?php if (!empty($user_data[0]['img'])) {
    $imageData = $user_data[0]['img'];
    // Encode the BLOB data to a Base64 string
    $base64Image = base64_encode($imageData);

    // Construct the SRC attribute for the IMG tag
    $imgSrc = 'data:image/jpeg;base64,' . $base64Image;
} ?>

<script>
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
</script>


<div class="bg-white p-8">
    <div class="container mx-auto px-4 bg-white shadow-md rounded-lg" style="height: 70vh;"> <!-- Set 2/3 of viewport height -->
        <div class="py-4 px-8 text-2xl font-semibold border-b border-gray-300 text-gray-800 bg-yellow-200 rounded-full">Thông tin người dùng</div>
        <div class="w-3/4 flex items-center justify-center bg-white mx-auto mt-5">
            <!-- User -->
            <div class="w-1/3 bg-white p-5 shadow rounded-lg flex-none">
                <h2 class="text-lg font-semibold mb-5">User settings</h2>
                <div class="mb-5 text-gray-800">
                    <div class="flex flex-col justify-center items-center">
                        <div id="drop_zone" class="d-flex justify-content-center align-items-start" ondragover="dragOverHandler(event);" ondrop="dropHandler(event);">
                            <img class="border-b border-gray-300 rounded shadow-lg w-52 h-52" src="<?php echo $imgSrc; ?>" alt="">
                        </div>
                        <div class="mt-3">
                            <div class="text-sm text-center text-red-800">Kéo thả để thay đổi hình</div>
                        </div>
                    </div>
                    <h3 class="text-center text-2xl font-bold mt-2"><?php echo htmlspecialchars($user_data[0]['name']); ?></h3>
                </div>
            </div>

            <!-- Information -->
            <div class="w-2/3 p-5 flex-grow">
                <div class="bg-white p-5 shadow rounded-lg text-gray-800">
                    <form id="update_form" class="w-full" action="/user/update" method="POST">
                        <!-- Input img -->
                        <input type="hidden" id="image_data" name="image_data" value="<?php echo $imgSrc; ?>">
                        <div class="my-4">
                            <label for="display_name" class="block text-lg font-semibold mb-1">Tên hiển thị</label>
                            <input type="text" id="display_name" name="display_name" value="<?php echo htmlspecialchars($user_data[0]['display_name']); ?>" class="w-full border rounded p-2" />
                        </div>
                        <div class="my-4">
                            <label for="bank_bin" class="block text-lg font-semibold mb-1">Thông tin ngân hàng (BIN - Bank)</label>
                            <select class="border rounded p-2" name="bank_bin" id="bank_bin">
                                <option>
                                    Vui lòng chọn thông tin...
                                </option>
                                <?php foreach ($banks as $bank) : ?>
                                    <option value="<?php echo htmlspecialchars($bank['bin']); ?>" <?php echo $bank['bin'] == $user_data[0]['bank_bin'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($bank['bin'] . ' - ' . $bank['shortName']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="my-4">
                            <label for="bank_acc" class="block text-lg font-semibold mb-1">Số tài khoản</label>
                            <input type="text" id="bank_acc" name="bank_acc" placeholder="Vui lòng nhập số tài khoản" value="<?php echo htmlspecialchars($user_data[0]['bank_acc']); ?>" class="w-full border rounded p-2" />
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

        </div>
    </div>
</div>

<script>
    function submitUpdate() {
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
</script>

<script>
    // Alert update status
    const updateStatus = <?php echo json_encode($update_status); ?>;
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