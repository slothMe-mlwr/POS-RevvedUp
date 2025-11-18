
<div id="detailsModal" class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
    <h2 class="text-2xl font-bold text-red-900 mb-4">Appointment Details</h2>
    <div id="modalContent" class="space-y-2">
      <!-- Dynamic content from JS will be injected here -->
    </div>
    <div class="mt-4 text-right">
      <button id="closeModal" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Close</button>
    </div>
  </div>
</div>



<!-- Book Repair Modal -->
<div id="repairModal" 
     class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
    <h2 class="text-2xl font-bold text-red-900 mb-6">Schedule a Repair</h2>

    <form id="repairForm" class="space-y-4">

      <!-- ⚠️ Appointment Time Warning -->
      <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 rounded">
        <p class="text-sm font-medium">
          ⚠️ Please note: Appointment times are available only between <strong>8:00 AM</strong> and <strong>6:00 PM</strong>.
        </p>
      </div>
      <!-- Services (Now using Select2 for scrollable dropdown with checkboxes) -->
      <div>
        <label class="block font-medium">Select Services</label>
        <select id="service" name="service[]" multiple class="w-full border rounded px-3 py-2">
          <option value="Change Oil">Change Oil</option>
          <option value="Troubleshooting">Troubleshooting</option>
          <option value="Engine Upgrade">Engine Upgrade</option>
          <option value="CVT Cleaning">CVT Cleaning</option>
          <option value="FI Cleaning">FI Cleaning</option>
          <option value="Throttle Body Cleaning">Throttle Body Cleaning</option>
          <option value="Front Shock Tuning and Repair">Front Shock Tuning and Repair</option>
          <option value="Tune Up">Tune Up</option>
          <option value="Engine Build">Engine Build</option>
          <option value="Ballrace Replacement">Ballrace Replacement</option>
          <option value="Preventive Maintenance Service">Preventive Maintenance Service</option>
          <option value="Engine Refresh">Engine Refresh</option>
          <option value="Top Overhaul">Top Overhaul</option>
          <option value="Tappet and Valve Clearance">Tappet and Valve Clearance</option>

        </select>
      </div>

      <!-- Other Services--->
      <div id="otherServiceWrapper" class="hidden mt-2">
        <label class="block font-medium mb-1">Specify Other Service</label>
        <input type="text" id="otherServiceInput" name="otherService[]" class="w-full border rounded px-2 py-1" placeholder="Enter service">
      </div> 

      <!-- Personal Info -->
      <div>
        <label class="block font-medium">Full Name</label>
        <input type="text" id="fullname" name="fullname" class="w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block font-medium">Contact Number</label>
        <input type="text" id="contact" name="contact" class="w-full border rounded px-3 py-2" maxlength="11" required placeholder="09123456789">
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

      <!-- Appointment Date -->
      <div>
        <label class="block font-medium">Appointment Date</label>
        <input type="date" id="appointmentDate" name="appointmentDate" class="w-full border rounded px-3 py-2" required>
      </div>

      <!-- Appointment Time -->
      <div>
        <label class="block font-medium">Appointment Time</label>
        <select id="appointmentTime" name="appointmentTime" class="w-full border rounded px-3 py-2" required></select>
      </div>

      <!-- Specific Mechanic -->
      <div class="flex items-center mt-2">
        <input type="checkbox" id="specificMechanic" class="mr-2">
        <label for="specificMechanic">Do you want a specific mechanic?</label>
      </div>

      <!-- Employee selection -->
      <div id="employeeWrapper" class="hidden mt-2">
        <label class="block font-medium">Select Employee</label>
        <select id="employee" name="employee_id" class="w-full border rounded px-3 py-2">
        </select>
      </div>

      <p class="text-sm text-gray-600">⚠️ Appointment will be pending for approval.</p>

      <!-- Buttons -->
      <div class="mt-6 flex justify-end space-x-2">
        <button type="button" id="close-repair" class="cursor-pointer bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Cancel</button>
        <button type="submit" id="btnSubmit" class="cursor-pointer bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Submit</button>
      </div>
    </form>
  </div>
</div>

<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Flatpickr CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="../static/js/home/summary.js"></script>

<script>
  let stopRefresh = false;
