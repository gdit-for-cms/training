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
                    <a href="#" class="flex gap-2 flex-wrap no-underline hover:no-underline">
                        <p class="w-full text-gray-600 text-xs md:text-sm px-6">
                            <?php echo htmlspecialchars($meal['time_open']); // Format the date as needed 
                            ?>
                        </p>
                        <div class="w-full font-bold text-xl text-gray-800 px-6 min-h-14">
                            <?php echo htmlspecialchars($meal['store_meal_name']); ?>
                            <span class=" text-gray-600 text-xs md:text-sm underline">
                                by <?php echo htmlspecialchars($meal['user_meal_display_name']); ?>
                            </span>
                        </div>
                        <div class="px-6">
                            <img class="object-cover" src="<?php echo htmlspecialchars($meal['store_meal_img']); ?>" alt="">
                        </div>
                    </a>
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
    // Alert update status
    const nonMealStatus = <?php if (isset($non_meal_status)) {
                                echo json_encode($non_meal_status);
                            } else {
                                echo '';
                            } ?>;
    if (nonMealStatus === 'true') {
        Swal.fire('Bạn không có đơn để quản lý', '', 'warning')
            .then(() => {
                window.history.pushState({}, '', '/home/index');
            });
    }
</script>