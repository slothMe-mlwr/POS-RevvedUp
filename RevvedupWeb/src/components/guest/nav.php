
    <!-- Top Navbar: Sign In / Register -->
    <header class="fixed top-0 left-0 w-full flex justify-between items-center p-4 z-30 bg-black/60">
        <!-- Logo -->
        <div class="text-white font-bold text-2xl">
            <a href="../" class="hover:text-red-300">RevvedUp</a>
        </div>

        <!-- Sign In / Register -->
        <nav class="flex gap-4 text-sm font-semibold text-white">
            <a href="../login" class="hover:text-red-500">Sign In</a>
            <a href="../register" class="hover:text-red-500">Register</a>
        </nav>
    </header>




<script>
    // Toggle mobile menu
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks');
    mobileMenuBtn.addEventListener('click', () => {
        navLinks.classList.toggle('hidden');
    });
</script>
