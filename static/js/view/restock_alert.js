
$(document).ready(function() {


  function fetchRestockAlerts() {
    $.ajax({
      url: "../controller/end-points/controller.php",
      method: "GET",
      data: { requestType: "fetch_restock_alerts" },
      dataType: "json",
      success: function(response) {
        const tableBody = $("#restockTableBody");
        tableBody.empty();

        if (response.status === 200 && response.data.length > 0) {
            const notifID = []; 

              response.data.forEach(alert => {
              notifID.push(alert.notif_id);

              // Determine text color based on movement
              let colorClass = "text-gray-700"; // default
              if (alert.movement === "Fast moving") colorClass = "text-red-600";
              else if (alert.movement === "Slow moving") colorClass = "text-yellow-300";

              tableBody.append(`
                <tr>
                  <td class="px-6 py-3 text-gray-700">${alert.prod_name}</td>
                  <td class="px-6 py-3 text-gray-700">${alert.prod_qty}</td>
                  <td class="px-6 py-3 text-gray-700">${alert.movement}</td>
                  <td class="px-6 py-3 ${colorClass} font-semibold">${alert.alert_message}</td>
                </tr>
              `);
            });

          mark_as_seen(notifID);
        } else {
           tableBody.append(`
              <tr>
                <td colspan="4" class="text-center py-4 text-gray-500">
                  No restock alerts.
                </td>
              </tr>
            `);
        }
      },
      error: function(err) {
        console.error("Error fetching alerts:", err);
      }
    });
  }

  function mark_as_seen(ids) {
    if (ids.length === 0) return;

    $.ajax({
        url: "../controller/end-points/controller.php",
        method: "POST",
        data: { 
            requestType: "mark_as_seen",
            notifID: ids 
        },
        success: function (res) {
            console.log("Appointments marked as seen:", res);
        }
    });

  }

  fetchRestockAlerts();
});
