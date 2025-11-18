$(document).ready(function () {
  $("#frmLogin").submit(function (e) {
    e.preventDefault();

    $('#spinner').show();
    $('#btnLogin').prop('disabled', true);
    
    const formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'Login_user' }); // unified
    const serializedData = $.param(formData);

    $.ajax({
      type: "POST",
      url: "controller/end-points/controller.php",
      data: serializedData,
      dataType: 'json',
      success: function (response) {
        if (response.status === "success") {
          alertify.success('Login Successful');
          
          const position = response.position;

          setTimeout(() => {
            const routes = {
              admin: "view/item",
              employee: "view/item"
            };
            window.location.href = routes[position] || "view/item";
          }, 1000);

        } else {
          $('#spinner').hide();
          $('#btnLogin').prop('disabled', false);
          alertify.error(response.message);
        }
      },
      error: function () {
        $('#spinner').hide();
        $('#btnLogin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });
});
