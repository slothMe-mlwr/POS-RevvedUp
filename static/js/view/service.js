
$('.serviceNameInput').on('keypress', function(e) {
    if (e.which === 13) { // 13 is the Enter key
        e.preventDefault(); 
        $('#addServiceBtn').click(); 
    }
});

$("#addServiceBtn").click(function (e) { 
    e.preventDefault();


    $('.titleAction').text('Add Service');

    const serviceNameInput = $('.serviceNameInput').val();
    $("#serviceName").val(serviceNameInput);

        // FETCH All employee
    $.ajax({
    url: "../controller/end-points/controller.php",
    method: "GET",
    data: { requestType: "fetch_all_employee" },
    dataType: "json",
    success: function (res) {
        if (res.status === 200) {
            const defaultId = res.default_user_id; 
            const position = res.position; 

            $('#employee').empty();

            // placeholder option
            $('#employee').append(`<option value="" disabled>Select Employee</option>`);

            if (res.data.length > 0) {
                if (position === "admin") {
                    // ADMIN → show all employees
                    res.data.forEach(emp => {
                        $('#employee').append(`
                            <option value="${emp.user_id}">
                                ${emp.nickname}
                            </option>
                        `);
                    });

                    if (defaultId) {
                        $('#employee').val(defaultId); // select logged-in user by default
                    }
                } else {
                    // EMPLOYEE → show only his/her own record
                    const emp = res.data.find(e => e.user_id == defaultId);
                    if (emp) {
                        $('#employee').append(`
                            <option value="${emp.user_id}" selected>
                         ${emp.nickname}
                            </option>
                        `);
                    }
                }
            } else {
                $('#employee').append(`<option disabled>No employees found</option>`);
            }
        }
    }
});



    $("#addServiceModal").fadeIn();
});

// === LIVE SEARCH SERVICES ===
$('.serviceNameInput').on('input', function() {
    const query = $(this).val().trim();
    const dropdown = $('.serviceDropdown');

    if (query.length < 1) {
        dropdown.hide();
        return;
    }

    $.ajax({
        url: "../controller/end-points/controller.php",
        method: "GET",
        data: { requestType: "fetch_all_service" },
        dataType: "json",
        success: function(res) {
            if (res.status === 200 && res.data.length > 0) {
                const matches = res.data.filter(s => 
                    s.service_name.toLowerCase().includes(query.toLowerCase())
                );

                if (matches.length > 0) {
                    let list = '';
                    matches.forEach(s => {
                        list += `
                            <div class="service-option px-3 py-2 hover:bg-gray-100 cursor-pointer"
                                 data-id="${s.service_id}"
                                 data-name="${s.service_name}"
                                 data-price="${s.service_price}">
                                ${s.service_name} - ₱${s.service_price}
                            </div>`;
                    });
                    dropdown.html(list).show();
                } else {
                    dropdown.html(`<div class="px-3 py-2 text-gray-500 italic">No results found</div>`).show();
                }
            }
        }
    });
});

// === SELECT SERVICE FROM DROPDOWN ===
$(document).on('click', '.service-option', function() {
    const name = $(this).data('name');
    const price = $(this).data('price');
    $('.serviceNameInput').val(name);
    $('#price').val(price);
    $('.serviceDropdown').hide();

    // Trigger modal opening (same as clicking +)
    $('#addServiceBtn').click();
});

// Hide dropdown when clicking outside
$(document).on('click', function(e) {
    if (!$(e.target).closest('.serviceNameInput, .serviceDropdown').length) {
        $('.serviceDropdown').hide();
    }
});



// Close button
$("#closeAddProductModal").click(function (e) { 
    e.preventDefault();
    $("#addServiceModal").fadeOut();
});

// Close kapag click outside modal-content
$(document).on("click", function (e) {
    if ($(e.target).is("#addServiceModal")) {
        $("#addServiceModal").fadeOut();
    }
});







