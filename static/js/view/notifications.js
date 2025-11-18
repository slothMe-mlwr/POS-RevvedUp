$(document).ready(function () {
    // 🔹 Fetch notifications
    function fetchNotifications() {
        $.ajax({
            url: "../controller/end-points/controller.php",
            method: "GET",
            data: { requestType: "fetch_notifications" },
            dataType: "json",
            success: function (res) {
                const tbody = $('#notificationTableBody');
                tbody.empty();

                if (res.status === 200 && res.data.length > 0) {
                    const notifIds = []; // store IDs to mark as seen

                    res.data.forEach(data => {
                        notifIds.push(data.notif_id);

                        // Determine background based on read/unread
                        const bgClass = data.status === "unread" 
                            ? "bg-yellow-50" 
                            : "bg-white";

                        // Format timestamp
                        const date = new Date(data.created_at);
                        const formattedDate = date.toLocaleString();

                        tbody.append(`
                            <tr class="border-b hover:bg-gray-100 transition-colors ${bgClass}">
                                <td class="px-4 py-2 font-medium text-gray-800">${data.prod_name || "Unknown"}</td>
                                <td class="px-4 py-2 text-gray-600">${data.message}</td>
                                <td class="px-4 py-2 text-gray-500 text-sm">${formattedDate}</td>
                                <td class="px-4 py-2 text-center">
                                    <button class="seeDetailsBtn cursor-pointer bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
                                        data-id="${data.notif_id}"
                                        data-prod="${data.prod_name}"
                                        data-message="${data.message}"
                                        data-date="${formattedDate}">
                                        <span class="material-icons text-sm align-middle">visibility</span> View
                                    </button>
                                </td>
                            </tr>
                        `);
                    });

                    // ✅ Mark notifications as seen
                    markAsSeen(notifIds);
                } else {
                    tbody.append(`
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-400 italic">
                                No restock notifications found
                            </td>
                        </tr>
                    `);
                }
            },
            error: function () {
                $('#notificationTableBody').html(`
                    <tr>
                        <td colspan="4" class="p-4 text-center text-red-500 italic">
                            Failed to fetch notifications. Please refresh.
                        </td>
                    </tr>
                `);
            }
        });
    }

    // 🔹 Mark as seen (POST)
    function markAsSeen(ids) {
        if (ids.length === 0) return;
        $.ajax({
            url: "../controller/end-points/controller.php",
            method: "POST",
            data: { 
                requestType: "mark_seen_notifications",
                notifIds: ids
            },
            success: function (res) {
                console.log("Notifications marked as seen:", res);
            }
        });
    }

    // 🔹 Initial fetch
    fetchNotifications();

    // 🔹 Search filter
    $('#searchInput').on('input', function () {
        const term = $(this).val().toLowerCase();
        $('#notificationTableBody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(term));
        });
    });

    // 🔹 Show modal for notification details
    $(document).on('click', '.seeDetailsBtn', function () {
        const btn = $(this);
        const content = `
            <p><strong>Product:</strong> ${btn.data('prod')}</p>
            <p><strong>Message:</strong> ${btn.data('message')}</p>
            <p><strong>Date:</strong> ${btn.data('date')}</p>
        `;
        $('#modalContent').html(content);
        $('#detailsModal').removeClass('opacity-0 pointer-events-none');
    });

    // 🔹 Close modal
    $('#closeModal, #detailsModal').click(function (e) {
        if (e.target.id === 'detailsModal' || e.target.id === 'closeModal') {
            $('#detailsModal').addClass('opacity-0 pointer-events-none');
        }
    });
});
