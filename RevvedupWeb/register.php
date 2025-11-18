<?php 
include "src/components/header.php";
?>
<body class="relative font-sans text-white ">

  <!-- Navbar -->
  <header class="absolute top-0 left-0 w-full flex justify-end items-center p-6 z-20 bg-black/50">
    <nav class="flex gap-6 text-sm font-semibold">
      <a href="login" class="hover:text-red-500">Sign In</a>
      <!--<a href="register" class="hover:text-red-500">Register</a>-->
    </nav>
  </header>

  <!-- Registration Section -->
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
        <h1 class="text-3xl font-bold text-center mb-4">Create Your Account</h1>
        <p class="text-center text-gray-300 mb-6">Sign up to access your dashboard.</p>


         <!-- Spinner Overlay -->
        <div id="spinner" class="absolute inset-0 flex items-center justify-center z-50  bg-white/70" style="display:none;">
            <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
        </div>

        <!-- Registration Form -->
         <form id="frmRegister" class="space-y-4">
          <div>
            <label for="fullname" class="block text-gray-300 mb-2">Full Name</label>
            <input type="text" name="fullname" id="fullname" placeholder="Full Name" 
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <div>
            <label for="email" class="block text-gray-300 mb-2">Email</label>
            <input type="email" name="email" id="email" placeholder="you@example.com" 
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <div>
            <label for="password" class="block text-gray-300 mb-2">Password</label>
            <input type="password" name="password" id="password" placeholder="********" 
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <div>
            <label for="confirm_password" class="block text-gray-300 mb-2">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="********" 
              class="w-full px-4 py-3 rounded-lg bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-red-600" required>
          </div>

          <button type="submit" class="w-full cursor-pointer bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-full transition">Register</button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-gray-400 mt-6">
          Already have an account? <a href="login" class="text-red-600 hover:underline">Sign In</a>
        </p>

      </div>
    </div>
  </section>

</body>

<?php 
include "src/components/footer.php";
?>
<script src="static/js/register.js"></script>