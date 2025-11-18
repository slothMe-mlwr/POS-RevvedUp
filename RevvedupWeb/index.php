<?php 

include "src/components/header.php";
?>
<body class="relative font-sans text-white overflow-y-auto">

  <!-- Navbar -->
  <header class="absolute top-0 left-0 w-full flex justify-end items-center p-6 z-20 bg-black/50">
    <nav class="flex gap-6 text-sm font-semibold">
      <a href="login" class="hover:text-red-500">Sign In</a>
      <!--<a href="register" class="hover:text-red-500">Register</a>-->
    </nav>
  </header>

  <!-- Hero Section -->
<section class="relative w-full h-screen" style="background-image: url('static/images/cover.jpg'); background-size: cover; background-position: center;">
  
  <!-- Gradient Dark Overlay -->
  <div class="absolute inset-0" 
       style="background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.6));">
  </div>

  <!-- Hero Content -->
  <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 z-10">
    <!-- Logo -->
    <img src="static/images/logo.png" alt="RevvedUp Logo" class="w-72 md:w-96 h-auto mb-8 mt-4 mx-auto">

    <!-- Headline -->
    <h1 class="text-3xl md:text-5xl font-bold mb-4">
      Your one-stop destination for all things motorcycle.
    </h1>
    <h3 class="text-xl md:text-2xl font-semibold mb-2 text-white">
      BROWSE PARTS, or book repairs — all in one place
    </h3>
    <p class="text-sm md:text-base mb-3">
      Fast. Reliable. Built for riders, by riders. Let’s get your bike back on the road.
    </p>

    <p class="text-sm md:text-base mb-3 font-semibold text-white/80">
      🛠️ Roadside help available! For breakdowns in Antipolo, Cainta, Angono & Taytay<br>
      Call us immediately: 0905-808-5396<br>
      <em>Not for regular service appointments!</em>
    </p>

    <!-- Buttons -->
    <div class="flex flex-col items-center gap-4 mt-6">
      <div class="flex gap-6">
        <a href="guest/" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition">PRODUCTS</a>
        <a href="login" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full transition">SCHEDULE A REPAIR</a>
      </div>

      <p id="dailyTipText" class="text-sm md:text-base mt-4 font-semibold text-yellow-300 text-center">
        💡 Loading Tip of the Day...
      </p>

        <!-- Facebook Line (Centered, Extra Small Icon) -->
  Follow us on: 
  <a href="https://www.facebook.com/profile.php?id=61562469712505" target="_blank" 
     class="inline-flex items-center gap-1 font-semibold">
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="inline-block" 
         width="50" height="50" 
         fill="#1877F2"  <!-- ✅ Official Facebook blue -->
         viewBox="0 0 24 24">
      <path d="M22.675 0h-21.35C.595 0 0 .594 0 1.326v21.348C0 
      23.406.595 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413
      c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.462.099 
      2.794.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 
      1.764v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 
      0 1.324-.594 1.324-1.326V1.326C24 .594 23.405 
      0 22.675 0z"/>
    </svg>
  </a>
</p>
      </div>
    </div>
  </section>
  <!-- Motorcycle Hover Section -->
<section class="relative w-full py-16 bg-white flex flex-col items-center">
  <!-- Instruction Header -->
  <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
    Move your mouse over the motorcycle parts to see tips and services
  </h2>

  <div class="relative max-w-4xl w-full">
    <!-- Motorcycle Image -->
    <img src="static/images/motocycle.jpg" alt="Motorcycle" class="w-full h-auto rounded-lg shadow-lg select-none">

    <!-- Hotspots -->

    <!-- Rear Tire -->
    <div class="hotspot" style="top: 45%; left: 14%; width: 7%; height: 12%;"
         data-tooltip="Rear Tire
💡Tips: Check tire pressure weekly, inspect for wear or punctures, avoid harsh braking.
         
Service we offer:
Preventive Maintenance Service 
Ballrace Replacement (if wheel bearing related)"></div>

    <!-- Front Tire -->
    <div class="hotspot" style="top: 42%; left: 75%; width: 7%; height: 12%;"
         data-tooltip="Front Tire
💡Tips: Check tire pressure weekly, inspect for wear or punctures, avoid harsh braking.
         