$(document).ready(function () {
    // Toggle "Other Service"
    function toggleOtherService() {
        const selectedValues = $('#service').val() || [];
        const isOtherSelected = selectedValues.includes('Other');
        $('#otherServiceWrapper').toggle(isOtherSelected);
        $('#otherServiceInput').prop('required', isOtherSelected);
        if (isOtherSelected) {
            // Use setTimeout to ensure the input is visible before focusing
            setTimeout(function() {
                $('#otherServiceInput').focus();
            }, 100);
        }
    }

    // Toggle "Specific Mechanic"
$('#specificMechanic').change(function() {
    const isChecked = $(this).is(':checked');
    $('#employeeWrapper').toggle(isChecked);
    $('#employee').prop('required', isChecked);
    setTimeout(() => stopRefresh = false, 500); // 🕒 re-enable after UI settles
});
    // Limit contact number to 11 digits only
    $('#contact').on('input', function() {
        this.value = this.value.replace(/\D/g,'').slice(0,11);
    });

    // Prevent past dates
    function getLocalDateString() {
        const now = new Date();
        return `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')}`;
    }
    $('#appointmentDate').attr('min', getLocalDateString());
    $('#appointmentDate').val(getLocalDateString());

    function formatAMPM(hour) {
        let suffix = hour >= 12 ? 'PM' : 'AM';
        let h = hour % 12;
        h = h ? h : 12;
        return `${h}:00 ${suffix}`;
    }

    // Initialize Select2 for appointmentTime
    $('#appointmentTime').select2({
        placeholder: 'Select Time',
        dropdownParent: $('#repairModal'),
        width: '100%',
        templateResult: function(data) {
            if (!data.id) return data.text;

            // Display only the plain time (remove anything like '(Full)' or '(Past)')
            var $result = $('<span></span>').text(data.text);

            // Gray out disabled options
            if ($(data.element).prop('disabled')) {
                $result.css({
                    'color': '#aaa',
                    'pointer-events': 'none'
                });
            }

            return $result;
        },
        templateSelection: function(data) {
            if (!data.id) return data.text;
            // Show only the time in the selection
            return data.text;
        },
        allowClear: true
    });

    function refreshSelect2() {
        $('#appointmentTime').trigger('change.select2');
    }

    // ✅ Select2 for service selection (dropdown with functional checkboxes and scrollable)
    $('#service').select2({
        placeholder: 'Select Service(s)',
        dropdownParent: $('#repairModal'),
        width: '100%',
        closeOnSelect: false,
        allowClear: true,
        templateResult: function(data) {
            if (!data.id) return data.text;

            var $result = $('<div class="flex items-center"></div>');
            var $checkbox = $('<input type="checkbox" style="margin-right: 8px;">');
            var $label = $('<span class="cursor-pointer"></span>').text(data.text);

            var selectedValues = $('#service').val() || [];
            if (selectedValues.includes(data.id)) {
                $checkbox.prop('checked', true);
            }

            $result.append($checkbox).append($label);

            // Handle click on checkbox
            $checkbox.on('click', function(e) {
                e.stopPropagation();
                var isChecked = $(this).prop('checked');
                if (isChecked) {
                    $('#service').select2('select', data.id);
                } else {
                    $('#service').select2('unselect', data.id);
                }
            });

            // Handle click on label (text)
            $label.on('click', function(e) {
                e.stopPropagation();
                var isChecked = $checkbox.prop('checked');
                $checkbox.prop('checked', !isChecked);
                if (!isChecked) {
                    $('#service').select2('select', data.id);
                } else {
                    $('#service').select2('unselect', data.id);
                }
            });

            return $result;
        },
        templateSelection: function(data) {
            if (!data.id) return data.text;
            return data.text;
        }
    });

    $('#service').on('select2:open', function() {
        $('.select2-results__options').css({
            'max-height': '150px',
            'overflow-y': 'auto'
        });
    });

    // Sync checkbox state on select/unselect
    $('#service').on('select2:select select2:unselect', function(e) {
        var selectedValues = $('#service').val() || [];
        $('.select2-results__option').each(function() {
            var $option = $(this);
            var data = $option.data('data');
            if (data && data.id) {
                var $checkbox = $option.find('input[type="checkbox"]');
                if (selectedValues.includes(data.id)) {
                    $checkbox.prop('checked', true);
                } else {
                    $checkbox.prop('checked', false);
                }
            }
        });
        toggleOtherService();
        // Close dropdown if "Other" is selected
        if (e.type === 'select2:select' && e.params.data.id === 'Other') {
            $('#service').select2('close');
        }
    });

function populateTimes(minHour = 8) {
    const timeSelect = $('#appointmentTime');
    timeSelect.empty();

    const selectedDate = $('#appointmentDate').val();
    if (!selectedDate) return;

    const isSpecificMechanic = $('#specificMechanic').is(':checked');
    const empId = isSpecificMechanic ? parseInt($('#employee').val()) : null;

    $.ajax({
        url: 'controller.php',
        type: 'POST',
        data: { action: 'getBookingStatus', appointmentDate: selectedDate },
        dataType: 'json',
        success: function(data) {
            const now = new Date();
            const selectedDay = new Date(selectedDate);

            for (let h = 8; h <= 18; h += 2) {
                const display = formatAMPM(h);
                const value = `${h}:00`;
                let disabled = false;
                let reason = '';

                // Global full check
                if (data[value] && data[value].total >= 3) {
                    disabled = true;
                    reason = ' (Full)';
                }

                // Specific mechanic booked
                if (isSpecificMechanic && empId && data[value] && data[value].employees.includes(empId)) {
                    disabled = true;
                    reason = ' (Unavailable)';
                }

                // Disable past hours today
                if (selectedDay.toDateString() === now.toDateString() && h < minHour) {
                    disabled = true;
                    reason = ' (Past)';
                }

                const option = $('<option>')
                    .val(value)
                    .text(display + reason)
                    .prop('disabled', disabled);

                timeSelect.append(option);
            }

            if (timeSelect.find('option:not(:disabled)').length === 0) {
                timeSelect.append('<option disabled>No available times</option>');
            }

            // Re-initialize Select2
            if (timeSelect.hasClass("select2-hidden-accessible")) {
                timeSelect.select2('destroy');
            }
            timeSelect.select2({
                placeholder: 'Select Time',
                dropdownParent: $('#repairModal'),
                width: '100%',
                templateResult: function(data) {
                    if (!data.id) return data.text;
                    var $result = $('<span></span>').text(data.text);
                    if ($(data.element).prop('disabled')) {
                        $result.css({ color: '#999', 'pointer-events': 'none', opacity: 0.6 });
                    }
                    return $result;
                },
                templateSelection: function(data) {
                    return data.text;
                },
                allowClear: true
            });
        },
        error: function() {
            console.error('Failed to load booking status — showing default times.');
            for (let h = 8; h <= 18; h += 2) {
                const display = formatAMPM(h);
                timeSelect.append(`<option value="${h}:00">${display}</option>`);
            }
        }
    });
}

    // Close modal
    $('#close-repair').click(function () {
        $('#repairModal').addClass('opacity-0 pointer-events-none');
    });

    // Refresh times when date or employee changes
    $('#appointmentDate').on('change', populateTimes);
    //$('#employee').on('change', populateTimes);
    populateTimes();

    // Populate times when modal opens
    $(document).on('click', '.book-btn, #openRepairModal', function() {
        $('#repairModal').removeClass('opacity-0 pointer-events-none'); // show modal
        // populateTimes(); // refresh available times
    });

    // Safety check on submit
$('#repairForm').submit(function(e) {
    e.preventDefault(); // temporarily prevent default for testing

    // Get typed "Other" first
    const otherText = $('#otherServiceInput').val().trim();

    // Get selected services from Select2
    let services = $('#service').val() || [];

    // If "Other" is selected, replace it with typed text
    if (services.includes('Other')) {
        if (otherText) {
            services = services.map(s => s === 'Other' ? otherText : s);
        } else {
            alert('⚠️ Please specify the "Other" service.');
            return; // stop submission
        }
    }

    // Update the select so backend gets correct data
    $('#service').val(services);

    // ✅ Now submit the form
    this.submit();
});


});

