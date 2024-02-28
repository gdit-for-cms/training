<div class="bg-white p-8">
    <!-- Table -->
    <div class="container mx-auto px-4 bg-white shadow-md rounded-lg" style="height: 50vh;"> <!-- Set 2/3 of viewport height -->
        <div class="py-4 px-8 text-2xl font-semibold border-b border-gray-300 text-gray-800 bg-blue-200 rounded-full">Lịch sử đặt</div>
        <div class="overflow-x-auto overflow-y-scroll h-4/5"> <!-- Set overflow-y-scroll and height to full to take the height of parent -->
            <table class="min-w-full leading-normal">
                <thead class="sticky top-0 bg-white border-b-2 border-gray-300">
                    <tr>
                        <th class="px-5 py-3  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Ngày giờ
                        </th>
                        <th class="px-5 py-3  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Người mở đơn
                        </th>
                        <th class="px-5 py-3  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tên quán
                        </th>
                        <th class="px-5 py-3  text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tổng tiền bạn chi
                        </th>
                        <th class="px-5 py-3  text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Chi tiết đơn
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history_order_of_current_user as $history_order) : ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <?php echo $history_order['time_close'] ?>
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <?php echo htmlspecialchars($history_order['creater_name']) ?>
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <?php echo $history_order['store_name'] ?>
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <?php echo number_format($history_order['total_price']) . ' đ' ?>
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 text-sm text-gray-900 text-center">
                                <button class="hover:scale-105" onclick="openModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal backdrop -->
    <div id="modal-backdrop" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

    <!-- Modal -->
    <div id="modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="py-4 px-8 text-2xl font-semibold border-b border-gray-300 text-gray-800 bg-blue-200 rounded-full">Chi tiết đơn</div>
                    <div class="overflow-x-auto overflow-y-scroll h-3/4"> <!-- Set overflow-y-scroll and height to full to take the height of parent -->
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Ngày giờ
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Người mở đơn
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Món bạn đặt
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-300 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Chi tiết đơn
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const formatNumber = (number) => {
        const roundedNumber = Math.floor(number);
        const formattedNumber = roundedNumber.toLocaleString("vi", {
            style: "currency",
            currency: "VND",
        });
        return formattedNumber;
    };

    function openModal() {
        Swal.fire("Chức năng đang phát triển", "", "warning");
    }
    // // Function to open the modal with the clicked image
    // function openModal() {
    // document.getElementById('modal').classList.remove('hidden'); // Show the modal
    // document.getElementById('modal-backdrop').classList.remove('hidden'); // Show the modal backdrop
    // }

    // // Function to close the modal
    // function closeModal() {
    // document.getElementById('modal').classList.add('hidden'); // Hide the modal
    // document.getElementById('modal-backdrop').classList.add('hidden'); // Hide the modal backdrop
    // }
</script>