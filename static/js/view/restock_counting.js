const getRestockAlertCount = () => {
    $.ajax({
        url: "../controller/end-points/controller.php?requestType=getRestockAlertCount",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 200 && response.data) {
                const { UnreadRestockAlertCount } = response.data;
                const $badge = $('.UnreadRestockAlertCount'); // your HTML badge class

                if (UnreadRestockAlertCount > 0) {
                    $badge.text(UnreadRestockAlertCount).fadeIn();
                } else {
                    $badge.fadeOut();
                }
            }
        },
        error: function(err) {
            console.error('Failed to fetch restock alert count', err);
        }
    });

};


// 🔁 Background check for fast-moving low stock items
function autoCheckFastMovingAlerts() {
  $.ajax({
    url: "../controller/end-points/controller.php?requestType=checkFastMovingAlerts",
    type: "GET",
    dataType: "json",
    success: function(response) {
      if (response.status === 200) {
         getRestockAlertCount();
        // optional: console.log("Fast-moving stock check ran successfully");
      }
    },
    error: function(err) {
      console.error("Error running background alert check", err);
    }
  });
}

// Run every 5 minutes (or shorter for testing)
setInterval(autoCheckFastMovingAlerts, 300000); // 300000 ms = 5 min


// Initial fetch
getRestockAlertCount();
autoCheckFastMovingAlerts();

// Optional: auto-refresh every few seconds
setInterval(getRestockAlertCount, 5000);

