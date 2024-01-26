  <!-- List product -->
  <section class="bg-white border-b py-4">
      <div class="col-span-full my-2 leading-tight text-center text-gray-800 flex flex-col gap-2">
          <h1 class="text-4xl font-bold">
              <?php if (isset($detail_meal)) {
                    echo htmlspecialchars($detail_meal[0]['store_name']);
                } ?>
          </h1>
          <h1 class="text-2xl italic">by <?php if (isset($detail_meal)) {
                                                echo htmlspecialchars($detail_meal[0]['display_name']);
                                            } ?></h1>
      </div>
      <div class="col-span-full mb-4">
          <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
      </div>
      <!-- Main -->
      <div class="container mx-auto bg-white shadow rounded text-gray-800 flex justify-between items-center gap-2">
          <!-- Left Column -->
          <div class="w-1/2 flex-1 flex flex-col min-h-screen">
              <div class="flex items-center border-b pb-2 mb-4">
                  <input id="searchInput" onkeyup="searchFoods()" class="border rounded py-1 px-3 mr-2 flex-grow" type="text" placeholder="Tìm món" />
                  <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                      </svg>
                  </button>
              </div>
              <!-- List Foods -->
              <div class="overflow-y-scroll max-h-screen">
                  <!-- Food -->
                  <?php foreach ($foods as $food) : ?>
                      <!-- Product -->
                      <div class="food flex items-center justify-between p-2">
                          <div class="flex items-center gap-2">
                              <img class="w-12 h-12 object-cover mr-4" src="<?php echo htmlspecialchars($food['image']); ?>" alt="<?php echo htmlspecialchars($food['name']); ?>" />
                              <span class="food-name font-bold"><?php echo htmlspecialchars($food['name']); ?></span>
                          </div>
                          <div class="flex items-center gap-2">
                              <span class="text-red-500 font-bold"><?php echo htmlspecialchars(number_format($food['price'], 0, ',', '.')); ?></span>
                              <button class="add-item-btn bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" data-food-id="<?php echo htmlspecialchars($food['id']); ?>" data-food-price="<?php echo htmlspecialchars($food['price']); ?>" data-food-name="<?php echo htmlspecialchars($food['name']); ?>">
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
              <div class="sticky top-28 w-full bg-white shadow rounded text-gray-800">
                  <!-- Order Title -->
                  <div class="font-bold text-xl text-center">Danh sách món của bạn</div>

                  <!-- Table -->
                  <div>
                      <table class="order-details table-fixed min-w-full leading-normal">
                          <thead>
                              <tr>
                                  <th class="lg:w-[400px] px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Sản phẩm</th>
                                  <th class="px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Giá</th>
                                  <th class="px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Số lượng</th>
                                  <th class="px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tổng</th>
                                  <th class="px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Xóa</th>
                                  <th class="lg:w-[100px] px-2 py-3 border-b-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ghi chú</th>
                              </tr>
                          </thead>
                          <tbody>
                              <!-- Food -->
                          </tbody>
                      </table>
                  </div>

                  <!-- Total Price -->
                  <div class="flex justify-between items-center px-5 py-4 border-t border-gray-200">
                      <span id="total-title" class="text-xl font-bold"></span>
                      <span id="total-price" class="text-xl font-bold">Bạn chưa chọn món</span>
                  </div>

                  <!-- Confirm Button -->
                  <div class="px-5 py-4">
                      <button id="confirm-order-btn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-not-allowed">
                          Xác nhận
                      </button>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- jQuery Script -->
  <script>
      $(document).ready(function() {
          console.log("DOM is ready!");
      });
  </script>

  <script>
      let initialOrder = <?php echo json_encode($user_foods); ?>;

      let order = {
          items: {}, // to store food items with their quantities and prices
          total: 0 // to store the total price
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
          const totalPriceElement = document.querySelector('#total-price');
          const totalPriceTitle = document.querySelector('#total-title');

          // Confirm button state:
          const confirmOrderBtn = document.querySelector('#confirm-order-btn');


          orderTableBody.innerHTML = ''; // Clear existing items

          let total = calculateTotal();
          if (total > 0) {
              totalPriceTitle.textContent = 'Tổng cộng (tạm tính)';
              totalPriceElement.textContent = `${total}đ`;
              confirmOrderBtn.classList.remove('cursor-not-allowed');
          } else {
              totalPriceTitle.textContent = '';
              totalPriceElement.textContent = 'Bạn chưa chọn món';
              confirmOrderBtn.classList.add('cursor-not-allowed');
          }

          console.log(order.items);
          Object.entries(order.items).forEach(([foodId, item]) => {
              const row = document.createElement('tr');
              row.className = 'text-gray-800';
              row.innerHTML = `
            <td class="px-2 py-2 border-b border-gray-200 bg-white text-sm">
                <div class="flex items-center">
                    <span>${item.name}</span>
                </div>
            </td>
            <td class="px-2 py-2 border-b border-gray-200 bg-white text-sm text-end">${item.price}đ</td>
            <td class="px-2 py-2 border-b border-gray-200 bg-white text-sm">
                <div class="flex items-center justify-center">
                    <!-- Decrease Button -->
                    <button class="decrease-item-btn bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded" data-food-id="${foodId}">
                        -
                    </button>
                    <span class="mx-2">${item.quantity}</span>
                    <!-- Increase Button -->
                    <button class="increase-item-btn bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded" data-food-id="${foodId}">
                        +
                    </button>
                </div>
            </td>
            <td class="px-2 py-2 border-b border-gray-200 bg-white text-sm text-end">${item.quantity * item.price}đ</td>
            <td class="px-2 py-2 border-b border-gray-200 bg-white text-sm">
                <div class="flex justify-center text-center">
                    <!-- Delete Button -->
                    <button class="delete-item-btn text-red-500 hover:text-red-700" data-food-id="${foodId}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </td>
            <td class="px-2 py-2 border-b border-gray-200 bg-white text-sm">
                <input class="w-20 food-note-input" type="text" data-food-id="${foodId}" placeholder="Ghi chú..." value="${item.describes ? item.describes : ''}">
            </td>
        `;
              orderTableBody.appendChild(row);
          });
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

      document.querySelector('.confirm-order-btn').addEventListener('click', () => {
          // Send order data to the server
          // For example, using an AJAX request or form submission
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