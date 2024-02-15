  <!-- List product -->
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
      <!-- Main -->
      <div class="container flex items-center justify-between gap-2 mx-auto text-gray-800 bg-white rounded shadow">
          <!-- Left Column -->
          <div class="flex flex-col flex-1 w-1/2 min-h-screen">
              <div class="flex items-center pb-2 mb-4 border-b">
                  <input id="searchInput" onkeyup="searchFoods()" class="flex-grow px-3 py-1 mr-2 border rounded" type="text" placeholder="Tìm món" />
                  <button class="px-4 py-1 font-bold text-white bg-red-400 rounded hover:bg-red-600">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                      </svg>
                  </button>
              </div>
              <!-- List Foods -->
              <div class="max-h-screen overflow-y-scroll">
                  <!-- Food -->
                  <?php foreach ($foods as $food) : ?>
                      <!-- Product -->
                      <div class="flex items-center justify-between p-2 food">
                          <div class="flex items-center gap-2">
                              <img class="object-cover w-12 h-12 mr-4" src="<?php echo htmlspecialchars($food['image']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>" />
                              <span class="font-bold food-name"><?php echo htmlspecialchars($food['name']); ?></span>
                          </div>
                          <div class="flex items-center gap-2">
                              <span class="font-bold text-red-500"><?php echo htmlspecialchars(number_format($food['price'], 0, ',', '.')); ?></span>
                              <button class="px-2 py-1 font-bold text-white bg-red-400 rounded add-item-btn hover:bg-red-600" data-food-id="<?php echo htmlspecialchars($food['id']); ?>" data-food-price="<?php echo htmlspecialchars($food['price']); ?>" data-food-name="<?php echo htmlspecialchars($food['name']); ?>">
                                  +
                              </button>
                          </div>
                      </div>
                  <?php endforeach; ?>
              </div>

          </div>
          <!-- Right Column -->
          <div class="relative w-1/2 min-h-screen">
              <!-- Order Details Column -->
              <div class="sticky w-full text-gray-800 bg-white rounded shadow top-28">
                  <!-- Order Title -->
                  <div class="text-xl font-bold text-center">Danh sách món của bạn</div>

                  <!-- Table -->
                  <div>
                      <table class="min-w-full leading-normal table-fixed order-details">
                          <thead>
                              <tr>
                                  <th class="lg:w-[400px] px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Sản phẩm</th>
                                  <th class="px-2 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase border-b-2">Giá</th>
                                  <th class="px-2 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase border-b-2">Số lượng</th>
                                  <th class="px-2 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase border-b-2">Tổng</th>
                                  <th class="px-2 py-3 text-xs font-semibold tracking-wider text-center text-gray-600 uppercase border-b-2">Xóa</th>
                                  <th class="lg:w-[100px] px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ghi chú</th>
                              </tr>
                          </thead>
                          <tbody>
                              <!-- Food -->
                          </tbody>
                      </table>
                  </div>

                  <!-- Total Price -->
                  <div class="flex items-center justify-between px-5 py-4 border-t border-gray-200">
                      <span id="total-title" class="text-xl font-bold"></span>
                      <span id="total-price" class="text-xl font-bold">Bạn chưa chọn món</span>
                  </div>

                  <!-- Confirm Button -->
                  <div class="px-5 py-4">
                      <button onclick="submitOrder()" id="confirm-order-btn" class="w-full px-4 py-2 font-bold text-white bg-green-600 rounded hover:bg-green-700">
                          Nhấn để lưu
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <!-- The script -->
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
      let initialOrder = <?php echo json_encode($user_foods); ?>;
      let orderState = true;

      let order = {
          // Store food items with their quantities and prices
          items: {},
          total: 0
      };

      // Get user foods and store to order array:
      function initializeOrder() {
          initialOrder.forEach(item => {
              order.items[item.food_id] = {
                  quantity: item.amount,
                  price: item.price,
                  name: item.food_name,
                  describes: item.describes
              };
          });
          order.total = calculateTotal();
          updateOrderDisplay();
      }

      initializeOrder();

      // Function to add an item to the order
      function addItemToOrder(foodId, price, name) {
          if (order.items[foodId]) {
              order.items[foodId].quantity++;
          } else {
              order.items[foodId] = {
                  quantity: 1,
                  price: price,
                  name: name
              };
          }
          order.total = calculateTotal();
          updateOrderDisplay();
      }

      // Removing an item
      function removeItemFromOrder(foodId) {
          if (order.items[foodId] && order.items[foodId].quantity > 1) {
              order.items[foodId].quantity -= 1;
          } else {
              delete order.items[foodId];
          }
          order.total = calculateTotal();
          updateOrderDisplay();
      }

      function calculateTotal() {
          return Object.values(order.items).reduce((total, item) => {
              return total + (item.quantity * item.price);
          }, 0);
      }

      function updateOrderDisplay() {
          const orderTableBody = document.querySelector('.order-details tbody');

          //   Total div state:
          const totalPriceElement = document.getElementById('total-price');
          const totalPriceTitle = document.getElementById('total-title');

          // Confirm button state:
          const confirmOrderBtn = document.getElementById('confirm-order-btn');

          // Clear existing items
          orderTableBody.innerHTML = '';

          let total = calculateTotal();
          if (total > 0) {
              totalPriceTitle.textContent = 'Tổng cộng (tạm tính)';
              totalPriceElement.textContent = `${formatNumber(total)}`;
          } else {
              totalPriceTitle.textContent = '';
              totalPriceElement.textContent = 'Bạn chưa chọn món';
          }

          Object.entries(order.items).forEach(([foodId, item]) => {
              const row = document.createElement('tr');
              row.className = 'text-gray-800';
              row.innerHTML = `
            <td class="px-2 py-2 text-sm bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <span>${item.name}</span>
                </div>
            </td>
            <td class="px-2 py-2 text-sm bg-white border-b border-gray-200 text-end">${formatNumber(item.price)}</td>
            <td class="px-2 py-2 text-sm bg-white border-b border-gray-200">
                <div class="flex items-center justify-center">
                    <!-- Decrease Button -->
                    <button class="px-2 py-1 font-bold text-white bg-green-500 rounded decrease-item-btn hover:bg-green-700" data-food-id="${foodId}">
                        -
                    </button>
                    <span class="mx-2">${item.quantity}</span>
                    <!-- Increase Button -->
                    <button class="px-2 py-1 font-bold text-white bg-green-500 rounded increase-item-btn hover:bg-green-700" data-food-id="${foodId}">
                        +
                    </button>
                </div>
            </td>
            <td class="px-2 py-2 text-sm bg-white border-b border-gray-200 text-end">${formatNumber(item.quantity * item.price)}</td>
            <td class="px-2 py-2 text-sm bg-white border-b border-gray-200">
                <div class="flex justify-center text-center">
                    <!-- Delete Button -->
                    <button class="text-red-500 delete-item-btn hover:text-red-700" data-food-id="${foodId}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </td>
            <td class="px-2 py-2 text-sm bg-white border-b border-gray-200">
                <input class="w-20 food-note-input" type="text" data-food-id="${foodId}" placeholder="Ghi chú..." value="${item.describes ? item.describes.trim() : ''}" onchange="updateItemDescribes(${foodId}, this.value)">
            </td>
        `;
              orderTableBody.appendChild(row);
          });

          orderState = false;
      }

      // Event listener for add item buttons
      document.querySelectorAll('.add-item-btn').forEach(button => {
          button.addEventListener('click', function() {
              const foodId = this.getAttribute('data-food-id');
              const foodPrice = parseFloat(this.getAttribute('data-food-price'));
              const foodName = this.getAttribute('data-food-name');
              addItemToOrder(foodId, foodPrice, foodName);
          });
      });

      // Event listener for add item describes/note
      function updateItemDescribes(foodId, describes) {
          if (order.items[foodId]) {
              order.items[foodId].describes = describes;
          }
      }

      //   Increase, decrease, delete
      document.querySelector('.order-details tbody').addEventListener('click', function(event) {
          // Find the closest element with data-food-id attribute
          const target = event.target.closest('[data-food-id]');
          if (!target) return; // Exit if no relevant target found

          const foodId = target.getAttribute('data-food-id');

          if (target.classList.contains('increase-item-btn')) {
              addItemToOrder(foodId);
          } else if (target.classList.contains('decrease-item-btn')) {
              removeItemFromOrder(foodId);
          } else if (target.classList.contains('delete-item-btn')) {
              delete order.items[foodId];
              order.total = calculateTotal();
              updateOrderDisplay();
          }
      });
  </script>


  <script>
      function searchFoods() {
          var input, filter, foods, foodName, i, txtValue;
          input = document.getElementById('searchInput');
          filter = input.value.trim().toUpperCase();
          foods = document.getElementsByClassName('food');

          for (i = 0; i < foods.length; i++) {
              foodName = foods[i].getElementsByClassName('food-name')[0];
              txtValue = foodName.textContent || foodName.innerText;

              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  foods[i].style.display = "";
              } else {
                  foods[i].style.display = "none";
              }
          }
      }
  </script>

  <script>
      function submitOrder() {
          const orderData = {
              user_id: <?php echo json_encode($user_id); ?>,
              meal_id: <?php echo json_encode($meal_id); ?>,
              items: order.items,
              total: order.total
          };

          fetch('/detail-meal/add-order', {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify(orderData)
              })
              .then(response => {
                  if (response.ok) {
                      return response.json();
                  } else {
                      throw new Error('Network response was not ok.');
                  }
              })
              .then(data => {
                  console.log('The response data:', data);
                  if (data.data.status == 'meal_closed_or_deleted') {
                      Swal.fire({
                          title: 'Warning',
                          text: 'Đơn này đã được xử lý theo thông tin đặt hàng gần nhất. Không thể chỉnh sửa tại thời điểm này. Vui lòng liên hệ host',
                          icon: 'warning',
                          confirmButtonText: 'Quay lại trang chủ'
                      }).then(() => {
                          window.location.href = "/";
                      });
                  }
                  if (data.data.status == 'success') {
                      Swal.fire({
                          title: 'Thành công!',
                          text: 'Bạn đã lưu thông tin đặt hàng thành công',
                          icon: 'success',
                          showDenyButton: true,
                          denyButtonText: 'Đóng',
                          confirmButtonText: 'Xem tổng đơn'
                      }).then((result) => {
                          if (result.isConfirmed) {
                              // Correct way to include PHP variable in JavaScript
                              window.location.href = '/detail-meal/show?meal_id=' + <?php echo json_encode($detail_meal[0]['id']); ?>;
                          } else if (result.isDenied) {
                              window.location.reload();
                          }
                      });
                  }
              })
              .catch((error) => {
                  console.error('Error:', error);
                  Swal.fire({
                      title: 'Error!',
                      text: 'Đã có lỗi xảy ra trong quá trình thao tác',
                      icon: 'error',
                      confirmButtonText: 'Ok'
                  });
              });
      }
  </script>