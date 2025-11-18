$(document).ready(function () {

    // Fetch the trivia of the day
    $.ajax({
        url: "controller/end-points/controller.php",
        method: "GET",
        data: { requestType: "get_trivia" },
        dataType: "json",
        success: function (response) {
            if (response.data) {
                $("#triviaText").text(response.data).addClass("opacity-100");
            } else {
                $("#triviaText").text("No trivia available today.").addClass("opacity-100");
            }
        },
        error: function () {
            $("#triviaText").text("Unable to load today's trivia.").addClass("opacity-100");
        }
    });

});
