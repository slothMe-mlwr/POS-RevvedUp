<!-- Category Modal -->
<div id="categoryModal" 
     class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-8 max-h-[90vh] flex flex-col">
    <h2 class="text-2xl font-bold text-red-900 mb-6">Categories</h2>

    <!-- Scrollable category grid -->
    <div id="category-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-8 overflow-y-auto pr-2 flex-1">
      <!-- Dynamic categories will render here -->
    </div>

    <div class="mt-6 text-right">
      <button id="close-category" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Close</button>
    </div>
  </div>
</div>


<!-- Book Repair Modal -->
<div id="repairModal" 
     class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 max-h-[85vh] overflow-y-auto">
    <h2 class="text-2xl font-bold text-red-900 mb-4 text-center">Book a Repair</h2>

    <form id="repairForm" class="space-y-4">


      <!-- Personal Info -->
      <div>
        <label class="block font-medium">Full Name</label>
        <input type="text" id="fullname" name="fullname" class="w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block font-medium">Contact Number</label>
        <input type="text" id="contact" name="contact" class="w-full border rounded px-3 py-2" required>
      </div>

      <!-- City -->
      <div>
        <label class="block font-medium">Select City</label>
        <select id="city" name="city" class="w-full border rounded px-3 py-2" required>
          <option value="">-- Select City --</option>
          <option value="Antipolo">Antipolo</option>
          <option value="Angono">Angono</option>
          <option value="Taytay">Taytay</option>
          <option value="Cainta">Cainta</option>
        </select>
      </div>

      <!-- Street -->
      <div>
        <label class="block font-medium">Street</label>
        <input type="text" id="street" name="street" class="w-full border rounded px-3 py-2" placeholder="Enter your street address" required>
      </div>

            <!-- Service selection -->
      <div class="relative">
        <label class="block font-medium">Select Service</label>
        <button id="serviceSelect" type="button" class="w-full border rounded px-3 py-2">
          <span id="selectedServices">--Select services--</span>
        </button>
        <div id="serviceDropdown" class="absolute bg-white border w-full mt-1 hidden rounded-md shadow-md z-10">
          <div id="checkboxWrapper" class="max-h-40 overflow-y-auto p-2">
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Change Oil" data-name="Change Oil">
              Change Oil
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="CVT Cleaning" data-name="CVT Cleaning">
              CVT Cleaning
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="FI Cleaning" data-name="FI Cleaning">
              FI Cleaning
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Throttle Body Cleaning" data-name="Throttle Body Cleaning">
              Throttle Body Cleaning
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Tune Up"" data-name="Tune Up">
              Tune Up
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Engine Build" data-name="Engine Build">
              Engine Build
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Ballrace Replacement" data-name="Ballrace Replacement">
              Ballrace Replacement
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Engine Refresh" data-name="Engine Refresh">
              Engine Refresh
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Top Overhaul" data-name="Top Overhaul">
              Top Overhaul
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" class="service-checkbox" value="Engine Upgrade" data-name="Engine Upgrade">
              Engine Upgrade
            </label>


          </div>
        </div>
      </div>


      <!-- Specify service / problem -->
      <div class="mt-2">
        <label class="flex items-center gap-2">
          <input type="checkbox" id="specifyProblemCheck" class="mr-2">
          <span>Specify the service or problem</span>
        </label>
        <div id="problemDescriptionWrapper" class="hidden mt-2">
          <textarea id="problemDescription" name="problemDescription" rows="3" class="w-full border rounded px-3 py-2" placeholder="Describe the problem or specific service needed..."></textarea>
        </div>
      </div>

      <!-- Date & Time -->
      <div>
        <label class="block font-medium">Appointment Date</label>
        <input type="date" id="appointmentDate" name="appointmentDate" class="w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block font-medium">Appointment Time</label>
        <select id="appointmentTime" name="appointmentTime" class="w-full border rounded px-3 py-2" required>
          <!-- Options will be populated dynamically -->
        </select>
      </div>


            <!-- Employee -->
      <!-- Ask if user wants a specific employee -->
            <div class="mt-4">
              <label class="flex items-center gap-2">
                <input type="checkbox" id="specificEmployeeCheck" class="mr-2">
                <span>Do you want to select a specific employee?</span>
              </label>

              <!-- Employee dropdown wrapper (hidden by default) -->
              <div id="employeeWrapper" class="hidden mt-2">
                <label class="block font-medium">Select Employee</label>
                <select id="employee" name="employee_id" class="w-full border rounded px-3 py-2">
                  <option value="">Loading employees...</option>
                </select>
              </div>
            </div>

      <!-- Note -->
      <p class="text-sm text-gray-600">⚠️ Appointment will be pending for approval.</p>

      <!-- Buttons -->
      <div class="mt-4 flex justify-end space-x-2">
        <button type="button" id="close-repair" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Submit</button>
      </div>
    </form>
  </div>
</div>



<!-- Modal -->
<div id="detailsModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
    <button id="closeModal" class="absolute cursor-pointer top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
    <h2 class="text-xl font-bold mb-4">Appointment Details</h2>
    <div id="modalContent" class="space-y-2 text-gray-700">
      <!-- Dynamic content goes here -->
    </div>
  </div>
</div>