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
            <div class="p-6 flex flex-col flex-grow flex-shrink gap-1 bg-gray-50 rounded overflow-hidden shadow m-3">
                <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden py-2">

                    <div class="w-full text-gray-600 text-xs md:text-sm px-6 flex justify-between">
                        <span>
                            <?php echo htmlspecialchars($meal['time_open']); ?>
                        </span>
                        <!-- Two buttons -->
                        <div class="flex gap-2 justify-end items-center">
                            <?php if ($meal['has_ordered']) : ?>
                                <div class="relative flex items-center justify-center">
                                    <div class="group cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-green-700 w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                        </svg>
                                        <div class="absolute hidden group-hover:flex flex-col items-end ml-[-100%] mb-6">
                                            <div class="bg-black text-white text-xs rounded py-1 px-2">
                                                Đã đặt
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="relative flex items-center justify-center">
                                <form action="/detail-meal/show" method='POST' class="hidden" id="eye_button">
                                    <input type="hidden" name="meal_id" value="<?= htmlspecialchars($meal['id']) ?>">
                                </form>
                                <button onclick="submit_eye_button()">
                                    <div class="group cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:scale-105 w-8 h-8 text text-red-800">
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
                    <form action="/meal/show" method="post">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($meal['id']) ?>">
                        <button type="submit" class="mx-auto lg:mx-0 gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                            Đặt món
                        </button>
                    </form>
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
    function submit_eye_button() {
        document.getElementById('eye_button').submit();
    }
</script>

<script>
    // Alert update status
    const nonMealStatus = <?php if (isset($non_meal_status)) {
                                echo json_encode($non_meal_status);
                            } else {
                                echo 1;
                            } ?>;
    if (nonMealStatus === 'true') {
        Swal.fire('Bạn không có đơn để quản lý', '', 'warning')
            .then(() => {
                window.history.pushState({}, '', '/home/index');
            });
    }
</script>