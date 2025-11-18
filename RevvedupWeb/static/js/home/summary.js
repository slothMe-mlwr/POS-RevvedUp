$(document).ready(function () {
    

    if ($('#paymentModal').length === 0) {
    $('body').append(`
        <div id="paymentModal" class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-md text-center relative">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Payment Information</h2>
                <p class="text-gray-600 mb-4 text-sm">
                    ⚠️ <strong>Important:</strong> Please only send a downpayment after confirming with our staff.<br>
                These QR codes are for agreed downpayments only between the customer and the store..
                </p>

                <div id="paymentOptions" class="space-x-4 mb-6">
                    <button id="gcashBtn" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">GCash</button>
                    <button id="mayaBtn" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg">Maya</button>
                </div>

                <div id="gcashQR" class="hidden">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">GCash</h3>
                    <img src="gcash.jfif" alt="GCash QR" class="mx-auto w-48 h-48 object-contain border rounded-lg">
                </div>

                <div id="mayaQR" class="hidden">
                    <h3 class="text-lg font-semibold text-green-700 mb-2">Maya</h3>
                    <img src="maya.jfif" alt="Maya QR" class="mx-auto w-48 h-48 object-contain border-2 border-green-500 rounded-lg">
                </div>

                <button id="closePaymentModal" class="mt-6 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg">Close</button>
            </div>
        </div>
    `);
}



    // ==========================
    // Fully Booked Dates Logic (with Flatpickr)
    // ==========================
    function initializeDatePicker() {
        const dateInput = document.getElementById('appointmentDate');

        $.ajax({
            url: 'controller.php',
            type: 'POST',
            data: { action: 'getFullyBookedDates' },
            dataType: 'json',
            success: function (fullyBookedDates) {
                flatpickr(dateInput, {
                    minDate: "today",
                    dateFormat: "Y-m-d",
                    disable: fullyBookedDates,
                    onChange: function (selectedDates, dateStr) {
                        if (fullyBookedDates.includes(dateStr)) {
                            alert('❌ This date is fully booked. Please select another date.');
                            dateInput._flatpickr.clear();
                        } else {
                            const now = new Date();
                            let minHour = 8; // default first hour
                            if (selectedDates[0].toDateString() === now.toDateString()) {
                                minHour = now.getHours() + 1; // disable past hours completely
                            }
                            populateTimes(minHour);
                        }
                    }
                });
            },
            error: function () {
                console.error('❌ Failed to fetch fully booked dates.');
                flatpickr(dateInput, { minDate: "today", dateFormat: "Y-m-d", onChange: function() { populateTimes(8); } });
            }
        });
    }

    // Call this on modal open
    $(document).on('click', '.book-btn, #openRepairModal', function () {
        $('#repairModal').removeClass('opacity-0 pointer-events-none');
        initializeDatePicker();
        populateTimes();
    });

    // ==========================
    // Repair Modal Logic
    // ==========================
    $('#otherServiceCheckbox').change(function () {
        const isChecked = $(this).is(':checked');
        $('#otherServiceWrapper').toggle(isChecked);
        $('#otherServiceInput').prop('required', isChecked);
    });

    $('#specificMechanic').change(function () {
        const isChecked = $(this).is(':checked');
        $('#employeeWrapper').toggle(isChecked);
        $('#employee').prop('required', isChecked);
        //populateTimes();
    });

    $('#contact').on('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 11);
    });

    function getLocalDateString() {
        const now = new Date();
        return `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
    }
    $('#appointmentDate').attr('min', getLocalDateString());

    function formatAMPM(hour) {
        let suffix = hour >= 12 ? 'PM' : 'AM';
        let h = hour % 12;
        h = h ? h : 12;
        return `${h}:00 ${suffix}`;
    }

    // ==========================
    // Updated populateTimes Function (with gray out fully booked)
    // ==========================
    function populateTimes(minHour = 8) {
        const timeSelect = $('#appointmentTime');
        timeSelect.empty();

        const selectedDate = $('#appointmentDate').val();
        if (!selectedDate) return;

        const empId = $('#employee').val();

        $.ajax({
            url: 'controller.php',
            type: 'POST',
            data: { action: 'getBookingStatus', appointmentDate: selectedDate },
            dataType: 'json',
            success: function (data) {
                const now = new Date();
                const selectedDay = new Date(selectedDate);

                for (let h = 8; h <= 18; h++) {
                    const display = formatAMPM(h); // AM/PM format
                    const value = `${h}:00`;
                    let disabled = false;
                    let reason = '';

                    // Fully booked
                    if (data[value] && data[value].total >= 3) {
                        disabled = true;
                        reason = ' (Full)';
                    }

                    // Employee booked
                    if (empId && data[value] && data[value].employees.includes(parseInt(empId))) {
                        disabled = true;
                        reason = ' (Booked)';
                    }

                    // Past time (disable all hours before minHour)
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

                if (timeSelect.hasClass("select2-hidden-accessible")) {
                    timeSelect.select2('destroy');
                }

                timeSelect.select2({
                    placeholder: 'Select Time',
                    dropdownParent: $('#repairModal'),
                    width: '100%',
                    templateResult: function (data) {
                        if (!data.id) return data.text;
                        var $result = $('<span></span>').text(data.text);

                        // Gray out fully booked, past, or employee booked
                        if ($(data.element).prop('disabled')) {
                            $result.css({ color: '#999', 'pointer-events': 'none', opacity: 0.6 });
                        }
                        return $result;
                    },
                    templateSelection: function (data) {
                        return data.text;
                    },
                    allowClear: true
                });
            },
            error: function () {
                console.error('❌ Failed to load booking status — showing default times.');
                for (let h = 8; h <= 18; h++) {
                    const display = formatAMPM(h);
                    const value = `${h}:00`;
                    timeSelect.append(`<option value="${value}">${display}</option>`);
                }
            }
        });
    }

    $('#close-repair').click(function () {
        $('#repairModal').addClass('opacity-0 pointer-events-none');
    });

    // ==========================
    // Summary Table Logic with Pagination (INSIDE TABLE)
    // ==========================
    let currentPage = 1;
    const rowsPerPage = 5;
    let allAppointments = [];

    function renderAppointmentsPage() {
    const tbody = $('#appointmentTableBody');
    tbody.empty();

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedData = allAppointments.slice(start, end);

    const now = new Date();

    if (paginatedData.length === 0) {
        tbody.append(`<tr><td colspan="5" class="p-4 text-center text-gray-400 italic">No record found</td></tr>`);
    } else {
        paginatedData.forEach(data => {
            let statusColor = '';
            if (data.status === "pending") statusColor = 'bg-yellow-500';
            else if (data.status === "completed") statusColor = 'bg-green-600';
            else if (data.status === "approved") statusColor = 'bg-blue-600';
            else statusColor = 'bg-red-600';

            const appointmentDateTime = new Date(`${data.appointmentDate}T${data.appointmentTime}:00`);
            const isPast = appointmentDateTime < now;

            const disabled = data.status !== "pending" || isPast ? "disabled cursor-not-allowed opacity-50" : "";
            const rowOpacity = isPast ? "opacity-60" : "";

            // =======================
            // Render row with data-other included
            // =======================
            tbody.append(`
                <tr class="border-b hover:bg-gray-50 transition-colors ${rowOpacity}">
                    <td class="px-4 py-2 font-medium text-gray-700">${data.reference_number}</td>
                    <td class="px-4 py-2 text-gray-600">${data.appointmentDate} ${data.appointmentTime}</td>
                    <td class="px-4 py-2 text-gray-600">${data.city} ${data.street}</td>
                    <td class="px-4 py-2">
                        <span class="capitalize px-2 py-1 rounded-full text-white text-xs ${statusColor}">
                            ${data.status}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex justify-center gap-2">
                        <button class="seeDetailsBtn bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition pointer-events-auto ${rowOpacity}"
                            data-id='${data.appointment_id}'
                            data-reference='${data.reference_number}'
                            data-fullname='${data.fullname}'
                            data-contact='${data.contact}'
                            data-service='${data.service}'
                            data-other='${data.other_service || ""}'
                            data-date='${data.appointmentDate}'
                            data-time='${data.appointmentTime}'
                            data-city='${data.city}'
                            data-street='${data.street}'
                            data-status='${data.status}'>
                            <span class="material-icons text-sm align-middle">visibility</span> See Details
                        </button>

                    <!-- Cancel Button -->
                    <button class="cancelBtn bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition pointer-events-auto ${disabled}"
                        data-appointment_id='${data.appointment_id}' ${disabled ? "disabled" : ""}>
                        <span class="material-icons text-sm align-middle">cancel</span> Cancel
                    </button>

                    <!-- View Payment Button -->
                    <button class="viewPaymentBtn bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition pointer-events-auto ${rowOpacity}"
                        data-appointment_id='${data.appointment_id}'>
                        <span class="material-icons text-sm align-middle">payments</span> QR Payment Options
                    </button>
                </td>
            </tr>
        `);
            
        });
    }

// Payment modal logic (already works for dynamically generated buttons)
$(document).on('click', '.viewPaymentBtn', function() {
    const appointmentId = $(this).data('appointment_id'); // optional
    $('#paymentModal').removeClass('opacity-0 pointer-events-none');
});

$(document).on('click', '#closePaymentModal', function() {
    $('#paymentModal').addClass('opacity-0 pointer-events-none');
    $('#gcashQR, #mayaQR').addClass('hidden');
    $('#paymentOptions').removeClass('hidden');
});

$(document).on('click', '#gcashBtn', function() {
    $('#paymentOptions').addClass('hidden');
    $('#gcashQR').removeClass('hidden');
});

$(document).on('click', '#mayaBtn', function() {
    $('#paymentOptions').addClass('hidden');
    $('#mayaQR').removeClass('hidden');
});

    // pagination logic remains unchanged
    const totalPages = Math.ceil(allAppointments.length / rowsPerPage);
    if (totalPages > 1) {
        let paginationHTML = `
            <tr>
                <td colspan="5" class="text-center py-3">
                    <div class="inline-flex items-center gap-2 justify-center">
                        <button id="prevPage" class="px-3 py-1 rounded transition 
                            ${currentPage === 1 
                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed' 
                                : 'bg-gray-200 hover:bg-gray-300 text-gray-700'}">
                            Prev
                        </button>`;

        let startPage = Math.max(1, currentPage - 1);
        let endPage = Math.min(totalPages, startPage + 2);
        if (endPage - startPage < 2) startPage = Math.max(1, endPage - 2);

        if (startPage > 1) paginationHTML += `<span class="px-2 text-gray-500">...</span>`;

        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <button class="page-btn px-3 py-1 rounded transition 
                    ${i === currentPage 
                        ? 'bg-blue-500 text-white shadow-sm' 
                        : 'bg-gray-200 hover:bg-gray-300 text-gray-700'}" 
                    data-page="${i}">
                    ${i}
                </button>`;
        }

        if (endPage < totalPages) paginationHTML += `<span class="px-2 text-gray-500">...</span>`;

        paginationHTML += `
                        <button id="nextPage" class="px-3 py-1 rounded transition 
                            ${currentPage === totalPages 
                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed' 
                                : 'bg-gray-200 hover:bg-gray-300 text-gray-700'}">
                            Next
                        </button>
                    </div>
                </td>
            </tr>
        `;

        tbody.append(paginationHTML);
    }

    // Event bindings remain unchanged
    $(document).off('click', '#prevPage').on('click', '#prevPage', function () {
        if (currentPage > 1) {
            currentPage--;
            renderAppointmentsPage();
        }
    });

    $(document).off('click', '#nextPage').on('click', '#nextPage', function () {
        if (currentPage < totalPages) {
            currentPage++;
            renderAppointmentsPage();
        }
    });

    $(document).off('click', '.page-btn').on('click', '.page-btn', function () {
        currentPage = parseInt($(this).data('page'));
        renderAppointmentsPage();
    });
}

    function fetchAppointments() {
        if ($('#searchInput').is(':focus')) return;

        $.ajax({
            url: "../controller/end-points/controller.php",
            method: "GET",
            data: { requestType: "fetch_appointment" },
            dataType: "json",
            success: function (res) {
                if (res.status === 200 && res.data.length > 0) {
                    allAppointments = res.data;
                    renderAppointmentsPage();
                } else {
                    $('#appointmentTableBody').html(`
                        <tr><td colspan="5" class="p-4 text-center text-gray-400 italic">No record found</td></tr>
                    `);
                }
            }
        });
    }

    fetchAppointments();
    setInterval(fetchAppointments, 2000);

    $('#searchInput').on('input', function () {
        const term = $(this).val().toLowerCase();
        $('#appointmentTableBody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(term));
        });
    });

