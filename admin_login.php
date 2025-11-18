<?php 
include "src/components/header.php";
?>


<body class="min-h-screen bg-gradient-to-b from-black to-red-900 flex flex-col items-center text-white relative">
<!-- Navbar 
<div class="absolute top-4 right-6 flex items-center gap-4">
    <a href="#" class="text-gray-300 hover:text-white text-sm">Log In as</a>
    <a href="admin_login" class="text-gray-300 hover:text-white text-sm">Admin</a>
    <a href="employee_login" class="text-white font-semibold border-b-2 border-white text-sm">Employee</a>
</div>
-->
  <div id="spinner" class="absolute inset-0 flex items-center justify-center z-50  bg-white/70" style="display:none;">
      <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
  </div>


  <!-- Container for Logo and Form -->
  <div class="flex flex-col items-center justify-center flex-grow -mt-16">
    
    <!-- Logo -->
    <img src="static/images/dashboard_logo2.png" alt="RevvedUp Logo" class="mx-auto w-48 mb-4 drop-shadow-lg">

    <!-- Login Form Card -->
    <div class="bg-white/10 backdrop-blur-sm border border-white/20 p-8 rounded-2xl w-80 shadow-2xl">
      <h1 class="text-2xl font-bold text-center mb-6 text-white">Log In</h1>
      
      <form id="frmLogin" method="POST" class="flex flex-col space-y-4">
        <input 
          type="text" 
          placeholder="Username" 
          name="username"
          class="px-4 py-2 rounded-lg bg-white/90 text-white placeholder-gray-500 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-700 transition"
        >
        
        <input 
          type="password" 
          placeholder="Password" 
          name="password"
          class="px-4 py-2 rounded-lg bg-white/90 text-white placeholder-gray-500 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-700 transition"
        >
        
        <button 
          type="submit" 
          id="btnLogin"
          class="bg-white text-black hover:bg-gray-300 hover:text-black font-semibold py-2 rounded-lg transition duration-200"
        >
          Login
        </button>

        <a 
          href="forgot_password" 
          class="text-sm text-gray-300 hover:text-white text-center mt-2 transition"
        >
          Forgot Password?
        </a>
      </form>
    </div>
  </div>

</body>

<?php 
include "src/components/footer.php";
?>
<script src="static/js/admin_login.js"></script>