Service we offer:
Preventive Maintenance Service
Front Shock Tuning and Repair (if suspension issue)"></div>

    <!-- Engine -->
    <div class="hotspot" style="top: 32%; left: 40%; width: 12%; height: 15%;"
         data-tooltip="Engine
💡Tips: Monitor oil levels, avoid over-revving, regular cleaning
         
Service we offer:
Change Oil
Tune Up
Engine Refresh
Engine Build
Top Overhaul
Tappet and Valve Clearance
Troubleshooting"></div>

    <!-- Seat -->
    <div class="hotspot" style="top: 20%; left: 35%; width: 15%; height: 8%;"
         data-tooltip="Seat
💡Tips: Keep clean, avoid prolonged sun exposure
         
Service we offer:
Preventive Maintenance Service (general inspection)"></div>

    <!-- Handlebars -->
    <div class="hotspot" style="top: 12%; left: 46%; width: 6%; height: 6%;"
         data-tooltip="Handlebars
💡Tips: Check for looseness, ensure smooth steering.
         
Service we offer:
Front Shock Tuning and Repair
Preventive Maintenance Service"></div>

    <!-- Fuel Tank -->
    <div class="hotspot" style="top: 25%; left: 50%; width: 6%; height: 6%;"
         data-tooltip="Fuel Tank
💡Tips: Keep clean, avoid fuel contamination, inspect for leaks
         
Service we offer:
FI Cleaning
Preventive Maintenance Service"></div>

    <!-- Exhaust -->
    <div class="hotspot" style="top: 50%; left: 50%; width: 10%; height: 6%;"
         data-tooltip="Exhaust 
💡Tips: Check for rust or damage, clean periodically
         
Service we offer:
Engine Refresh
Troubleshooting 
Preventive Maintenance Service"></div>

    <!-- Brake System -->
    <div class="hotspot" style="top: 35%; left: 62%; width: 10%; height: 8%;"
         data-tooltip="Brakes 
💡Tips: Pad replacement, fluid check, lever adjustment.
         
Service we offer:
Preventive Maintenance Service 
Troubleshooting"></div>

    <!-- Tooltip -->
    <div id="tooltip" class="tooltip"></div>
  </div>
</section>

<style>
  .relative { position: relative; }
  h2 { font-size: 1.5rem; font-weight: bold; color: #1f2937; }
  .hotspot {
    position: absolute;
    cursor: pointer;
    background-color: rgba(255, 0, 0, 0);
    transition: transform 0.2s ease;
  }
  .hotspot:hover { transform: scale(1.05); }
  .tooltip {
    position: fixed;
    background-color: rgba(0,0,0,0.85);
    color: #fff;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 14px;
    display: none;
    z-index: 50;
    pointer-events: none;
    white-space: pre-wrap;
    max-width: 250px;
    transition: opacity 0.2s ease;
  }
</style>

<script>
const hotspots = document.querySelectorAll('.hotspot');
const tooltip = document.getElementById('tooltip');

hotspots.forEach(hotspot => {
  hotspot.addEventListener('mouseenter', e => {
    tooltip.innerText = e.currentTarget.dataset.tooltip;
    tooltip.style.display = 'block';
    tooltip.style.opacity = '1';
  });

  hotspot.addEventListener('mousemove', e => {
    const offsetX = 20;
    const offsetY = -50;
    let top = e.clientY + offsetY;
    let left = e.clientX + offsetX;

    const tooltipRect = tooltip.getBoundingClientRect();
    if (left + tooltipRect.width > window.innerWidth) {
      left = e.clientX - tooltipRect.width - offsetX;
    }
    if (top < 0) top = e.clientY + 10;

    tooltip.style.top = top + 'px';
    tooltip.style.left = left + 'px';
  });

  hotspot.addEventListener('mouseleave', () => {
    tooltip.style.opacity = '0';
    tooltip.style.display = 'none';
  });
});

  // Tip of the Day Script
document.addEventListener("DOMContentLoaded", function() {
    fetch("controller/end-points/get_daily_tip.php")
        .then(response => response.json())
        .then(data => {
            const tipText = document.getElementById("dailyTipText");
            if (data.success) {
                tipText.textContent = '💡 ' + data.tip;
            } else {
                tipText.textContent = "Tip unavailable: " + (data.error || data.tip);
            }
        })
        .catch(() => {
            document.getElementById("dailyTipText").textContent = "Failed to load tip.";
        });
});
</script>

<?php 
include "src/components/footer.php";
?>
