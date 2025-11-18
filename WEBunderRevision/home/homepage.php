<?php 
include "../src/components/home/header.php";
?>


<style>
.hotspot {
  position: absolute;
  transform: translate(-50%, -50%);
}

.hotspot::before {
  content: "";
  width: 20px;
  height: 20px;
  background: #8b0000;
  border: 3px solid #333;
  border-radius: 50%;
  display: block;
  cursor: pointer;
}

.tooltip {
  position: absolute;
  left: 50%;
  top: -10px;
  transform: translate(-50%, -100%);
  background: rgba(0,0,0,0.7);
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  opacity: 0;
  pointer-events: none;
  transition: opacity .3s;
  text-align: center;
}

.hotspot:hover .tooltip {
  opacity: 1;
}
</style>

<body class="relative font-sans text-white">

  <header class="absolute top-0 left-0 w-full flex justify-end items-center p-6 z-30 bg-black/50">
    <nav class="flex gap-6 text-sm font-semibold">
      <a href="logout" class="hover:text-red-500">Logout</a>
      <!--<a href="register" class="hover:text-red-500">Register</a>-->
    </nav>
  </header>

  <!-- Hero Section -->
<section class="relative w-full h-screen" style="background-image: url('../static/images/cover.jpg'); background-size: cover; background-position: center;">
  <div class="absolute inset-0 bg-black/60 z-10"></div>

  <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 z-20">
    <!-- Logo -->
    <img src="../static/images/dashboard_logo.png" alt="RevvedUp Logo" class="w-72 md:w-96 h-auto mb-12 mt-4 mx-auto">

    <!-- Headline -->
    <h1 class="text-3xl md:text-5xl font-bold mb-4">
      Your one-stop destination for all things motorcycle.
    </h1>
    <h2 class="text-xl md:text-2xl font-semibold mb-2">
      BROWSE PARTS, or book repairs — all in one place
    </h2>
    <p class="text-sm md:text-base mb-5">
      Fast. Reliable. Built for riders, by riders. Let’s get your bike back on the road.
    </p>

    <!-- Buttons -->
    <div class="flex gap-6 mb-4">
      <a href="index" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition">PRODUCTS</a>
      <a href="summary" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition">BOOK A REPAIR</a>
    </div>

    <!-- Emergency repair notice -->
    <p class="text-sm md:text-base text-yellow-400 mt-2 max-w-md">
      Emergency repair? Call us immediately at <span class="font-semibold">0967 156 6038</span>. 
      <em>(For motorcycles that broke down on the road only)</em>
    </p>
    
    <!-- Service area notice -->
    <h2 class="text-sm md:text-base text-yellow-400 mt-1 max-w-md py-16">
      <em>Service area: Taytay, Antipolo, Angono, Cainta</em>
</h2>

  </div>
