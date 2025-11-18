
$(document).ready(function(){
  // Open Repair Modal
  $("#open-repair").click(function(e){
    e.preventDefault();
    $("#repairModal").removeClass("opacity-0 pointer-events-none");
    fetchEmployees();
  });

  // Close Repair Modal
  $("#close-repair").click(function(){
    $("#repairModal").addClass("opacity-0 pointer-events-none");
  });

  // Also close when clicking outside modal content
      $(document).on("click", function (e) {
        if ($(e.target).is("#repairModal")) {
          $("#repairModal")
              .removeClass("opacity-100")
              .addClass("opacity-0 pointer-events-none");
        }
      });







  // Fetch Employees from API
  function fetchEmployees(){
    $.ajax({
      url: "http://localhost/POSunderRevision2/controller/end-points/controller.php?requestType=fetch_all_users",
      method: "GET",
      dataType: "json",
      success: function(response){
        if(response.status === 200){
          let options = "";
          response.data.forEach(function(emp){
            options += `<option value="${emp.user_id}">${emp.firstname} ${emp.lastname}</option>`;
          });
          $("#employee").html(options);
        } else {
          $("#employee").html("<option>No employees found</option>");
        }
      },
      error: function(){
        $("#employee").html("<option>Error loading employees</option>");
      }
    });
  }















  $(document).ready(function() {
    // Show/hide "Other Service" input
    $("#service").change(function(){
        console.log('changgee');
        if($(this).val() === "other"){
            $("#otherServiceWrapper").removeClass("hidden");
            $("#otherService").attr("required", true);
        } else {
            $("#otherServiceWrapper").addClass("hidden");
            $("#otherService").removeAttr("required").val("");
        }
    });

    // Handle form submit
   $("#repairForm").submit(function(e){
    e.preventDefault();

    var formData = $(this).serializeArray();
    formData.push({ name: 'requestType', value: 'RequestAppointment' });
    var serializedData = $.param(formData);

    $.ajax({
        url: "../controller/end-points/controller.php",
        method: "POST",
        data: serializedData,
        dataType: "json",
        success: function(response){
            if(response.status === "success"){   
                Swal.fire({
                    icon: 'success',
                    title: 'Booked!',
                    text: 'Repair booked successfully! \nYour request is pending for approval.',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    // Redirect AFTER user closes the alert
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

            // Hide modal
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


});