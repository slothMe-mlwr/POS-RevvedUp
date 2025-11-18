let salesChart = null;
let appointmentChart = null;
let employeeChart = null; // will now show Low Stock Products
let productChart = null;

const getDashboardAnalytics = () => {
    $.ajax({
        url: "../controller/end-points/controller.php?requestType=getDashboardAnalytics",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.status !== 200 || !response.data) return;

            const { 
                CustomerCount, 
                EmployeeCount, 
                PendingAppointmentCount, 
                ApprovedAppointmentCount, 
                CanceledAppointmentCount, 
                TotalSales, 
                SalesLast7Days,
                LowStockProducts, // Top 10 Low Stock Products
                PopularItems
            } = response.data;

            // -----------------------
            // Update dashboard cards
            // -----------------------
            $('.CustomerCount').text(CustomerCount || 0);
            $('.EmployeeCount').text(EmployeeCount || 0);
            $('.PendingAppointmentCountDashboard').text(PendingAppointmentCount || 0);
            $('.TotalSales').text(`₱${parseFloat(TotalSales || 0).toFixed(2)}`);

            // -----------------------
            // Sales Line Chart
            // -----------------------
            const salesSeries = (SalesLast7Days && SalesLast7Days.length > 0)
                ? SalesLast7Days.map(d => parseFloat(d.total))
                : [0];
            const salesCategories = (SalesLast7Days && SalesLast7Days.length > 0)
                ? SalesLast7Days.map(d => d.date)
                : ['No Data'];

            if(!salesChart) {
                const salesOptions = {
                    chart: { type: 'line', height: 300 },
                    series: [{ name: 'Sales', data: salesSeries }],
                    xaxis: { categories: salesCategories },
                    stroke: { curve: 'smooth' },
                    title: { text: 'Sales (Last 7 Days)', align: 'center' },
                    dataLabels: { enabled: false },
                    noData: { text: 'No Sales Data' }
                };
                salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
                salesChart.render();
            } else {
                salesChart.updateOptions({ xaxis: { categories: salesCategories } });
                salesChart.updateSeries([{ data: salesSeries }]);
            }

                // -----------------------
                // Today's + Tomorrow's Appointments
                // -----------------------
                const todayList = response.data.AppointmentsTodayList || [];
                const tomorrowList = response.data.AppointmentsTomorrowList || [];
                const container = $("#appointmentChart");  // reuse same div

                // Clear old content
                container.html("");

                let html = `
                    <h3 class="text-center font-bold text-lg mb-3">
                        Today's Appointments (${todayList.length})
                    </h3>
                    <div class="space-y-2 mb-6 max-h-64 overflow-y-auto pr-2">
                `;

                // ---- Today's list ----
                if (todayList.length === 0) {
                    html += `
                        <div class="text-center text-gray-500 py-3">
                            No appointments today.
                        </div>
                    `;
                } else {
                    todayList.forEach(a => {
                        html += `
                            <div class="p-3 rounded-lg border bg-white shadow flex justify-between items-center cursor-pointer hover:bg-gray-100"
                                onclick="openAppointmentDetails(${a.appointment_id})">
                                
                                <div>
                                    <div class="font-semibold">${a.fullname}</div>
                                    <div class="text-sm text-gray-500">${a.appointmentTime}</div>
                                </div>

                                <span class="text-xs px-2 py-1 rounded 
                                    ${a.status === 'approved' ? 'bg-green-200 text-green-700' : 
                                    a.status === 'pending' ? 'bg-yellow-200 text-yellow-700' : 
                                    'bg-red-200 text-red-700'}">
                                    ${a.status}
                                </span>
                            </div>
                        `;
                    });
                }

                html += `</div>`; // End today scroll

                // ---- Tomorrow's section ----
                html += `
                    <h3 class="text-center font-bold text-lg mb-3">
                        Tomorrow's Appointments (${tomorrowList.length})
                    </h3>
                    <div class="space-y-2 max-h-64 overflow-y-auto pr-2">
                `;

                if (tomorrowList.length === 0) {
                    html += `
                        <div class="text-center text-gray-500 py-3">
                            No appointments tomorrow.
                        </div>
                    `;
                } else {
                    tomorrowList.forEach(a => {
                        html += `
                            <div class="p-3 rounded-lg border bg-white shadow flex justify-between items-center cursor-pointer hover:bg-gray-100"
                                onclick="openAppointmentDetails(${a.appointment_id})">
                                
                                <div>
                                    <div class="font-semibold">${a.fullname}</div>
                                    <div class="text-sm text-gray-500">${a.appointmentTime}</div>
                                </div>

                                <span class="text-xs px-2 py-1 rounded 
                                    ${a.status === 'approved' ? 'bg-green-200 text-green-700' : 
                                    a.status === 'pending' ? 'bg-yellow-200 text-yellow-700' : 
                                    'bg-red-200 text-red-700'}">
                                    ${a.status}
                                </span>
                            </div>
                        `;
                    });
                }

                html += `</div>`; // End tomorrow scroll

                container.html(html);

            


            // -----------------------
            // Top 10 Low Stock Products - Horizontal Bar Chart
            // -----------------------
            const lowStocks = (LowStockProducts || []).map(p => ({
                item: p.name,
                qty: p.quantity
            }));

            // Sort ascending by quantity
            lowStocks.sort((a, b) => a.qty - b.qty);

            if(lowStocks.length > 0) {
                const stockColors = lowStocks.map(item => {
                    if(item.qty > 10) return '#00E396';  // green
                    else if(item.qty > 0) return '#FFB800'; // yellow
                    else return '#FF4560'; // red
                });

                const options = {
                    chart: { type: 'bar', height: 450 },
                    plotOptions: { bar: { horizontal: true, distributed: true } },
                    dataLabels: { enabled: true, formatter: val => val },
                    series: [{ data: lowStocks.map(item => item.qty) }],
                    xaxis: {
                        categories: lowStocks.map(item => item.item),
                        title: { text: undefined } // ❌ remove x-axis title
                    },
                    colors: stockColors,
                    title: { text: 'Top 10 Low Stocks', align: 'center' },
                    noData: { text: 'No Low Stock Products' },
                    legend: { show: false } // ❌ hide item list below chart
                };
                if(!employeeChart) {
                    employeeChart = new ApexCharts(document.querySelector("#employeeChart"), options);
                    employeeChart.render();
                } else {
                    employeeChart.updateOptions({
                        series: [{ data: lowStocks.map(item => item.qty) }],
                        xaxis: { categories: lowStocks.map(item => item.item) },
                        colors: stockColors
                    });
                }
            } else {
                if(employeeChart) employeeChart.updateOptions({ series: [], xaxis: { categories: [] } });
            }

            // -----------------------
            // Popular Items Pie Chart
            // -----------------------
            const productLabels = (PopularItems || []).map(p => p.name);
            const productSeries = (PopularItems || []).map(p => p.total_sold);

            if(!productChart) {
                const productOptions = {
                    chart: { type: 'pie', height: 300 },
                    labels: productLabels,
                    series: productSeries,
                    title: { text: 'Most Sold Products', align: 'center' },
                    noData: { text: 'No Popular Items' }
                };
                productChart = new ApexCharts(document.querySelector("#productChart"), productOptions);
                productChart.render();
            } else {
                productChart.updateOptions({ labels: productLabels });
                productChart.updateSeries(productSeries);
            }
        },
        error: function(err) {
            console.error('Failed to fetch analytics', err);
        }
    });
};

// Initial fetch
getDashboardAnalytics();

// Refresh every 5 seconds
setInterval(getDashboardAnalytics, 5000);
