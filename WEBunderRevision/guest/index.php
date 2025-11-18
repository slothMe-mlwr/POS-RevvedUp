<?php 
include "../src/components/guest/header.php";
?>

<body class="bg-gray-900/90 font-sans">


 <section class="relative w-full h-screen ">

<?php 
include "../src/components/guest/nav.php";
?>

<div class="h-16"></div> 



  <!-- Sort dropdown -->
<div class="mb-4 max-w-6xl mx-auto px-4 py-6 flex items-center justify-start space-x-2">
  <label for="sort" class="font-medium text-white">Sort by:</label>
  <select id="sort" class="border border-gray-300 bg-white text-gray-700 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
    <option value="default">Top Viewed</option>
    <option value="low-high">Price: Low to High</option>
    <option value="high-low">Price: High to Low</option>
  </select>

  <input type="text" placeholder="Search ..." id="searchInput"
        class="rounded-full px-4 py-2 w-full bg-white border ">

</div>



  <!-- Product Grid -->
  <div id="product-grid" class="max-w-6xl mx-auto px-4 grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <!-- Products will load here dynamically -->
  </div>



  </section>

</body>
<?php 
include "../src/components/guest/footer.php";
?>



<script src="../static/js/home/product_api.js"></script>
<script src="../static/js/home/employee_api.js"></script>