$(document).off('click', '.seeDetailsBtn').on('click', '.seeDetailsBtn', function () {
    const btn = $(this);

    // Get service string and split into array
    let services = (btn.data('service') || "").split(',').map(s => s.trim());

    // Get typed 'Other' service
    const otherText = (btn.data('other') || "").trim();

    // Replace any occurrence of "Other" (case-insensitive, with spaces) with typed value
    services = services.map(s => {
        if (s.toLowerCase() === 'other' && otherText) {
            return otherText;
        }
        return s;
    });

    // Join back into a string
    const serviceText = services.join(', ');

    // Build modal content
    const content = `
        <p><strong>Reference:</strong> ${btn.data('reference')}</p>
        <p><strong>Customer:</strong> ${btn.data('fullname')}</p>
        <p><strong>Contact:</strong> ${btn.data('contact')}</p>
        <p><strong>Service:</strong> ${serviceText}</p>
        <p><strong>Date & Time:</strong> ${btn.data('date')} ${btn.data('time')}</p>
        <p><strong>Status:</strong> ${btn.data('status')}</p>
        <p><strong>Address:</strong> ${btn.data('city')} ${btn.data('street')}</p>
    `;

    $('#modalContent').html(content);
    $('#detailsModal').removeClass('opacity-0 pointer-events-none');

    console.log("Displayed Service:", serviceText); // verify
});



    $('#closeModal, #detailsModal').click(function (e) {
        if (e.target.id === 'detailsModal' || e.target.id === 'closeModal') {
            $('#detailsModal').addClass('opacity-0 pointer-events-none');
        }
    });

    $(document).on('click', '.cancelBtn', function () {
        const appointmentId = $(this).data('appointment_id');

        Swal.fire({
            title: 'Cancel Appointment',
            text: "Are you sure you want to cancel this appointment?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../controller/end-points/controller.php",
                    method: "POST",
                    data: { requestType: "cancel_appointment", appointment_id: appointmentId },
                    dataType: "json",
                    success: function (res) {
                        if (res.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Canceled!',
                                text: res.message,
                                timer: 1000,
                                showConfirmButton: false
                            });
                            fetchAppointments();
                            if (!$('#repairModal').hasClass('opacity-0')) populateTimes();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: res.message || "Failed to cancel appointment. Please try again."
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: "An error occurred. Please try again."
                        });
                    }
                });
            }
        });
    });
});