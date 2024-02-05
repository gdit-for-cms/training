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
                                            <a href="/">Đang ế, chưa có người đặt, ra đặt mở hàng thôi...</a>
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