</section>



  <section class="w-full py-16 bg-black flex justify-center items-center">
  <div class="relative max-w-4xl w-full">

    <!-- Background color behind image -->
    <div class="absolute inset-0 bg-black/40 z-10"></div>

    <!-- Motorcycle image -->
    <img 
      src="../static/images/motorcycle_bg.jpg" 
      alt="Motorcycle" 
      class="w-full h-auto relative z-0"
    >

    <!-- Hotspots overlay -->
    <div class="absolute inset-0 z-20">
      
      <!-- 🛞 Rear Tire -->
      <div class="hotspot" style="top:88%; left:27%;">
        <div class="tooltip w-56">
          <span class="font-semibold">Rear Tire</span><br>
          • Tire replacement<br>
          • Wheel balancing<br>
          • Tire pressure check<br>
          • Tube replacement
        </div>
      </div>

      <!-- ⚙️ Engine -->
      <div class="hotspot" style="top:67%; left:38%;">
        <div class="tooltip w-60">
          <span class="font-semibold">Engine</span><br>
          • Engine tune-up<br>
          • Oil change<br>
          • Spark plug replacement<br>
          • Valve clearance adjustment
        </div>
      </div>

      <!-- 🛠 Front Wheel -->
      <div class="hotspot" style="top:70%; left:65%;">
        <div class="tooltip w-60">
          <span class="font-semibold">Front Wheel & Brakes</span><br>
          • Brake pad replacement<br>
          • Brake fluid refill<br>
          • Rotor cleaning<br>
          • Front wheel alignment
        </div>
      </div>

      <!-- 🔧 Suspension -->
      <div class="hotspot" style="top:40%; left:60%;">
        <div class="tooltip w-60">
          <span class="font-semibold">Front Suspension</span><br>
          • Fork oil replacement<br>
          • Seal repair<br>
          • Suspension adjustment<br>
          • Front fork inspection
        </div>
      </div>

      <!-- 💨 Exhaust -->
      <div class="hotspot" style="top:73%; left:30%;">
        <div class="tooltip w-60">
          <span class="font-semibold">Exhaust / Muffler</span><br>
          • Exhaust leak repair<br>
          • Muffler replacement<br>
          • Exhaust cleaning<br>
          • Gasket replacement
        </div>
      </div>

      <!-- 💡 Headlight -->
      <div class="hotspot" style="top:25%; left:67%;">
        <div class="tooltip w-52">
          <span class="font-semibold">Headlight</span><br>
          • Bulb replacement<br>
          • Wiring repair<br>
          • Switch replacement<br>
          • Headlight alignment
        </div>
      </div>


      <div class="hotspot" style="top:35%; left:52%;">
        <div class="tooltip w-52">
          <span class="font-semibold">Fuel Tank</span><br>
          • Fuel tank cleaning<br>
          • Fuel pump inspection/replacement<br>
          • Leak repair / dent removal<br>
          • Fuel filter replacement
        </div>
      </div>

      <div class="hotspot" style="top:38%; left:40%;">
        <div class="tooltip w-52">
          <span class="font-semibold">Seat</span><br>
          • Seat hinge/lock inspection and lubrication<br>
          • Foam padding replacement<br>
          • Anti-slip coating application<br>
          • Waterproofing treatment
        </div>
      </div>

      <div class="hotspot" style="top:16%; left:50%;">
        <div class="tooltip w-52">
          <span class="font-semibold">Hand Clutch</span><br>
          • Clutch lever replacement<br>
          • Cable tension adjustment<br>
          • Cable lubrication / replacement<br>
          • Clutch lever pivot cleaning and lubrication
        </div>
      </div>

    </div>

  </div>
</section>

<section class="w-full py-16 bg-gray-900 text-white flex flex-col items-center">
  <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Contact Information -->
    <div>
      <h3 class="text-lg font-semibold mb-3">Contact Us</h3>
      <p class="mb-1">📞 0967 156 6038</p>
      <p class="mb-1">✉️ Revveduptaytay@gmail.com</p>
      <p class="mb-3">📍 Ilog pugad, Brgy. San Juan Manila East Road, Taytay, Philippines 1920</p>
      <a href="https://www.facebook.com/profile.php?id=61562469712505" target="_blank" rel="noopener noreferrer">
        <img src="../static/images/facebook_logo.png" 
             alt="Facebook"
             class="w-8 h-8 mt-2">
      </a>
    </div>

    <!-- Operating Hours -->
    <div>
      <h3 class="text-lg font-semibold mb-3">Operating Hours</h3>
      <p>Monday – Sunday: 8:00 AM – 6:00 PM</p>
    </div>

  </div>

  <!-- Footer Bottom -->
  <div class="mt-6 text-center text-gray-400 text-sm">
    © 2024 RevvedUp. All rights reserved.
  </div>
</section>





 
    






</body>


<?php 
include "../src/components/home/footer.php";
?>

<script src="../static/js/home/reviews.js"></script>
