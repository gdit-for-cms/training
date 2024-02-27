<section class="bg-white border-b py-4">
    <div class="col-span-full my-2 leading-tight text-center text-gray-800 flex flex-col gap-2">
        <h1 class="text-4xl font-bold">
            Quản lý đơn đặt
        </h1>
    </div>
    <div class="col-span-full mb-4">
        <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
    </div>
    <!-- Main -->
    <div class="container mx-auto bg-white shadow rounded text-gray-800 flex justify-between gap-5">
        <!-- Left Column -->
        <div class="w-1/2 flex-1 flex flex-col min-h-screen">
            <!-- List -->
            <div class="font-bold text-xl text-center mb-2">Danh sách đơn của bạn</div>

            <table class="table-auto min-w-full leading-normal">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                    <td scope="col" class="px-6 py-3"></td>
                    <td scope="col" class="px-6 py-3">Tên quán</td>
                    <td scope="col" class="px-2 py-3 text-center">Chi tiết</td>
                    <td scope="col" class="px-2 py-3 text-center">Đóng</td>
                    <td scope="col" class="px-2 py-3 text-center">Xóa</td>
                </thead>
                <?php foreach ($meals as $meal) : ?>
                    <tr class="bg-white border-b">
                        <td><img class=" w-12 h-12 object-cover mr-4" src="<?php echo $meal['image'] ?>"></td>
                        <form method="GET" action="/detail-meal/display-general-detail">
                            <input name="meal_id" id="meal_id" value="<?php echo $meal['id'] ?>" hidden>
                            <td scope="row" class="px-2 py-4 font-medium text-gray-900"><button type="submit" class="text-left"><?php echo $meal['store_name'] ?></button></td>
                        </form>
                        <td>

                            <form action="/detail-meal/show" class="m-0 flex justify-center items-end" method='GET'>
                                <input type="hidden" name="meal_id" value="<?= htmlspecialchars($meal['id']) ?>">
                                <button class="hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                        <td>
                            <?php
                            $link = "";
                            $icon = "";
                            if ($meal['closed']) {
                                $link = "/meal/open-meal";
                                $icon = "M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z";
                            } else {
                                $link = "/meal/close-meal";
                                $icon = "M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z";
                            }
                            ?>


                            <form class="flex items-center justify-center" method="POST" action="<?php echo $link ?>">
                                <input name="meal_id" id="meal_id" value="<?php echo $meal['id'] ?>" hidden>
                                <button class="hover:scale-105 text-blue-700" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo $icon ?>" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form id="<?php echo 'deleteMealForm' . $meal['id'] ?>" class="flex items-center justify-center" method="POST" action="/meal/delete-meal">
                                <input name="meal_id" id="meal_id" value="<?php echo $meal['id'] ?>" hidden>
                                <button type="button" onclick="submitDelete('<?php echo htmlspecialchars($meal['store_name']); ?>', <?php echo htmlspecialchars($meal['id']); ?>)" class="text-red-500 delete-item-btn hover:text-red-700 hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>

        <!-- Right Column -->
        <div class="relative w-1/2 min-h-screen">
            <!-- Order Details Column -->
            <div class="sticky w-full text-gray-800 bg-white rounded shadow top-28">
                <!-- Order Title -->
                <div class="text-xl font-bold text-center"><?php echo $store_name ?></div>

                <!-- Table -->
                <div>
                    <table class="min-w-full leading-normal table-fixed">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider"></th>
                                <th class="lg:w-[320px] px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Sản phẩm</th>
                                <th class="px-2 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase border-b-2">Giá</th>
                                <th class="px-2 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase border-b-2">Số lượng</th>
                                <th class="px-2 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase border-b-2">Tổng</th>
                                <th class="lg:w-[100px] px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Food -->
                            <?php
                            $total_money = 0;
                            ?>
                            <?php foreach ($detail_meals as $detail_meal) : ?>
                                <tr>
                                    <td class="px-2 py-2 text-base bg-white border-b border-gray-200"><img class="w-12 h-12 object-cover mr-4" src="<?php echo $detail_meal['image'] ?>"></td>
                                    <td class="px-2 py-2 text-base bg-white border-b border-gray-200">
                                        <div class="flex items-center">
                                            <span><?php echo $detail_meal['name'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-base bg-white border-b border-gray-200 text-end">
                                        <?php echo number_format($detail_meal['price'], 0, ',', '.') . ' đ'; ?>
                                    </td>
                                    <td class="px-2 py-2 text-base bg-white border-b border-gray-200">
                                        <div class="flex items-center justify-center">
                                            <span class="mx-2"><?php echo $detail_meal['amount'] ?></span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-base bg-white border-b border-gray-200 text-end">
                                        <?php
                                        $total_money += $detail_meal['price'] * $detail_meal['amount'];
                                        echo number_format($detail_meal['price'] * $detail_meal['amount'], 0, ',', '.') . ' đ';
                                        ?>
                                    </td>
                                    <td class="px-2 py-2 text-base bg-white border-b border-gray-200">
                                        <?php echo htmlspecialchars($detail_meal['describes']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td class="px-2 py-2 text-base bg-white border-b border-gray-200"></td>
                                <td class="px-2 py-2 bg-white border-b border-gray-200 text-lg font-bold">Tạm tính</td>
                                <td class="px-2 py-2 text-base bg-white border-b border-gray-200" colspan="2"></td>
                                <td class="px-2 py-2 text-lg font-bold bg-white border-b border-gray-200" id="total-price" colspan="2" class="text-lg font-bold"><?php echo number_format($total_money, 0, ',', '.') . ' đ'; ?></td>
                            </tr>

                        </tbody>
                    </table>
                    <h6 class="px-1 py-1 bg-white border-b border-red-200 text-sm font-bold text-center">*Nhớ đóng đơn trước khi bắt đầu đặt nha</h6>
                </div>

                <?php
                if ($status) {
                    echo    '<form id="submit_order" action="/order/create-order" method="POST" class="mt-5">
                    
                     <input name="meal_id" id="meal_id" value=" ' . $meal_id . '" hidden>
                     <input name="store_id" id="store_id" value=" ' . $store_id . ' " hidden>
                     <input name="is_free" id="is_free" value=" ' . htmlspecialchars($is_free) . ' " hidden>
                    
                    <div class="flex items-center justify-between px-5 py-4 border-t border-gray-200">
                    <span id="total-title" class="text-xl font-bold"><label for="ship_fee">Nhập phí ship + phí dịch vụ</label></span>
                    <div class="flex gap-1 justify-end items-center">
                    <span class="text-xl font-bold border"><input class="text-end" style="color: black;" type="text" name="ship_fee" id="ship_fee_display" onchange="setFinalPrice()" placeholder="0"></span>
                    <input type="hidden" name="ship_fee" id="ship_fee" value="0">
                    <span class="underline font-bold">đ</span>
                    </div>
                    </div>
                    <div class="flex items-center justify-between px-5 py-4 border-t border-gray-200">
                        <span id="total-title" class="text-xl font-bold"><label for="discount">Nhập số tiền giảm giá</label></span>
                        <div class="flex gap-1 justify-end items-center">
                        <span class="text-xl font-bold border"><input class="text-end" style="color: black;" type="text" name="discount_display" id="discount_display" placeholder="0"  onchange="setFinalPrice()"></span>
                        <input type="hidden" name="discount" id="discount" value="0">                    
                        <span class="underline font-bold">đ</span>
                        </div>
                        </div>
                    <div class="flex items-center justify-between px-5 py-4 border-t border-gray-200">
                        <span class="text-xl font-bold"><label for="discount">Tổng tiền</label></span>
                        <span class="text-xl font-bold">
                            <div style="color: black;" id="final_price"></div>
                        </span>
                    </div>
                    <!-- Confirm Button -->
                       <div class="px-5 py-4\">
                        <button type="button" onclick="confirmOrder()" class="w-full px-4 py-2 font-bold text-white bg-green-600 rounded hover:bg-green-700\">
                            Chốt đơn
                        </button>
                    </div>    
                </form>';
                }
                ?>

            </div>
        </div>
    </div>
</section>

<script>
    function submitDelete(name, id) {
        let message = 'Bạn có muốn xóa đơn ' + name;
        Swal.fire({
            title: message,
            text: 'Bạn không thể hoàn tác vụ này',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Đóng'
        }).then((result) => {
            if (result.isConfirmed) {
                formId = 'deleteMealForm' + id;
                document.getElementById(formId).submit();
            }
        });
    }
</script>


<script>
    const total = <?php echo $total_money ?>;

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
            confirmButtonText: 'Trả',
            cancelButtonText: 'Đóng'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/order/pay?ids=' + id;
            }
        });
    }

    // Convert ship fee and discount when input
    $(document).ready(function() {
        $('#ship_fee_display').on('keyup', function() {
            // Get the current value
            var inputValue = $(this).val();

            // Remove non-numeric characters for robustness
            var numericValue = inputValue.replace(/\D/g, '');

            // Convert to a number if not empty, otherwise default to 0
            var numberValue = numericValue ? parseInt(numericValue, 10) : 0;

            // Format the number with thousand separators but without the currency symbol
            var formattedNumber = numberValue.toLocaleString('vi-VN');

            // Update the hidden input with the numeric value for form submission
            $('#ship_fee').val(numberValue);

            // Replace the input value with the formatted number
            $(this).val(formattedNumber);
        });

        $('#discount_display').on('keyup', function() {
            var inputValue = $(this).val();
            var numericValue = inputValue.replace(/\D/g, '');
            var numberValue = numericValue ? parseInt(numericValue, 10) : 0;
            var formattedNumber = numberValue.toLocaleString('vi-VN');
            $('#discount').val(numberValue);
            $(this).val(formattedNumber);
        });
    });

    function setFinalPrice() {
        let discount = document.getElementById("discount").value * 1;
        let ship_fee = document.getElementById("ship_fee").value * 1;
        document.getElementById("final_price").innerText = formatNumber(total + ship_fee - discount);
    }

    function confirmOrder() {
        let message = 'Hãy chắc chắn đơn hàng đã được giao thành công trước khi chốt';
        let discount = document.getElementById("discount").value * 1;
        let ship_fee = document.getElementById("ship_fee").value * 1;
        if (total + ship_fee - discount < 0) {
            message = 'Tổng tiền của bạn đang bị âm kìa'
            Swal.fire({
                title: 'Thông báo',
                text: message,
                icon: 'warning',
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Đóng',
                timer: 5000
            })
            return;
        }
        Swal.fire({
            title: 'Chốt đơn',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Chốt đơn',
            cancelButtonText: 'Đóng'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('submit_order').submit();
            }
        });
    }

    setFinalPrice();
</script>