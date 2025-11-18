<?php 
include "src/components/header.php";
?>
<body class="relative font-sans text-white ">

  <!-- Navbar -->
  <header class="absolute top-0 left-0 w-full flex justify-between items-center p-6 z-20 bg-black/50">
    <nav class="flex gap-6 text-sm font-semibold">
      <div class="text-white font-bold text-2xl">
       <a href="index" class="hover:text-red-300">RevvedUp</a>
      </div>
    </nav>
  </header>

  <!-- Login Section -->
  <section class="relative w-full h-screen" style="background-image: url('static/images/cover.jpg'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black/60 z-1"></div>
    <!-- Centered Container -->
    <div class="absolute inset-0 flex items-center justify-center">
      
      <!-- Card -->
      <div class="bg-gray-900/90 backdrop-blur-md rounded-2xl shadow-xl w-full max-w-md p-8 mx-4">
        
        <!-- Logo -->
        <div class="flex justify-center mb-6">
          <img src="static/images/logo.png" alt="RevvedUp Logo" class="w-40 md:w-48 h-auto">
        </div>

        <!-- Headline -->
        <h1 class="text-3xl font-bold text-center mb-4">Sign In to Your Account</h1>

         <!-- Spinner Overlay -->
        <div id="spinner" class="absolute inset-0 flex items-center justify-center z-50  bg-white/70" style="display:none;">
            <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <!-- Login Form -->
        <form id="frmLogin" class="space-y-4">
          <div>
            <label for="email" class="block text-gray-300 mb-2">Email</label>
            <input type="email" name="email" id="email" placeholder="you@example.com" required
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <div>
            <label for="password" class="block text-gray-300 mb-2">Password</label>
            <input type="password" name="password" id="password" placeholder="********" required
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600">
          </div>

          <div class="flex justify-between items-center text-sm text-gray-400">
            <label class="flex items-center gap-2">
              <input type="checkbox" class="accent-red-600"> Remember Me
            </label>
            <a href="forgot_password" class="hover:text-red-500">Forgot Password?</a>
          </div>

          <button type="submit" class="w-full cursor-pointer bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-full transition">Sign In</button>
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
<script src="static/js/login.js"></script>