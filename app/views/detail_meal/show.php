<?php
$data = 'id=' . $detail_meal[0]['id'];

// Encryption key
$key = 'gdit';

// Encrypt the data
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
$encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
$encrypted = base64_encode($encrypted . '::' . $iv);

// Encrypted link
$encryptedLink = "/meal/show?data=" . urlencode($encrypted);
?>

<section class="py-4 bg-white border-b">
    <div class="flex flex-col gap-2 my-2 leading-tight text-center text-gray-800 col-span-full">
        <h1 class="text-4xl font-bold">
            <?php if (isset($detail_meal)) {
                echo htmlspecialchars($detail_meal[0]['store_name']);
            } ?>
        </h1>
        <h1 class="text-2xl italic">by <?php if (isset($detail_meal)) {
                                            echo htmlspecialchars($detail_meal[0]['display_name']);
                                        } ?></h1>
    </div>
    <div class="mb-4 col-span-full">
        <div class="w-64 h-1 py-0 mx-auto my-0 rounded-t opacity-25 gradient"></div>
    </div>
    <div class="container mx-auto mt-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="flex items-center justify-between lg:px-8 mb-2">

                    <div class="flex gap-2 justify-around">
                        <div onclick="window.history.back()" class="text-gray-800 flex items-center justify-between gap-1 hover:underline hover:cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            <div>Quay lại</div>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-around">
                        <a href="<?php echo $encryptedLink ?>" class="flex items-center justify-between gap-1 hover:underline text-red-800">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            <div>
                                Đặt món
                            </div>
                        </a>
                        <div onclick="exportExcel()" class="flex items-center justify-between gap-1 hover:underline text-blue-800 hover:cursor-pointer">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                </svg>
                            </div>
                            <div>
                                Xuất excel
                            </div>
                        </div>
                    </div>

                </div>
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên người đặt</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Món</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (empty($meals)) : ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-3xl text-gray-500 text-center" colspan="7">
                                            <a href="<?php echo $encryptedLink ?>">
                                                <button type="button">Đang ế, chưa có người đặt. <span class="underline">Click đặt mở hàng thôi...</span></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($meals as $index => $item) : ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $index + 1 ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($item['display_name']) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($item['food_name']) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= number_format($item['price'], 0, ',', '.') ?> <sup>đ</sup></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $item['amount'] ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= number_format(($item['price'] * $item['amount']), 0, ',', '.') ?> <sup>đ</sup></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars($item['describes']) ?: 'N/A' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    const formatNumber = (number) => {
        const roundedNumber = Math.floor(number);
        const formattedNumber = roundedNumber.toLocaleString("vi", {
            style: "currency",
            currency: "VND",
        });
        return formattedNumber;
    };
</script>

<script>
    function exportExcel() {
        const mealId = <?php echo json_encode($detail_meal[0]['id']); ?>;
        // Embed store name and time open from PHP into JS variables
        const storeName = <?php echo json_encode($detail_meal[0]['store_name']); ?>;
        const timeOpen = <?php echo json_encode($detail_meal[0]['time_open']); ?>;

        // Format timeOpen to a more filename-friendly format (e.g., replace spaces and colons)
        const formattedTimeOpen = timeOpen.replace(/\s+/g, '_').replace(/:/g, '-');

        // Generate the filename using storeName and formattedTimeOpen
        const fileName = `${storeName}_${formattedTimeOpen}.xlsx`.replace(/\s+/g, '_');

        fetch('/detail-meal/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    meal_id: mealId
                })
            })
            .then(response => {
                if (response.ok) {
                    return response.blob();
                }
                throw new Error('Network response was not ok.');
            })
            .then(blob => {
                // Create a new URL for the blob object
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                // Use the dynamically generated filename
                a.download = fileName;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    }
</script>