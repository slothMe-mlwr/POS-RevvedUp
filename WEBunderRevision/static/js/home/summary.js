$(document).ready(function () {

    // ✅ Helper Function: Convert 24-hour time to 12-hour format
    function formatTimeTo12Hour(time) {
        if (!time) return "";
        const [hour, minute] = time.split(":").map(Number);
        const suffix = hour >= 12 ? "PM" : "AM";
        const hour12 = hour % 12 || 12;
        return `${hour12}:${minute.toString().padStart(2, "0")} ${suffix}`;
    }

    // Fetch appointments
    function fetchAppointments() {
        if ($('#searchInput').is(':focus')) return;

        $.ajax({
            url: "../controller/end-points/controller.php",
            method: "GET",
            data: { requestType: "fetch_appointment" },
            dataType: "json",
            success: function (res) {
                const tbody = $('#appointmentTableBody');
                tbody.empty();

                if (res.status === 200 && res.data.length > 0) {
                    res.data.forEach(data => {
                        let statusColor = '';
                        if (data.status === "pending") statusColor = 'bg-yellow-500';
                        else if (data.status === "completed") statusColor = 'bg-green-600';
                        else if (data.status === "approved") statusColor = 'bg-blue-600';
                        else if (data.status === "expired") statusColor = 'bg-gray-400'; // new color for expired
                        else statusColor = 'bg-red-600';

                        const disabled = (data.status !== "pending") ? "disabled cursor-not-allowed opacity-50" : "";

                        // ✅ Format time before displaying
                        const formattedTime = formatTimeTo12Hour(data.appointmentTime);

                        tbody.append(`
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 font-medium text-gray-700">${data.reference_number}</td>
                                <td class="px-4 py-2 text-gray-600">${data.appointmentDate} ${formattedTime}</td>
                                <td class="px-4 py-2 text-gray-600">${data.city} ${data.street}</td>
                                <td class="px-4 py-2">
                                    <span class="capitalize px-2 py-1 rounded-full text-white text-xs ${statusColor}">
                                        ${data.status}
                                    </span>
                                </td>
                                <td class="px-4 py-2 flex justify-center gap-2">
                                    <button class="seeDetailsBtn cursor-pointer bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
                                        data-id='${data.appointment_id}'
                                        data-reference='${data.reference_number}'
                                        data-fullname='${data.fullname}'
                                        data-contact='${data.contact}'
                                        data-service='${data.service}'
                                        data-date='${data.appointmentDate}'
                                        data-time='${formattedTime}'
                                        data-emergency='${data.emergency}'
                                        data-city='${data.city}'
                                        data-street='${data.street}'
                                        data-status='${data.status}'
                                        data-employee='${data.employee_name ?? ""}'
                                        data-other='${data.problem_description ?? ""}'>
                                        <span class="material-icons text-sm align-middle">visibility</span> See Details
                                    </button>
                                    <button class="cancelBtn cursor-pointer bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ${disabled}"
                                        data-appointment_id='${data.appointment_id}' ${data.status !== "pending" ? "disabled" : ""}>
                                        <span class="material-icons text-sm align-middle">cancel</span> Cancel
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append(`
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400 italic">
                                No record found
                            </td>
                        </tr>
                    `);
                }
            }
        });
    }

    // Initial fetch
    fetchAppointments();
    setInterval(fetchAppointments, 2000);

    // Search filter
    $('#searchInput').on('input', function () {
        const term = $(this).val().toLowerCase();
        $('#appointmentTableBody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(term));
        });
    });

    // Show modal on See Details click
    $(document).on('click', '.seeDetailsBtn', function () {
        const btn = $(this);

        // Handle null or empty values safely
        const employee = (btn.data('employee') && btn.data('employee').trim() !== "") ? btn.data('employee') : "None";
        const otherDescription = (btn.data('other') && btn.data('other').trim() !== "") ? btn.data('other') : "None";
        const service = (btn.data('service') && btn.data('service').trim() !== "") ? btn.data('service') : "None";

        const content = `
            <p><strong>Reference:</strong> ${btn.data('reference')}</p>
            <p><strong>Customer:</strong> ${btn.data('fullname')}</p>
            <p><strong>Contact:</strong> ${btn.data('contact')}</p>
            <p><strong>Service:</strong> ${service}</p>
            <p><strong>Date & Time:</strong> ${btn.data('date')} ${btn.data('time')}</p>
            <p><strong>Emergency:</strong> ${btn.data('emergency') == "1" ? "Yes" : "No"}</p>
            <p><strong>Status:</strong> ${btn.data('status')}</p>
            <p><strong>Employee:</strong> ${employee}</p>
            <p><strong>Address:</strong> ${btn.data('city')} ${btn.data('street')}</p>
            <p><strong>Other Description:</strong> ${otherDescription}</p>
        `;

        $('#modalContent').html(content);
        $('#detailsModal').removeClass('opacity-0 pointer-events-none');
    });

    // Close modal
    $('#closeModal, #detailsModal').click(function (e) {
        if (e.target.id === 'detailsModal' || e.target.id === 'closeModal') {
            $('#detailsModal').addClass('opacity-0 pointer-events-none');
        }
    });

    // Cancel appointment
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

                            setTimeout(() => {
                                location.reload();
                            }, 1000);
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