// Show payment modal when user clicks "View Payment Info"
$(document).on('click', '#viewPaymentBtn', function() {
  $('#paymentModal').removeClass('opacity-0 pointer-events-none');
});

// Close payment modal
$('#closePaymentModal').click(function() {
  $('#paymentModal').addClass('opacity-0 pointer-events-none');
});

document.addEventListener("DOMContentLoaded", () => {
  const paymentModal = document.getElementById("paymentModal");
  const viewBtn = document.getElementById("viewPaymentBtn");
  const closeBtn = document.getElementById("closePaymentModal");

  const gcashBtn = document.getElementById("gcashBtn");
  const mayaBtn = document.getElementById("mayaBtn");
  const gcashQR = document.getElementById("gcashQR");
  const mayaQR = document.getElementById("mayaQR");
  const options = document.getElementById("paymentOptions");

  // Open modal
  viewBtn.addEventListener("click", () => {
    paymentModal.classList.remove("opacity-0", "pointer-events-none");
  });

  // Close modal
  closeBtn.addEventListener("click", () => {
    paymentModal.classList.add("opacity-0", "pointer-events-none");
    gcashQR.classList.add("hidden");
    mayaQR.classList.add("hidden");
    options.classList.remove("hidden");
  });

  // GCash button
  gcashBtn.addEventListener("click", () => {
    options.classList.add("hidden");
    gcashQR.classList.remove("hidden");
  });

  // Maya button
  mayaBtn.addEventListener("click", () => {
    options.classList.add("hidden");
    mayaQR.classList.remove("hidden");
  });
});

</script>
