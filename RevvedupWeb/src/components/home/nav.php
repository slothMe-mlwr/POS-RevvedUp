<!-- Navbar -->
<nav class="bg-gradient-to-r from-red-900 to-red-700 p-4 md:flex md:justify-between md:items-center">
  <div class="flex justify-between items-center">
    <!-- Logo -->
    <div class="text-white font-bold text-2xl">
      <a href="index" class="hover:text-red-300">RevvedUp</a>
    </div>

    <!-- Mobile Menu Button -->
    <div class="md:hidden">
      <button id="mobileMenuBtn" class="text-white focus:outline-none">
        <span class="material-icons">menu</span>
      </button>
    </div>
  </div>

  <!-- Links + Profile -->
  <div id="navMenu" class="hidden flex-col mt-4 space-y-3 md:flex md:flex-row md:items-center md:space-y-0 md:space-x-6 md:mt-0">
    <div class="flex flex-col md:flex-row md:items-center md:space-x-6 space-y-3 md:space-y-0">
      <a href="#" id="open-repair" class="text-white hover:text-red-300">Schedule a Repair</a>
      <a href="summary" class="text-white hover:text-red-300">Booking Summary</a>
    <!-- <a href="#" id="openFeedback" class="text-white hover:text-red-300">Feedback</a> ---> 
    </div>

    <!-- Profile Dropdown -->
    <div class="relative mt-3 md:mt-0">
      <button id="profileBtn" class="flex cursor-pointer items-center text-white focus:outline-none hover:text-red-300">
        <img src="../static/images/user.png" alt="Profile" class="rounded-full w-8 h-8 mr-2">
        <span class="font-medium"><?=$On_Session[0]['customer_fullname']?></span>
        <span class="material-icons ml-1">arrow_drop_down</span>
      </button>

      <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg z-50">
        <a href="logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
      </div>
    </div>
  </div>
</nav>

<script>
  const profileBtn = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');

  profileBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // prevent closing immediately
    profileDropdown.classList.toggle('hidden'); // toggle visibility
  });

  // Close dropdown if clicked outside
  document.addEventListener('click', (e) => {
    if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
      profileDropdown.classList.add('hidden');
    }
  });
</script>

<!-- Full-page Feedback Section (Overlay) -->
<!--
<div id="feedbackSection">
  <div id="feedbackContent"> -->
      <!-- Styled Exit Button 
      <button id="backFromFeedback" class="exitBtn">&times;</button>

      <h1 class="text-2xl font-bold text-gray-800 mb-4">💬 Customer Feedback</h1>

      <div id="feedbackList" class="space-y-4 mb-8">
          <p class="text-gray-400 text-center">Loading feedbacks...</p>
      </div> --->

      <!-- Submit Feedback Form 
      <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-xl font-semibold mb-3 text-gray-700">Share your experience</h2>
          <form id="frmFeedback" class="space-y-4">
              <div id="starRating" class="flex space-x-1 text-3xl mb-2">
                  <span class="star cursor-pointer text-gray-300" data-value="1">&#9733;</span>
                  <span class="star cursor-pointer text-gray-300" data-value="2">&#9733;</span>
                  <span class="star cursor-pointer text-gray-300" data-value="3">&#9733;</span>
                  <span class="star cursor-pointer text-gray-300" data-value="4">&#9733;</span>
                  <span class="star cursor-pointer text-gray-300" data-value="5">&#9733;</span>
              </div>
              <input type="hidden" name="rating" id="rating" required />
              <textarea name="comments" placeholder="Your feedback..." rows="3" class="border rounded w-full p-2" required></textarea>
              <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">Submit Feedback</button>
          </form>
      </div>
  </div>
</div>

<style>
  /* Full-page overlay for feedback */
  #feedbackSection {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.6);
      z-index: 9999;
      overflow-y: auto;
      display: none; /* hidden by default */
      padding: 2rem;
  }

  #feedbackContent {
      max-width: 800px;
      margin: 0 auto;
      background: white;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      position: relative;
  }

  /* Styled exit button */
  .exitBtn {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: #f87171; /* red */
      color: white;
      border: none;
      font-size: 1.2rem;
      width: 2rem;
      height: 2rem;
      border-radius: 50%;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.3);
      transition: background 0.2s;
  }

  .exitBtn:hover {
      background: #ef4444; /* darker red on hover */
  }
</style>

<script>

  const FEEDBACK_CONTROLLER = "/we-revision/RevvedupWEBB/controller/end-point/controller.php";
  // Profile dropdown toggle
  const profileBtn = document.getElementById('profileBtn');
  const profileDropdown = document.getElementById('profileDropdown');

  profileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    profileDropdown.classList.toggle('hidden');
  });

  window.addEventListener('click', (e) => {
    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
      profileDropdown.classList.add('hidden');
    }
  });

  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const navMenu = document.getElementById('navMenu');
  mobileMenuBtn.addEventListener('click', () => {
    navMenu.classList.toggle('hidden');
  });

  // ⭐ OPEN FEEDBACK SECTION
  $("#openFeedback").on("click", function(e){
      e.preventDefault();
      $("#feedbackSection").fadeIn(); // show overlay
      fetchFeedbacks(); // load feedbacks
  });

  // ⭐ EXIT BUTTON
  $("#backFromFeedback").on("click", function() {
      $("#feedbackSection").fadeOut(); // hide overlay
  });

  // ⭐ STAR RATING
  $("#starRating .star").click(function() {
      const value = $(this).data("value");
      $("#rating").val(value);
      $("#starRating .star").css("color","#d1d5db");
      for(let i=0;i<value;i++){
          $("#starRating .star").eq(i).css("color","#facc15");
      }
  });

  // ⭐ FETCH FEEDBACKS
  function fetchFeedbacks() {
      $.ajax({
          type: "POST",
          url: "FEEDBACK_CONTROLLER",
          data: { requestType: "FetchAllFeedbacks" },
          success: function(response){
              const res = JSON.parse(response);
              let html = "";
              if(res.status === "success" && res.data.length > 0){
                  res.data.forEach(f => {
                      html += `
                      <div class="bg-white rounded-lg p-4 shadow">
                          <div class="flex items-center mb-1">
                              ${"★".repeat(f.rating)}${"☆".repeat(5-f.rating)}
                              <span class="ml-2 text-gray-500 text-sm">${f.customer_fullname} • ${f.submitted_at}</span>
                          </div>
                          <p class="text-gray-700">${f.comments}</p>
                      </div>`;
                  });
              } else {
                  html = '<p class="text-gray-400 text-center">No feedback yet.</p>';
              }
              $("#feedbackList").html(html);
          },
          error: function(){
              $("#feedbackList").html('<p class="text-red-500 text-center">Failed to load feedbacks.</p>');
          }
      });
  }

  // ⭐ SUBMIT FEEDBACK
  $("#frmFeedback").submit(function(e){
      e.preventDefault();
      $.ajax({
          type: "POST",
          url: "FEEDBACK_CONTROLLER",
          data: $(this).serialize() + "&requestType=SubmitFeedback",
          success: function(response){
              const res = JSON.parse(response);
              if(res.status === "success"){
                  alertify.success(res.message);
                  $("#frmFeedback")[0].reset();
                  $("#starRating .star").css("color","#d1d5db");
                  fetchFeedbacks(); // refresh list
              } else {
                  alertify.error(res.message || "Something went wrong.");
              }
          },
          error: function(){
              alertify.error("Something went wrong. Please try again.");
          }
      });
  }); -->

</script>
