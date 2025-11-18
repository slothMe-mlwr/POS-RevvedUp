$(document).ready(function(){

  // --- Set Appointment Date to today and prevent past dates ---
  const dateInput = $("#appointmentDate");
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const formattedToday = `${yyyy}-${mm}-${dd}`;

  dateInput.val(formattedToday);
  dateInput.attr("min", formattedToday);

  const timeSelect = $("#appointmentTime");
  const startHourDefault = 9; // 9 AM
  const endHour = 18; // 6 PM

  // --- Populate 2-hour intervals ---
  function populateTimeOptions() {
      timeSelect.empty();
      const now = new Date();
      const selectedDate = new Date(dateInput.val());
      const isToday = selectedDate.toDateString() === now.toDateString();

      let hour = startHourDefault;
      while (hour < endHour) {
          let displayHour = hour % 24;
          let displayMinute = "00";
          let startValue = displayHour.toString().padStart(2, '0') + ":" + displayMinute;

          const suffix = hour >= 12 ? "PM" : "AM";
          let displayHour12 = hour % 12;
          if (displayHour12 === 0) displayHour12 = 12;
          let displayText = `${displayHour12}:${displayMinute} ${suffix}`;

          const disabled = isToday && hour <= now.getHours() ? "disabled" : "";

          timeSelect.append(`<option value="${startValue}" ${disabled}>${displayText}</option>`);

          hour += 2;
      }
  }

  populateTimeOptions();

  dateInput.on("change", function() {
      populateTimeOptions();
  });

  // --- Open / Close Repair Modal ---
  $("#open-repair").click(function(e){
    e.preventDefault();
    $("#repairModal").removeClass("opacity-0 pointer-events-none");
  });

  $("#close-repair").click(function(){
    $("#repairModal").addClass("opacity-0 pointer-events-none");
  });

  $(document).on("click", function (e) {
    if ($(e.target).is("#repairModal")) {
      $("#repairModal").removeClass("opacity-100").addClass("opacity-0 pointer-events-none");
    }
  });

  // --- Fetch Employees ---
  function fetchEmployees(selectedDate, selectedTime){
    $.ajax({
      url: "https://revvedup.site/controller/end-points/controller.php",
      method: "GET",
      data: {
        requestType: "fetch_available_employees",
        appointmentDate: selectedDate,
        appointmentTime: selectedTime
      },
      dataType: "json",
      success: function(response){
        if (response.status === 403) {
          Swal.fire({
            icon: 'info',
            title: 'Fully Booked',
            text: response.message,
            confirmButtonColor: '#3085d6'
          });
          $("#employee").html("<option value=''>No employees available at this time</option>");
          $("#employee").prop("disabled", true);
          return;
        }

        if(response.status === 200){
          let options = "<option value=''>-- Select an Employee --</option>";
          response.data.forEach(function(emp){
            options += `<option value="${emp.user_id}">${emp.nickname}</option>`;
          });
          $("#employee").html(options).prop("disabled", false);
        } else {
          $("#employee").html("<option>No employees found</option>");
        }
      },
      error: function(){
        $("#employee").html("<option>Error loading employees</option>");
      }
    });
  }

  $("#appointmentDate, #appointmentTime").on("change", function() {
      if ($("#specificEmployeeCheck").is(":checked")) {
          const selectedDate = $("#appointmentDate").val();
          const selectedTime = $("#appointmentTime").val();
          if (selectedDate && selectedTime) fetchEmployees(selectedDate, selectedTime);
      }
  });

  // --- MULTI-CHECKBOX SERVICES ---
  const serviceSelect = $("#serviceSelect");
  const dropdown = $("#serviceDropdown");
  const selectedDisplay = $("#selectedServices");

  serviceSelect.on("click", function(e){
    e.stopPropagation();
    dropdown.toggleClass("hidden");
  });

  $(document).on("click", function(e){
    if (!$(e.target).closest("#serviceSelect, #serviceDropdown").length) {
      dropdown.addClass("hidden");
    }
  });

  $(document).on("change", "#specifyProblemCheck", function() {
    if ($(this).is(":checked")) {
      $("#problemDescriptionWrapper").removeClass("hidden");
      $("#problemDescription").removeAttr("required"); // JS handles validation
    } else {
      $("#problemDescriptionWrapper").addClass("hidden");
      $("#problemDescription").removeAttr("required");
    }
  });

  $(document).on("change", "#specificEmployeeCheck", function() {
      const selectedDate = $("#appointmentDate").val();
      const selectedTime = $("#appointmentTime").val();

      if ($(this).is(":checked")) {
          if (!selectedDate || !selectedTime) {
              Swal.fire({
                  icon: 'warning',
                  title: 'Select Date & Time First',
                  text: 'Please select appointment date and time before choosing a specific employee.',
                  confirmButtonColor: '#3085d6'
              });
              $(this).prop("checked", false);
              return;
          }
          $("#employeeWrapper").removeClass("hidden");
          $("#employee").attr("required", true);
          fetchEmployees(selectedDate, selectedTime);
      } else {
          $("#employeeWrapper").addClass("hidden");
          $("#employee").removeAttr("required").val("");
      }
  });

  $(document).on("change", ".service-checkbox", function(){
    let selected = [];
    $(".service-checkbox:checked").each(function(){
      selected.push($(this).data("name"));
    });
    selectedDisplay.text(selected.length > 0 ? selected.join(", ") : "Select services");
  });

  function getSelectedServices(){
    let selected = [];
    $(".service-checkbox:checked").each(function(){
      selected.push($(this).val());
    });
    return selected;
  }

  // ✅ --- FORM SUBMIT HANDLER ---
  $("#repairForm").submit(function(e){
    e.preventDefault();

    const selectedServices = getSelectedServices();
    const otherDescription = $("#specifyProblemCheck").is(":checked") 
                                ? $("#problemDescription").val().trim() 
                                : "";

    // Validation: must have either services or other description
    if (selectedServices.length === 0 && otherDescription === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete',
            text: 'Please select at least one service or provide a description in "Other".',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    const formData = new FormData(this);
    formData.append('requestType', 'RequestAppointment');
    formData.set('services', JSON.stringify(selectedServices));
    formData.set('problemDescription', otherDescription);


    $.ajax({
        url: "../controller/end-points/controller.php",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(response){
            if(response.status === "success"){   
                Swal.fire({
                    icon: 'success',
                    title: 'Booked!',
                    text: 'Repair booked successfully! \nYour request is pending for approval.',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    window.location.href = "summary";
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!',
                    text: response.message,
                    confirmButtonColor: '#3085d6'
                });
            }
            $("#repairModal").addClass("opacity-0 pointer-events-none");
        },
        error: function(xhr, status, error){
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error connecting to server.',
                confirmButtonColor: '#3085d6'
            });
        }
    });

  });

});
