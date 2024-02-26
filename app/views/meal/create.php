<section class="bg-white border-b py-4">
    <div class="col-span-full my-2 leading-tight text-center text-gray-800 flex flex-col gap-2">
        <h1 class="text-4xl font-bold">
            Tạo đơn
        </h1>
    </div>
    <div class="col-span-full mb-4">
        <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
    </div>
    <!-- Main -->
    <div class="container mx-auto bg-white shadow rounded text-gray-800 flex justify-between items-center gap-2">
        <!-- Left Column -->
        <div class="w-1/2 flex-1 flex flex-col min-h-screen">
            <!-- Title -->
            <div class="font-bold text-xl text-center mb-2">Chọn từ danh sách quán đã lưu</div>
            <div class="flex items-center border-b py-2 mb-4">
                <input id="searchInput" onkeyup="searchStores()" class="border rounded py-1 px-3 mr-2 flex-grow" type="text" placeholder="Tìm quán" />
                <button onclick="searchStores()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </div>
            <!-- List -->
            <div class="overflow-y-scroll max-h-screen">
                <?php foreach ($stores as $store) : ?>
                    <div class="store flex items-center justify-between p-2">
                        <div class="flex items-center">
                            <img class="w-12 h-12 object-cover mr-4" src="<?php echo htmlspecialchars($store['image']); ?>" alt="<?php echo htmlspecialchars($store['name']); ?>" />
                            <span class="store-name font-bold"><?php echo htmlspecialchars($store['name']); ?></span>
                        </div>
                        <div class="flex items-center">
                            <!-- Here you can add a button or link to select the store -->
                            <button class="ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="selectStore(this)" data-link="<?php echo htmlspecialchars($store['link']); ?>">
                                Chọn
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right Column -->
        <div class="relative w-1/2 min-h-screen">
            <!-- Order Details Column -->
            <div class="sticky top-28 w-full bg-white shadow rounded text-gray-800">
                <!-- Title -->
                <div class="font-bold text-xl text-center mt-2">Nhập link</div>

                <!-- Form -->
                <form action="/meal/create-meal" method="post" id="create_meal_form">
                    <div class="px-5 py-2">
                        <label for="link" class="block text-sm font-medium leading-6 text-gray-900">Link Shoppe Food</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input type="text" name="link" id="link" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nhập link Shoppe Food">
                        </div>
                    </div>

                    <!-- Toggle A -->
                    <div class="flex items-center justify-end w-full my-3 pr-5">

                        <label for="is_free" class="flex items-center cursor-pointer">
                            <!-- toggle -->
                            <div class="relative">
                                <!-- input -->
                                <input id="is_free" name="is_free" type="checkbox" class="sr-only" />
                                <!-- line -->
                                <div class="w-10 h-4 bg-gray-300 rounded-full shadow-inner"></div>
                                <!-- dot -->
                                <div class="dot absolute w-6 h-6 bg-white rounded-full border shadow -left-1 -top-1 transition"></div>
                            </div>
                            <!-- label -->
                            <div class="ml-3 flex gap-2 justify-around items-center text-pink-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Zm-3 0a.375.375 0 1 1-.53 0L9 2.845l.265.265Zm6 0a.375.375 0 1 1-.53 0L15 2.845l.265.265Z" />
                                </svg>
                                <div class=" font-medium">
                                    Đơn mời (free mọi người)
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Zm-3 0a.375.375 0 1 1-.53 0L9 2.845l.265.265Zm6 0a.375.375 0 1 1-.53 0L15 2.845l.265.265Z" />
                                </svg>
                            </div>

                        </label>

                    </div>

                    <!-- Confirm Button -->
                </form>

                <div class="px-5 py-4">
                    <button type="button" onclick="createMeal()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Tạo đơn
                    </button>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    function selectStore(buttonElement) {
        var storeLink = buttonElement.getAttribute('data-link');
        document.getElementById('link').value = storeLink;
    }

    function searchStores() {
        var input, filter, stores, storeName, i, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.trim().toUpperCase();
        stores = document.getElementsByClassName('store');

        for (i = 0; i < stores.length; i++) {
            storeName = stores[i].getElementsByClassName('store-name')[0];
            txtValue = storeName.textContent || storeName.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                stores[i].style.display = "";
            } else {
                stores[i].style.display = "none";
            }
        }
    }
</script>

<script>
    function createMeal() {
        // Get the value of link
        const link = document.getElementById('link').value.trim();
        const pattern = /^https:\/\/shopeefood\.vn\//;

        // Check link
        if (!link) {
            Swal.fire('Bạn chưa nhập link', '', 'warning');
        } else if (!pattern.test(link)) {
            Swal.fire("Link phải bắt đầu bằng 'https://shopeefood.vn/'.", "", "warning");
        } else {
            document.getElementById('create_meal_form').submit();
            $('#spinner').show();
        }
    }
</script>

<?php if (isset($_SESSION['failed_connect_selenium'])) : ?>
    <script>
        Swal.fire('Chưa kết nối Server Selenium', 'Vui lòng liên hệ admin', 'error');
    </script>
    <?php unset($_SESSION['failed_connect_selenium']); ?>
<?php endif; ?>