<?php 
include "src/components/header.php";
?>
<body class="relative font-sans text-white ">

  <!-- Navbar -->
  <header class="absolute top-0 left-0 w-full flex justify-end items-center p-6 z-20 bg-black/50">
    <nav class="flex gap-6 text-sm font-semibold">
      <a href="login" class="hover:text-red-500">Sign In</a>
      <a href="register" class="hover:text-red-500">Register</a>
    </nav>
  </header>

  <!-- Login Section -->
  <section class="relative w-full h-screen" style="background-image: url('static/images/cover.jpg'); background-size: cover; background-position: center;">
    
    <!-- Centered Container -->
    <div class="absolute inset-0 flex items-center justify-center">
      
      <!-- Card -->
      <div class="bg-gray-900/90 backdrop-blur-md rounded-2xl shadow-xl w-full max-w-md p-8 mx-4">
        
        <!-- Logo -->
        <div class="flex justify-center mb-6">
          <img src="static/images/logo.png" alt="RevvedUp Logo" class="w-40 md:w-48 h-auto">
        </div>

        <!-- Headline -->
        <h1 class="text-3xl font-bold text-center mb-4">Forgot Password</h1>
        <p class="text-center text-gray-300 mb-6">Enter OTP</p>

         <!-- Spinner Overlay -->
        <div id="spinner" class="absolute inset-0 flex items-center justify-center z-50  bg-white/70" style="display:none;">
            <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <!-- Login Form -->
        <form id="frmVerifyOTP" class="space-y-4">
          <div>
            <label for="OTP" class="block text-gray-300 mb-2">Enter OTP</label>
            <input type="text" name="otp" placeholder="6-digit OTP" required
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <div>
            <label for="new_password" class="block text-gray-300 mb-2">Enter New Password</label>
            <input type="password" name="new_password" placeholder="New Password" required
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <button type="submit" class="w-full cursor-pointer bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-full transition">Verify & Reset Password</button>
        </form>

        <!-- Register Link -->
        <p class="text-center text-gray-400 mt-6">
          Don't have an account? <a href="register" class="text-red-600 hover:underline">Register</a>
        </p>

      </div>
    </div>
  </section>

</body>

<?php 
include "src/components/footer.php";
?>
<script src="static/js/verify_OTP.js"></script>