<div class="bg-white p-8">
    <!-- Table 1 -->
    <div class="container mx-auto px-4 bg-white shadow-md rounded-lg" style="height: 70vh;"> <!-- Set 2/3 of viewport height -->
        <div class="py-4 px-8 text-2xl font-semibold border-b border-gray-300 text-gray-800 bg-yellow-200 rounded-full">Công nợ</div>
        <div class="overflow-x-auto overflow-y-scroll h-full"> <!-- Set overflow-y-scroll and height to full to take the height of parent -->
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Phải trả
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Phải thu
                        </th>
                        <th class="w-30 px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            QR Code
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tình trạng
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tổng
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1 -->
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex items-center">
                                <div class="ml-3">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        Nguyen Long Vu
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="w-10 h-10 cursor-pointer">
                                <img src="https://img.vietqr.io/image/tpbank-0979119989-compact2.png?amount=100000&addInfo=CT&accountName=TO%KHA%VY" alt="QR Code" onclick="openModal(this.src)">
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                <span class="relative">PHẢI TRẢ</span>
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="#" class="text-blue-600 hover:text-blue-900 whitespace-no-wrap">Xác nhận</a>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex items-center">
                                <div class="ml-3">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        Lê Huy
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="w-10 h-10 cursor-pointer">
                                <img src="https://img.vietqr.io/image/tpbank-0979119989-compact2.png?amount=100000&addInfo=CT&accountName=TO%KHA%VY" alt="QR Code" onclick="openModal(this.src)">
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">PHẢI THU</span>
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="#" class="text-blue-600 hover:text-blue-900 whitespace-no-wrap">Xác nhận</a>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex items-center">
                                <div class="ml-3">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        To Kha Vy
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="w-10 h-10 cursor-pointer">
                                <img src="https://img.vietqr.io/image/tpbank-0979119989-compact2.png?amount=100000&addInfo=CT&accountName=TO%KHA%VY" alt="QR Code" onclick="openModal(this.src)">
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                <span aria-hidden="true" class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                <span class="relative">PHẢI THU</span>
                            </span>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">100.000 đ</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="#" class="text-blue-600 hover:text-blue-900 whitespace-no-wrap">Xác nhận</a>
                        </td>
                    </tr>
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