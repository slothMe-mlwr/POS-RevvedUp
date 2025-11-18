<?php 
include "../src/components/view/header.php";
?>

<main class="flex-1 flex flex-col">

 <!-- Header -->
<header class="bg-black text-white px-6 py-6 flex items-center space-x-3">
   <!--<span id="btnBackToSales" class="material-icons cursor-pointer hover:text-gray-200 hidden"> arrow_back </span>--> 
   <h1 id="mainTitle" class="text-lg font-semibold">SALES REPORT</h1> 
  </header>



<section class="flex-1 p-6">
  <!-- Toggle Buttons -->
 <div class="flex justify-end mb-4 space-x-2">
    <button id="revenueBtn" 
      class="cursor-pointer bg-gray-200 text-black font-semibold text-sm px-4 py-2 rounded min-w-[220px] whitespace-nowrap hover:bg-gray-300 hover:scale-105 transition duration-200">
        Total Sales & Revenue
    </button>
    <button id="printBtn" 
      class="cursor-pointer bg-gray-200 text-black font-semibold text-sm px-4 py-2 rounded hover:bg-gray-300 hover:scale-105 transition duration-200">
      <img src="../static/images/print.png" alt="Logout" class="w-8 h-8">
    </button>
    <button id="weeklyBtn" class="cursor-pointer px-4 py-2 border border-red-800 bg-red-800 text-white rounded">
        Weekly
    </button>
    <button id="monthlyBtn" class="cursor-pointer px-4 py-2 border border-gray-400 bg-gray-200 text-gray-700 rounded">
        Monthly
    </button>
</div>

  <!-- Chart Card -->
  <div class="bg-white rounded-lg shadow-md p-6">
   <div class="flex justify-between items-center mb-2">
      <h2 id="chartTitle" class="text-center text-xl text-red-900 font-bold w-full">
        Product Sales
      </h2>
     <!-- <div class="flex gap-2">
        <button id="revenueBtn" 
          class="cursor-pointer bg-gray-300 text-black font-semibold text-sm px-4 py-2 rounded min-w-[220px] whitespace-nowrap hover:bg-gray-400 transition">
          Total Sales & Revenue
        </button>
        <button id="printBtn" 
          class="cursor-pointer bg-red-900 text-white font-semibold text-sm px-4 py-2 rounded hover:bg-red-700 transition">
          Print Report
        </button>
      </div>-->
    </div>

    <div id="salesChart"></div>

    <!-- Time buttons (weeks/months) -->
  <div class="mt-4">
    <label for="timeSelect" class="block text-gray-700 font-medium mb-2">Select Week/Month:</label>
    <select id="timeSelect" class="border border-gray-400 rounded-lg p-2 min-w-[220px]"></select>
  </div>

    <!-- Sales Info -->
    <div id="salesInfo" class="flex justify-center mt-6 gap-6 flex-wrap">
      <div class="bg-gray-100 px-6 py-3 rounded shadow text-center">
        <span id="infoLabel1" class="block text-gray-600 text-sm">Product Sales</span>
        <span id="infoValue1" class="block text-2xl font-bold">₱ 0.00</span>
      </div>
      <div id="infoBox2" class="bg-gray-100 px-6 py-3 rounded shadow text-center hidden">
        <span id="infoLabel2" class="block text-gray-600 text-sm">Revenue</span>
        <span id="infoValue2" class="block text-2xl font-bold">₱ 0.00</span>
      </div>
    </div>
  </div>
</section>

<!-- Loader -->
<div id="loader" style="display:none; background-color: rgba(0,0,0,0.2);" class="fixed inset-0 flex items-center justify-center z-50">
  <div class="w-12 h-12 border-4 border-red-900 border-t-transparent rounded-full animate-spin"></div>
</div>

<footer class="flex flex-col sm:flex-row gap-3 justify-between items-stretch sm:items-center bg-white border-t px-4 py-3"></footer>
<br class="block sm:hidden">
<br class="block sm:hidden">
</main>

<?php 
include "../src/components/view/footer.php";
?>

<script src="../static/js/view/analytics.js"></script>
