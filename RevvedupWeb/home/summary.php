<?php 
include "../src/components/home/header.php";
?>
<body class="bg-gray-50 font-sans">

<?php 
include "../src/components/home/nav.php";
?>

<!-- Main Content -->
<main class="flex-1 p-6">

  <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6 space-y-6">

    <!-- Search -->
    <div class="flex justify-end">
      <div class="relative w-full md:w-64">
        <input type="text" placeholder="Search ..." id="searchInput"
          class="rounded-full px-4 py-2 w-full border focus:outline-none ">
        <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-red-700">
          <span class="material-icons">search</span>
        </button>
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
              Reference Number
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
              Date
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
              Address
            </th>

             <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
              Status
            </th>

            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody id="appointmentTableBody" class="bg-white divide-y divide-gray-200">
          <!-- DYNAMIC CONTENT -->
        </tbody>
      </table>
    </div>

  </div>

</main>

<?php include "modal.php"; ?>
<?php 
include "../src/components/home/footer.php";
?>

<script src="../static/js/home/product_api.js"></script>
<script src="../static/js/home/employee_api.js"></script>
<script src="../static/js/home/summary.js"></script>
