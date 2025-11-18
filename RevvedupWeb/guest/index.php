<?php 
include "../src/components/guest/header.php";
?>

<body class="bg-white font-sans">


 <section class="relative w-full h-screen" style="background-image: url('../static/images/cover.jpg'); background-size: cover; background-position: center;">

<?php 
include "../src/components/guest/nav.php";
?>

<div class="h-16"></div> 



  <!-- Sort dropdown -->
<div class="mb-4 max-w-6xl mx-auto px-4 py-6 flex items-center justify-start space-x-2">
  <label for="sort" class="font-medium text-white">Sort by:</label>
  <select id="sort" class="border border-gray-300 bg-white text-gray-700 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
    <option value="default">All Products</option>
    <option value="low-high">Available</option>
    <option value="high-low">Unavailable</option>
  </select>

  <input type="text" placeholder="Search ..." id="searchInput"
        class="rounded-full px-4 py-2 w-full bg-white border ">
      <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-red-700">
        <span class="material-icons">search</span>
      </button>

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
