//ForgotPassword.js

$(document).ready(function () {


    
$("#frmForgotPassword").submit(function (e) {
      e.preventDefault();
  
      $('#spinner').show();
      $('#btnSendOTP').prop('disabled', true);
      
      var formData = $(this).serializeArray(); 
      formData.push({ name: 'requestType', value: 'ForgotPassword' });
      var serializedData = $.param(formData);
  
      $.ajax({
        type: "POST",
        url: "controller/end-points/controller.php",
        data: serializedData,
        dataType: 'json',
        success: function (response) {
        console.log(response.status);

        if (response.status === "success") {
            alertify.success('OTP sent successfully.');
            setTimeout(function () {
             window.location.href = "verify_otp";
            }, 1000);
        } else {
            $('#spinner').hide();
            $('#btnLogin').prop('disabled', false);
            console.log(response);
            alertify.error(response.message);
        }


        },error: function () {
          $('#spinner').hide();
          $('#btnLogin').prop('disabled', false);
          alertify.error('An error occurred. Please try again.');
        }
      });
    });


});