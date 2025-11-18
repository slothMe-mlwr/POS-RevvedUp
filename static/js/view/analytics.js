var currentScope = "weekly";
var currentView = "sales";
var chart;

// Initialize ApexChart
function initChart() {
    var options = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        series: [{ name: 'Product Sales', data: [] }],
        xaxis: { categories: [] },
        colors: ['#9ca3af'],
        plotOptions: {
            bar: { columnWidth: '50%', borderRadius: 5 }
        },
        dataLabels: { enabled: false },
        grid: { borderColor: '#e5e7eb' }
    };
    chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();
}

// Render weekly/monthly buttons dynamically
function renderTimeButtons(data) {
    let html = '<option value="">-- Select Week/Month --</option>';
    data.forEach(d => {
        html += `<option value="${d.label}">${d.label}</option>`;
    });
    $("#timeSelect").html(html);

    // Handle selection
    $("#timeSelect").off("change").on("change", function () {
        const label = $(this).val();
        if (label) {
            loadAnalytics(currentScope, currentView, label);
        }
    });
}


function loadAnalytics(scope, view = "sales", filterLabel = null) {
    currentScope = scope;
    currentView = view;
    $("#loader").css("display", "flex");

    $.ajax({
        url: "../controller/end-points/controller.php",
        method: "GET",
        data: { requestType: "fetch_analytics", scope: scope },
        dataType: "json",
        success: function (res) {
            if (!res || res.status !== 200 || !Array.isArray(res.data) || res.data.length === 0) {
                chart.updateOptions({
                    xaxis: { categories: ['Empty Record'] },
                    colors: ['#9ca3af']
                });
                chart.updateSeries([{ name: 'Product Sales', data: [0] }]);
                $("#infoLabel1").text("Product Sales");
                $("#infoValue1").text("₱ 0.00");
                $("#infoBox2").addClass("hidden");
                return;
            }

            let data = res.data;
            if (filterLabel) {
                data = data.filter(d => d.label === filterLabel);
            } else {
                renderTimeButtons(data);
            }

            let labels = data.map(d => d.label ? String(d.label) : 'N/A');
            let sales = data.map(d => isFinite(Number(d.total_sales)) ? Number(d.total_sales) : 0);
            let capital = data.map(d => isFinite(Number(d.capital_total)) ? Number(d.capital_total) : 0);
            let revenue = data.map(d => isFinite(Number(d.revenue)) ? Number(d.revenue) : 0);
            let serviceSales = data.map(d => isFinite(Number(d.service_sales)) ? Number(d.service_sales) : 0);

            if (labels.length === 0) labels = ['N/A'];
            if (sales.length === 0) sales = [0];
            if (capital.length === 0) capital = [0];
            if (revenue.length === 0) revenue = [0];
            if (serviceSales.length === 0) serviceSales = [0];

            if (view === "revenue") {
                $("#chartTitle").html("2025<br>Total Sales, Capital, & Revenue");
                $("#btnBackToSales").removeClass("hidden");
                chart.updateOptions({
                    xaxis: { categories: labels },
                    colors: ['#9ca3af', '#991b1b', '#3a3a3aff']
                });
                chart.updateSeries([
                    { name: 'Total Sales', data: sales },
                    { name: 'Capital', data: capital },
                    { name: 'Revenue', data: revenue },
                ]);
                $("#infoLabel1").text("Total Sales");
                $("#infoValue1").text("₱ " + sales.reduce((a, b) => a + b, 0).toLocaleString());
                $("#infoBox2").removeClass("hidden");
                $("#infoLabel2").text("Revenue");
                $("#infoValue2").text("₱ " + revenue.reduce((a, b) => a + b, 0).toLocaleString());
            } else {
                $("#chartTitle").html("2025<br>Product Sales");
                $("#btnBackToSales").addClass("hidden");
                chart.updateOptions({
                    xaxis: { categories: labels },
                    colors: ['#9ca3af']
                });
                chart.updateSeries([{ name: 'Product Sales', data: sales }]);
                $("#infoLabel1").text("Product Sales");
                $("#infoValue1").text("₱ " + sales.reduce((a, b) => a + b, 0).toLocaleString());
                $("#infoBox2").addClass("hidden");
            }
        },
        error: function (err) {
            console.error(err);
            chart.updateSeries([{ name: 'Product Sales', data: [0] }]);
            chart.updateOptions({ xaxis: { categories: ['N/A'] }, colors: ['#9ca3af'] });
            $("#infoValue1").text("₱ 0.00");
            $("#infoValue2").text("₱ 0.00");
            $("#timeButtons").html('');
        },
        complete: function () {
            $("#loader").css("display", "none");
        }
    });
}

// Button bindings
$("#weeklyBtn").click(() => {
    loadAnalytics("weekly", currentView);
    $("#weeklyBtn").removeClass("bg-gray-200 text-gray-700 border-gray-400")
        .addClass("bg-red-800 text-white border-red-800");
    $("#monthlyBtn").removeClass("bg-red-800 text-white border-red-800")
        .addClass("bg-gray-200 text-gray-700 border-gray-400");
});

$("#monthlyBtn").click(() => {
    loadAnalytics("monthly", currentView);
    $("#monthlyBtn").removeClass("bg-gray-200 text-gray-700 border-gray-400")
        .addClass("bg-red-800 text-white border-red-800");
    $("#weeklyBtn").removeClass("bg-red-800 text-white border-red-800")
        .addClass("bg-gray-200 text-gray-700 border-gray-400");
});

$("#revenueBtn").click(() => loadAnalytics(currentScope, "revenue"));
$("#btnBackToSales").click(() => loadAnalytics(currentScope, "sales"));

// Init
$(document).ready(() => {
    initChart();
    loadAnalytics("weekly", "sales");
});

// PRINT REPORT
$("#printBtn").click(() => {
    let labels = chart.w.globals.labels || [];
    let seriesData = chart.w.globals.series || [];

    let printHtml = `
    <html>
    <head>
        <title>Sales Report</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            h2 { color: #b91c1c; }
            table { border-collapse: collapse; width: 100%; margin-top: 20px; }
            th, td { border: 1px solid #333; padding: 8px; text-align: center; }
            th { background-color: #f87171; color: #fff; }
        </style>
    </head>
    <body>
        <h2>${$("#chartTitle").text()}</h2>
        <table>
            <thead>
                <tr>
                    <th>Time</th>`;
    chart.w.config.series.forEach(s => {
        printHtml += `<th>${s.name}</th>`;
    });
    printHtml += `</tr></thead><tbody>`;
    labels.forEach((label, i) => {
        printHtml += `<tr><td>${label}</td>`;
        seriesData.forEach(series => {
            printHtml += `<td>${series[i]}</td>`;
        });
        printHtml += `</tr>`;
    });
    printHtml += `</tbody></table>
    

    <br>
    <br>
    <br>
                        ____________________<br>
                         Name & Signature
    
    </body></html>`;

    let printWindow = window.open('', '', 'width=900,height=600');
    printWindow.document.write(printHtml);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
});
