<?php
include "../src/components/view/header.php"; 
?>

<!-- Main Content -->
<main class="flex-1 flex flex-col bg-gray-100 min-h-screen">

  <!-- Topbar -->
  <header class="bg-black text-white flex items-center space-x-3 px-6 py-6">
    <h1 class="text-lg font-semibold">NOTIFICATION</h1>
  </header>

  <!-- Table Header -->
  <section class="p-6 flex-1">
    <div class="bg-white rounded-xl shadow overflow-hidden">
      <div class="flex justify-between items-center px-4 py-3">
        <h2 class="text-gray-700 font-semibold">Fast-Moving & Slow-Moving Items</h2>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Product Name</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Quantity</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Sales Speed</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Alert</th>
            </tr>
          </thead>
          <tbody id="restockTableBody" class="bg-white divide-y divide-gray-200">
            <!-- DYNAMIC CONTENT -->
          </tbody>
        </table>
      </div>
    </div>


  </section>



</main>

<?php 
include "../src/components/view/footer.php"; 
?>


<script src="../static/js/view/restock_alert.js"></script>
<!--<script src="../static/js/view/notifications.js"></script>-->

