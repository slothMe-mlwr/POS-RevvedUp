$(document).ready(function () {

    // --- DATE SORT ADDED: Listen for sort dropdown ---
    $('#dateSort').on('change', function () {
        const sortType = $(this).val();
        const statusFilter = $('#statusFilter').val();
        fetchAppointments(sortType, statusFilter);
    });

    // --- STATUS FILTER ADDED: Listen for status dropdown ---
    $('#statusFilter').on('change', function () {
        const statusFilter = $(this).val();
        const sortType = $('#dateSort').val();
        fetchAppointments(sortType, statusFilter);
    });

    // Fetch appointments
    function fetchAppointments(sortType = "upcoming", statusFilter = "all") {
        $.ajax({
            url: "../controller/end-points/controller.php",
            method: "GET",
            data: { requestType: "fetch_appointment" },
            dataType: "json",
            success: function (res) {
                const tbody = $('#appointmentTableBody');
                tbody.empty();

                if (res.status === 200 && res.data && res.data.length > 0) {

                    const today = new Date();
                    let filteredData = res.data.slice(); // clone

                    // --- STATUS FILTER ADDED ---
                    if (statusFilter && statusFilter !== "all") {
                        // exact match against your enum values (use lower-case for safety)
                        filteredData = filteredData.filter(a => (a.status || "").toLowerCase() === statusFilter.toLowerCase());
                    }

                    // --- DATE SORT ADDED: Filter and sort upcoming first ---
                    if (sortType === "upcoming") {
                        filteredData = filteredData.filter(a => {
                            const appointmentDateTime = new Date((a.appointmentDate || "") + " " + (a.appointmentTime || ""));
                            return appointmentDateTime >= today;
                        });
                        filteredData.sort((a, b) => {
                            const dateA = new Date((a.appointmentDate || "") + " " + (a.appointmentTime || ""));
                            const dateB = new Date((b.appointmentDate || "") + " " + (b.appointmentTime || ""));
                            return dateA - dateB;
                        });
                    }

                    const appointmentIds = [];

                    filteredData.forEach(data => {
                        appointmentIds.push(data.appointment_id);

                        const statusLower = (data.status || '').toLowerCase();
                        let statusColor = '';
                        if (statusLower === "pending") statusColor = 'bg-yellow-500';
                        else if (statusLower === "request canceled") statusColor = 'bg-orange-500';
                        else if (statusLower === "canceled") statusColor = 'bg-red-600';
                        else if (statusLower === "approved") statusColor = 'bg-blue-600';
                        else if (statusLower === "expired") statusColor = 'bg-gray-400';
                        else statusColor = 'bg-gray-500';

                        // determine if actions should be disabled
                        const actionsEnabled = (statusLower === "pending" || statusLower === "request canceled");
                        const disabledAttr = actionsEnabled ? '' : 'disabled';
                        const disabledClass = actionsEnabled ? '' : 'cursor-not-allowed opacity-50';

                        const cancelBtn = `<button type="button" class="cancelBtn bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ${disabledClass}"
                                                    data-appointment_id="${data.appointment_id}" ${disabledAttr}>
                                                    <span class="material-icons text-sm align-middle">cancel</span> Cancel
                                                </button>`;

                        const approveBtn = `<button type="button" class="approveBtn bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition ${disabledClass}"
                                                    data-appointment_id="${data.appointment_id}" ${disabledAttr}>
                                                    <span class="material-icons text-sm align-middle">check_circle</span> Approve
                                                </button>`;

                        $('#appointmentTableBody').append(`
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 font-medium text-gray-700">${data.reference_number || ''}</td>
                                <td class="px-4 py-2 text-gray-600">${data.appointmentDate || ''} ${data.appointmentTime || ''}</td>
                                <td class="px-4 py-2 text-gray-600">${data.city || ''} ${data.street || ''}</td>
                                <td class="px-4 py-2">
                                    <span class="capitalize px-2 py-1 rounded-full text-white text-xs ${statusColor}">
                                        ${data.status || ''}
                                    </span>
                                </td>
                                <td class="px-4 py-2 flex justify-center gap-2">
                                    <button 
                                        type="button"
                                        class="seeDetailsBtn bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
                                        data-id='${data.appointment_id}'
                                        data-reference='${(data.reference_number||"")}'
                                        data-fullname='${(data.fullname||"")}'
                                        data-contact='${(data.contact||"")}'
                                        data-service='${(data.service||"")}'
                                        data-date='${(data.appointmentDate||"")}'
                                        data-time='${(data.appointmentTime||"")}'
                                        data-emergency='${(data.emergency||"0")}'
                                        data-city='${(data.city||"")}'
                                        data-street='${(data.street||"")}'
                                        data-status='${(data.status||"")}'
                                        data-employee='${(data.employee_name || "")}'>
                                        <span class="material-icons text-sm align-middle">visibility</span> See Details
                                    </button>
                                    ${cancelBtn}
                                    ${approveBtn}
                                </td>
                            </tr>
                        `);
                    });

                    if (appointmentIds.length > 0) markAsSeen(appointmentIds);

                    if (filteredData.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-400 italic">
                                    No appointments found
                                </td>
                            </tr>
                        `);
                    }

                } else {
                    tbody.append(`
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400 italic">
                                No record found
                            </td>
                        </tr>
                    `);
                }
            },
            error: function (xhr, status, err) {
                console.error("Failed to fetch appointments:", status, err);
                $('#appointmentTableBody').html(`
                    <tr>
                        <td colspan="5" class="p-4 text-center text-red-500 italic">
                            Failed to load appointments
                        </td>
                    </tr>
                `);
            }
        });
    }

    function markAsSeen(ids) {
        if (!ids || ids.length === 0) return;

        $.ajax({
            url: "../controller/end-points/controller.php",
            method: "POST",
            data: {
                requestType: "mark_seen",
                appointmentIds: ids
            },
            success: function (res) {
                console.log("Appointments marked as seen:", res);
            }
        });
    }

    // Initial fetch
    fetchAppointments();

    // Search filter
    $('#searchInput').on('input', function () {
        const term = $(this).val().toLowerCase();
        $('#appointmentTableBody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(term));
        });
    });

    // --- Delegated handler: See Details ---
    $(document).on('click', '.seeDetailsBtn', function () {
        const btn = $(this);
        const employee = btn.data('employee') || "None";
        const content = `
            <p><strong>Reference:</strong> ${btn.data('reference')}</p>
            <p><strong>Customer:</strong> ${btn.data('fullname')}</p>
            <p><strong>Contact:</strong> ${btn.data('contact')}</p>
            <p><strong>Service:</strong> ${btn.data('service')}</p>
            <p><strong>Date & Time:</strong> ${btn.data('date')} ${btn.data('time')}</p>
            <p><strong>Emergency:</strong> ${btn.data('emergency') == "1" ? "Yes" : "No"}</p>
            <p><strong>Status:</strong> ${btn.data('status')}</p>
            <p><strong>Employee:</strong> ${employee}</p>
            <p><strong>Address:</strong> ${btn.data('city')} ${btn.data('street')}</p>
        `;
        $('#modalContent').html(content);
        $('#detailsModal').removeClass('opacity-0 pointer-events-none');
    });

    // Close modal (click outside or X)
    $('#closeModal, #detailsModal').click(function (e) {
        if (e.target.id === 'detailsModal' || e.target.id === 'closeModal') {
            $('#detailsModal').addClass('opacity-0 pointer-events-none');
        }
    });

    // --- Delegated handler: Cancel appointment ---
    $(document).on('click', '.cancelBtn', function () {
        const $btn = $(this);
        if ($btn.is(':disabled')) return; // guard

        const appointmentId = $btn.data('appointment_id');

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
                        if (res.status === "success" || res.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Canceled!',
                                text: res.message || "Appointment canceled.",
                                timer: 1000,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                fetchAppointments($('#dateSort').val(), $('#statusFilter').val());
                            }, 900);
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

    // --- Delegated handler: Approve appointment ---
    $(document).on('click', '.approveBtn', function () {
        const $btn = $(this);
        if ($btn.is(':disabled')) return; // guard

        const appointmentId = $btn.data('appointment_id');

        Swal.fire({
            title: 'Approve Appointment',
            text: "Are you sure you want to approve this appointment?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../controller/end-points/controller.php",
                    method: "POST",
                    data: { requestType: "approve_appointment", appointment_id: appointmentId },
                    dataType: "json",
                    success: function (res) {
                        if (res.status === "success" || res.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: res.message || "Appointment approved.",
                                timer: 1000,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                fetchAppointments($('#dateSort').val(), $('#statusFilter').val());
                            }, 900);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: res.message || "Failed to approve appointment."
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
