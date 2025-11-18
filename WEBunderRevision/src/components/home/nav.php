<!-- Navbar -->
<nav class="bg-gradient-to-r from-black to-red-700 p-4 md:flex md:justify-between md:items-center">
  <div class="flex justify-between items-center">
    <!-- Logo -->
    <div class="text-white font-bold text-2xl">
      <a href="homepage" class="hover:text-red-300">RevvedUp</a>
    </div>

    <!-- Mobile Menu Button -->
    <div class="md:hidden">
      <button id="mobileMenuBtn" class="text-white focus:outline-none">
        <span class="material-icons">menu</span>
      </button>
    </div>
  </div>

  <!-- Links + Profile (combined for mobile vertical stacking) -->
  <div id="navMenu" class="hidden flex-col mt-4 space-y-3 md:flex md:flex-row md:items-center md:space-y-0 md:space-x-6 md:mt-0">
    <!-- Nav Links -->
    <div class="flex flex-col md:flex-row md:items-center md:space-x-6 space-y-3 md:space-y-0">
      <a href="index" class="text-white hover:text-red-300">Products</a>
      <a href="#" id="open-repair" class="text-white hover:text-red-300">Book a Repair</a>
      <a href="summary" class="text-white hover:text-red-300">Booking Summary</a>
    </div>

    <!-- Profile Dropdown -->
    <div class="relative mt-3 md:mt-0">
      <button id="profileBtn" class="flex cursor-pointer items-center text-white focus:outline-none hover:text-red-300">
        <img src="../static/images/user.png" alt="Profile" class="rounded-full w-8 h-8 mr-2">
        <span class="font-medium"><?=$On_Session[0]['customer_fullname']?></span>
        <span class="material-icons ml-1">arrow_drop_down</span>
      </button>

      <!-- Dropdown Menu -->
      <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg z-50">
        <a href="logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
      </div>
    </div>
  </div>
</nav>

<script>
  // Profile dropdown toggle
  const profileBtn = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');

  profileBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent window click from immediately closing
    profileDropdown.classList.toggle('hidden');
  });

  // Close dropdown when clicking outside
  window.addEventListener('click', (e) => {
    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
      profileDropdown.classList.add('hidden');
    }
  });

  // Mobile menu toggle
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const navMenu = document.getElementById('navMenu');

  mobileMenuBtn.addEventListener('click', () => {
    navMenu.classList.toggle('hidden');
  });
</script>

<!--Make it mobile responsive and set vertical all tabs on mobile view-->