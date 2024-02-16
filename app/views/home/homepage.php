<section class="bg-white border-b py-4">
    <div class="container mx-auto grid space-x-6 grid-cols-1 md:grid-cols-3 pt-4 pb-12">
        <h1 class="col-span-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
            Đơn đang mở
        </h1>
        <div class="col-span-full mb-4">
            <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
        </div>
        <!-- Start of Grid Column -->
        <!-- Open Meals Content -->
        <?php foreach ($open_meals as $meal) : ?>
            <div class="p-6 flex flex-col flex-grow flex-shrink gap-1 bg-gray-50 rounded overflow-hidden shadow m-3" <?php if ($meal['is_free'] == 1) : ?>style="background-image: url('https://t4.ftcdn.net/jpg/00/98/71/77/360_F_98717785_sKPC9ddblWIrzkZSusbGFHsqf06gdqMM.jpg'); background-size: cover; background-position: center;" <?php endif; ?>>
                <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden py-2">

                    <div class="w-full text-gray-600 text-xs md:text-sm px-6 flex justify-between">
                        <span>
                            <?php echo htmlspecialchars($meal['time_open']); ?>
                        </span>
                        <!-- Two buttons -->
                        <div class="flex gap-2 justify-end items-center">
                            <?php if ($meal['is_free'] == 1) : ?>
                                <div class="relative flex items-center justify-center">
                                    <div class="group">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-pink-600 w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Zm-3 0a.375.375 0 1 1-.53 0L9 2.845l.265.265Zm6 0a.375.375 0 1 1-.53 0L15 2.845l.265.265Z" />
                                        </svg>
                                        <div class="absolute hidden group-hover:flex flex-col items-end ml-[-100%] mb-6">
                                            <div class="bg-black text-white text-xs rounded py-1 px-2">
                                                Free
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($meal['has_ordered']) : ?>
                                <div class="relative flex items-center justify-center">
                                    <div class="group">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-green-700 w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                        </svg>
                                        <div class="absolute hidden group-hover:flex flex-col items-end ml-[-100%] mb-6">
                                            <div class="bg-black text-white text-xs rounded py-1 px-2 w-16">
                                                Đã đặt
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="relative flex items-center justify-center">
                                <form action="/detail-meal/show" method='GET' class="hidden" id="<?php echo 'eye_button_' . $meal['id']; ?>">
                                    <input type="hidden" name="meal_id" value="<?= htmlspecialchars($meal['id']) ?>">
                                </form>

                                <button type="button" onclick="submit_eye_button(<?php echo $meal['id']; ?>)">
                                    <div class="group cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:scale-105 w-6 h-6 text text-red-800">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <div class="absolute hidden group-hover:flex flex-col items-end ml-[-100%] mb-6">
                                            <div class="bg-black text-white text-xs rounded py-1 px-2">
                                                Xem
                                            </div>
                                        </div>
                                    </div>
                                </button>

                            </div>
                        </div>

                    </div>
                    <div class="w-full font-bold text-xl text-gray-800 px-6 min-h-14">
                        <?php echo htmlspecialchars($meal['store_meal_name']); ?>
                        <span class=" text-gray-600 text-xs md:text-sm underline">
                            by <?php echo htmlspecialchars($meal['user_meal_display_name']); ?>
                        </span>
                    </div>
                    <div class="px-6">
                        <img class="object-cover" src="<?php echo htmlspecialchars($meal['store_meal_img']); ?>" alt="">
                    </div>

                </div>
                <div class="px-6 flex items-center justify-center">

                    <?php
                    $data = 'id=' . $meal['id'];

                    // Encryption key
                    $key = 'gdit';

                    // Encrypt the data
                    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
                    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
                    $encrypted = base64_encode($encrypted . '::' . $iv);

                    // Encrypted link
                    $encryptedLink = "/meal/show?data=" . urlencode($encrypted);
                    ?>
                    <a href="<?php echo $encryptedLink ?>">
                        <button type="submit" class="mx-auto lg:mx-0 gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                            Đặt món
                        </button>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- Create Meal Content -->
        <div class="p-6 flex flex-col flex-grow flex-shrink gap-1 bg-gray-50 rounded overflow-hidden shadow m-3">
            <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden py-2">
                <a href="#" class="flex gap-2 flex-wrap no-underline hover:no-underline">
                    <p class="w-full text-gray-600 text-xs md:text-sm px-6">
                        &nbsp;
                    </p>
                    <div class="animate-bounce text-center w-full font-bold text-xl text-gray-800 px-6 min-h-14">
                        Không tìm thấy đơn bạn cần...???
                    </div>
                    <div class="px-6">
                        <img class="object-cover" src="/img/where_it_is.png" alt="">
                    </div>
                </a>
            </div>
            <div class="px-6 flex items-center justify-center">
                <a href="/meal/create">
                    <button class="mx-auto lg:mx-0 bg-blue-400 text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Tạo đơn
                    </button>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    function submit_eye_button(id) {
        let button_id = 'eye_button_' + id;
        document.getElementById(button_id).submit();
    }
</script>

<?php
if (isset($_SESSION['status_create_meal'])) {
    if ($_SESSION['status_create_meal'] == TRUE) {
        echo '<script>
                Swal.fire("Đã tạo đơn thành công", "", "success");
            </script>';
    } else {
        echo '<script>
                Swal.fire("Đã có lỗi trong quá trình tạo đơn", "Vui lòng thử lại", "error");
            </script>';
    }
    unset($_SESSION['status_create_meal']);
}
?>