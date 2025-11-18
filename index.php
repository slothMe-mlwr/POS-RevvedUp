<?php 
include "src/components/header.php";
?>



<body class="min-h-screen bg-gradient-to-b from-black to-red-900 flex flex-col items-center text-white relative">
<!-- Navbar -->
<div class="absolute top-4 right-6 flex items-center gap-4">
   <!-- <a href="#" class="text-gray-300 hover:text-white text-sm">Log In</a>
    <a href="admin_login" class="text-gray-300 hover:text-white text-lg fonr-semibold">Log In</a>-->
   <!-- <a href="employee_login" class="text-gray-300 hover:text-white text-sm">Employee</a>-->
</div>



 <!-- Spinner Overlay -->
  <div id="spinner" class="absolute inset-0 flex items-center justify-center z-50  bg-white/70" style="display:none;">
      <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
  </div>


<!-- Container for Logo and Form -->
<div class="flex flex-col items-center justify-center flex-grow -mt-16"> 
  <!-- Logo -->
  <img src="static/images/dashboard_logo2.png" alt="RevvedUp Logo" class="mx-auto w-56 mb-2">
<a href="admin_login" class="text-gray-300 text-xl font-semibold mx-auto p-4 rounded-lg hover:text-white hover:scale-105 transition duration-200 text-center">
  Log In
</a>


</div>
</body>

<?php 
include "src/components/footer.php";
?>
<script src="static/js/admin_login.js"></script>