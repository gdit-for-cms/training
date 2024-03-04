<div class="bg-white p-8">
    <!-- Table 1 -->
    <div class="container mx-auto px-4 bg-white shadow-md rounded-lg mb-10" style="height: 50vh;"> <!-- Set 2/3 of viewport height -->
        <div class="py-4 px-8 text-2xl font-semibold border-b border-gray-300 text-gray-800 bg-yellow-200 rounded-full">Công nợ</div>
        <div class="overflow-x-auto overflow-y-scroll h-3/4"> <!-- Set overflow-y-scroll and height to full to take the height of parent -->
            <table class="min-w-full leading-normal">
                <thead class="text-center sticky top-0 bg-white">
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tình trạng
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Phải trả
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Phải thu
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            User
                        </th>
                        <th class="w-30 px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            QR Code
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- -list for debtor unpaid -->
                    <?php foreach ($list_for_debtor_unpaid as $debtor_unpaid) : ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                        <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Bạn chưa trả</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="text-gray-900 whitespace-no-wrap flex items-center justify-center">
                                    <span>
                                        <?php echo number_format($debtor_unpaid["total"]) . " đ" ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $debtor_unpaid["creditor_name"] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex justify-center items-center">
                                <?php
                                $bank_bin = $debtor_unpaid["bank_bin"];
                                $bank_acc = $debtor_unpaid["bank_acc"];
                                ?>
                                <div class="w-10 h-auto cursor-pointer">
                                    <img src="https://img.vietqr.io/image/<?php echo $bank_bin ?>-<?php echo $bank_acc ?>-compact2.png?amount=<?php echo $debtor_unpaid["total"] ?>&addInfo=CT" alt="QR Code" onclick="openModal(this.src)" onerror="this.onerror=null; this.src='<?php echo '/img/no_QR_code.png'; ?>';">
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm ">
                                <div class="flex items-center justify-center">
                                    <button onclick="confirmPay('<?php echo $debtor_unpaid['ids']; ?>')" class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition duration-150 ease-in-out transform hover:scale-105 shadow-lg">
                                        Trả tiền
                                    </button>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    <!-- -list for debtor paid -->
                    <?php foreach ($list_for_debtor_paid as $debtor_paid) : ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                        <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Bạn đã trả, chờ xác nhận</span>
                                    </span>
                                </div>
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo number_format($debtor_paid["total"]) . " đ" ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $debtor_paid["creditor_name"] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- -list for creditor unpaid -->
                    <?php foreach ($list_for_creditor_unpaid as $creditor_unpaid) : ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Con nợ chưa trả</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">

                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo number_format($creditor_unpaid["total"]) . " đ" ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $creditor_unpaid["debtor_name"] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- -list for creditor paid -->
                    <?php foreach ($list_for_creditor_paid as $creditor_paid) : ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Đã trả, bạn hãy xác nhận lại</span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">

                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo number_format($creditor_paid["total"]) . " đ" ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $creditor_paid["debtor_name"] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <button onclick="confirmConfirm('<?php echo $creditor_paid['ids'] ?>')" class="text-white bg-green-500 hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-full border-b transition ease-in-out duration-150 px-5 py-2.5 transform hover:scale-105 shadow-lg">
                                        Xác nhận
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>


    <!-- Table 2 -->
    <div class="container mx-auto px-4 bg-white shadow-md rounded-lg" style="height: 50vh;"> <!-- Set 2/3 of viewport height -->
        <div class="py-4 px-8 text-2xl font-semibold border-b border-gray-300 text-gray-800 bg-blue-200 rounded-full">Chi tiết</div>
        <div class="overflow-x-auto overflow-y-scroll h-3/4"> <!-- Set overflow-y-scroll and height to full to take the height of parent -->
            <table class="min-w-full leading-normal">
                <thead class="text-center sticky top-0 bg-white z-10 ">
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tình trạng
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Chủ nợ
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Con nợ
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tên món
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Số lượng
                        </th>
                        <th class="w-30 px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Giá
                        </th>
                        <th class="w-30 px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tổng
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Thời gian
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- -list detail -->
                    <?php foreach ($list_detail as $detail) : ?>
                        <tr>
                            <?php
                            $status = '';
                            if ($detail['payed']) {
                                $status = 'Đã trả';
                            } else {
                                $status = 'Chưa trả';
                            }
                            ?>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                        <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                        <span class="relative"><?php echo $status ?></span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $detail['creditor_name'] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $detail['debtor_name'] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $detail['name'] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap text-center">
                                        <?php echo $detail['amount'] ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap text-right">
                                        <?php echo number_format($detail['price']) . " đ" ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap text-right">
                                        <?php echo number_format($detail['price'] * $detail['amount']) . " đ" ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center justify-center">
                                    <span class="text-gray-900 whitespace-no-wrap">
                                        <?php echo $detail['time_close'] ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal backdrop -->
<div id="modal-backdrop" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

<!-- Modal -->
<div id="modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <!-- The image to be shown in the modal -->
                        <img id="modal-image" src="" class="w-full" alt="Large view" />
                    </div>
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

<script>
    const formatNumber = (number) => {
        const roundedNumber = Math.floor(number);
        const formattedNumber = roundedNumber.toLocaleString("vi", {
            style: "currency",
            currency: "VND",
        });
        return formattedNumber;
    };

    function confirmPay(id) {
        let message = 'Hãy chắc chắn bạn đã trả';
        Swal.fire({
            title: 'Trả tiền',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Trả tiền',
            cancelButtonText: 'Đóng'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/order/pay?ids=' + id;
            }
        });
    }

    function confirmConfirm(id) {
        let message = 'Hãy chắc chắn con nợ đã trả, thao tác này không thể hoàn tác';
        Swal.fire({
            title: 'Xác nhận',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận',
            cancelButtonText: 'Đóng'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/order/confirm?ids=' + id;
            }
        });
    }

    // Function to open the modal with the clicked image
    function openModal(imgSrc) {
        document.getElementById('modal-image').src = imgSrc; // Set the src for the modal image
        document.getElementById('modal').classList.remove('hidden'); // Show the modal
        document.getElementById('modal-backdrop').classList.remove('hidden'); // Show the modal backdrop
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('modal').classList.add('hidden'); // Hide the modal
        document.getElementById('modal-backdrop').classList.add('hidden'); // Hide the modal backdrop
    }
</script>