<?php 
include "../src/components/home/header.php";
?>
<body class="bg-white font-sans">

<?php 
include "../src/components/home/nav.php";
?>

<!-- Main Container -->
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

  <!-- Sort & Search Section -->
  <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
    
    <!-- Sort Dropdown -->
    <div class="flex items-center space-x-2">
      <label for="sort" class="font-medium">Sort by:</label>
      <select id="sort" class="border rounded px-3 py-2">
        <option value="default">All Products</option>
        <option value="low-high">Available</option>
        <option value="high-low">Unavailable</option>
      </select>
    </div>

    <!-- Search -->
    <div class="relative w-full md:w-64">
      <input type="text" placeholder="Search ..." id="searchInput"
        class="rounded-full px-4 py-2 w-full bg-white border ">
      <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-red-700">
        <span class="material-icons">search</span>
      </button>
    </div>

  </div>

  <!-- Product Grid -->
  <div id="product-grid" class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <!-- Products will load here dynamically -->
  </div>



<!-- Modal -->
<div id="productModal" class="fixed inset-0 bg-black/50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 p-4">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl p-6 flex flex-col md:flex-row relative overflow-hidden">

    <!-- Close button -->
    <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>

    <!-- Left: Images -->
    <div class="md:w-1/2 flex justify-center items-center mb-4 md:mb-0">
      <img id="modalImage" src="" alt="Product Image" class="w-full h-auto max-h-[400px] object-contain rounded">
    </div>

    <!-- Right: Details -->
    <div class="md:w-1/2 md:pl-6 flex flex-col justify-center">
      <h2 id="modalName" class="text-2xl font-semibold text-gray-800 mb-2"></h2>
      <p id="modalPrice" class="text-red-600 font-bold text-xl mb-2"></p>
      <p id="modalStock" class="text-gray-500 mb-4"></p>
      <p id="modalDesc" class="text-gray-700"></p>
    </div>
  </div>
</div>





</div>

<?php include "modal.php"; ?>
<?php 
include "../src/components/home/footer.php";
?>

<script src="../static/js/home/product_api.js"></script>
<script src="../static/js/home/employee_api.js"></script>