$('#frmAddService').submit(function(e) {
    e.preventDefault();

    var service_id = $(this).data('editing-id');
    var serviceName = $('#serviceName').val().trim();
    var price = $('#price').val().trim();
    var employee = $('#employee').val().trim();

    if(!serviceName || !price || isNaN(price) || price <= 0 || !employee) {
        alertify.error("Please fill all fields correctly.");
        return;
    }

    var formData = new FormData(this);
    formData.append('requestType', service_id ? 'updateServiceCart' : 'AddServiceCart');
    if(service_id) formData.append('service_id', service_id);

    $.ajax({
        type: "POST",
        url: "../controller/end-points/controller.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response) {
            if(response.status === 200){
                Swal.fire('Success!', response.message, 'success').then(() => {
                    window.location.href = 'service';
                });
            } else {
                Swal.fire('Error', response.message || 'Something went wrong.', 'error');
            }
        }
    });
});
















   $.ajax({
    url: "../controller/end-points/controller.php",
    method: "GET",
    data: { requestType: "fetch_all_service_cart" },
    dataType: "json",
    success: function (res) {
        if (res.status === 200) {

            let html = '';

            if (res.data.length > 0) {
                res.data.forEach((data) => {


                    html += `
                        <tr class="hover:bg-gray-200 transition-colors">
                            <td class="p-3 text-center font-mono">${data.service_name}</td>
                            <td class="p-3 text-center font-semibold">${data.service_price}</td>
                            <td class="p-3 text-center font-semibold">${data.nickname}</td>
                            <td class="p-3 text-center">
                                <button class="EditBtn cursor-pointer bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition"
                                data-service_id='${data.service_id}'>Edit</button>
                                <button class="removeBtn cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition"
                                data-service_id='${data.service_id}'
                                data-service_name='${data.service_name}'
                                >Remove</button>
                            </td>
                        </tr>
                    `;
                });

                $('#serviceTableBody').html(html);

            } else {
                $('#serviceTableBody').html(`
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-400 italic">
                            <span class="material-icons" style="font-size: 48px; display: block; margin-bottom: 8px;">
                                shopping_cart
                            </span>
                            No service found
                        </td>
                    </tr>
                `);
            }
        }
    }
});







$(document).on('click', '.removeBtn', function(e) {
        e.preventDefault();
        const id = $(this).data("service_id");
        const service_name = $(this).data("service_name");
        
        Swal.fire({
            title: `Remove <span style="color:red;">${service_name}</span> from cart?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../controller/end-points/controller.php",
                    type: 'POST',
                    data: { id: id, requestType: 'deleteCart',table:'service_cart',collumn:'service_id' },
                    dataType: 'json', 
                    success: function(response) {
                      console.log(response);
                        if (response.status === 200) {
                            Swal.fire(
                                'Removed!',
                                response.message, 
                                'success'
                            ).then(() => {
                                location.reload(); 
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message, 
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was a problem with the request.',
                            'error'
                        );
                    }
                });
            }
        });
    });










    $(document).on('click', '.EditBtn', function(e) {
    e.preventDefault();

    $('.titleAction').text('Edit Service');

    const service_id = $(this).data('service_id');
   
    

    $.ajax({
        url: "../controller/end-points/controller.php",
        method: "GET",
        data: { requestType: "getServiceById", service_id: service_id },
        dataType: "json",
        success: function(res) {
            if(res.status === 200) {
                const data = res.data;

                // Fill modal inputs
                $('#serviceName').val(data.service_name);
                $('#price').val(data.service_price);
                
                // Populate employees
                $.ajax({
                    url: "../controller/end-points/controller.php",
                    method: "GET",
                    data: { requestType: "fetch_all_employee" },
                    dataType: "json",
                    success: function(empRes) {
                        if(empRes.status === 200) {
                            $('#employee').empty();
                            $('#employee').append(`<option value="" disabled>Select Employee</option>`);
                            empRes.data.forEach(emp => {
                                $('#employee').append(`
                                    <option value="${emp.user_id }" ${emp.user_id  == data.service_employee_id ? 'selected' : ''}>
                                        ${emp.nickname}
                                    </option>
                                `);
                            });

                            // Show modal
                            $('#addServiceModal').fadeIn();

                            // Change form for editing
                            $('#frmAddService').data('editing-id', service_id);
                            $('#frmAddService button[type="submit"]').text('Update Service');
                        }
                    }
                });

            } else {
                Swal.fire('Error', res.message || 'Service not found', 'error');
            }
        }
    });
});






