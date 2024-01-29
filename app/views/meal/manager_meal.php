<table border="1">
    <tr>
        <td></td>
        <td>Tên quán</td>
        <td>Thời gian tạo</td>
        <td>Trạng trái</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($meals as $meal) : ?>
        <tr>
            <td><img class="w-12 h-12 object-cover mr-4" src="<?php echo $meal['image'] ?>"></td>
            <td><?php echo $meal['store_name'] ?></td>
            <td><?php echo $meal['time_open'] ?></td>
            <td>
                <?php
                if (!$meal['closed']) {
                    echo "Mở";
                } else {
                    echo "Đóng";
                }
                ?>
            </td>
            <td>
                <form method="POST" action="/detail-meal/display-general-detail">
                    <input name="meal_id" id="meal_id" value="<?php echo $meal['id'] ?>" hidden>
                    <button type="submit">Xem</button>
                </form>
            </td>
            <td>
                <form method="POST" action="/meal/close-meal">
                    <input name="meal_id" id="meal_id" value="<?php echo $meal['id'] ?>" hidden>
                    <button type="submit">Đóng</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<table border="1">
    <tr>
        <td></td>
        <td>Tên móm</td>
        <td>Số lượng</td>
        <td>Giá</td>
        <td>Tổng</td>
    </tr>

    <?php
    $total_money = 0;
    ?>
    <?php foreach ($detail_meals as $detail_meal) : ?>
        <tr>
            <td><img class="w-12 h-12 object-cover mr-4" src="<?php echo $detail_meal['image'] ?>"></td>
            <td><?php echo $detail_meal['name'] ?></td>
            <td><?php echo $detail_meal['amount'] ?></td>
            <td><?php echo $detail_meal['price'] ?></td>
            <td><?php
                $total_money += $detail_meal['price'] * $detail_meal['amount'];
                echo $detail_meal['price'] * $detail_meal['amount'];
                ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="4">Tổng tiền: </td>
        <td><span id="total"><?php echo $total_money ?></span><span> đồng</span></td>
    </tr>
</table>
<form>
    <label for="ship_fee">Nhập phí ship + phí dịch vụ</label>
    <input onchange="setFinalPrice()" style="color: black;" type="number" name="ship_fee" id="ship_fee">
    <label for="discount">Nhập số tiền giảm giá</label>
    <input onchange="setFinalPrice()" style="color: black;" type="number" name="discount" id="discount">
</form>

<input style="color: black;" id="final_price" type="number">

<script>
    function setFinalPrice() {
        let total = document.getElementById("total").textContent * 1;
        let discount = document.getElementById("discount").value * 1;
        let ship_fee = document.getElementById("ship_fee").value * 1;
        console.log(discount);
        document.getElementById("final_price").value = total + ship_fee - discount;
    }

    setFinalPrice();
</script>