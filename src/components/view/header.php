<?php 
session_start();


// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

include "auth.php";

$db = new auth_class();

if (isset($_SESSION['user_id'])) {
    $id = intval($_SESSION['user_id']);
    $On_Session = $db->check_account($id);

    if (empty($On_Session)) {
        header('location: ../login');
        exit();
    }
} else {
   header('location: ../login');
   exit();
}

// Authorization
$authorize = (strtolower($On_Session['position']) !== "admin") ? "hidden" : "";

// ✅ Fetch Business Details
$business = $db->get_business_details();
            


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS System</title>
  <link href="../src/output.css" rel="stylesheet">
  <link href="../src/alertifyconfig.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



</head>
<body class="bg-gray-50 min-h-screen flex">

  

<!-- Sidebar (hidden on small screens, visible on md+) -->
<aside class="hidden md:flex w-20 bg-gray-100 border-r flex-col justify-between">

  <!-- Top Section (Logo + Menu) -->
  <div>
    <!-- Logo Top -->
    <div class="bg-black flex justify-center items-center py-4">

   
    <a href="dashboard" class="flex justify-center">
        <img src="../static/images/dashboard_logo2.png" alt="Logo" class="h-11 w-auto object-contain">
    </a>
    

    </div>

<!-- Menu Items -->
<div class="flex flex-col space-y-2 text-center">
  <a href="sales" class="flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200">
    <img src="../static/images/transaction.png" alt="Sales" class="w-8 h-8">
    <span class="text-xs font-medium mt-1 text-gray-700">Sales</span>
  </a>

  <a href="inventory" class="flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200">
    <img src="../static/images/inventory.png" alt="Inventory" class="w-8 h-8">
    <span class="text-xs font-medium mt-1 text-gray-700">Inventory</span>
  </a>

  <a href="analytics" class="flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200" <?= $authorize ?>>
    <img src="../static/images/analytics.png" alt="Analytics" class="w-8 h-8">
    <span class="text-xs font-medium mt-1 text-gray-700">Reports</span>
  </a>

  <!--<a href="employee" class="flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200">
    <img src="../static/images/team_management.png" alt="Employee" class="w-8 h-8">
    <span class="text-xs font-medium mt-1 text-gray-700">Employee Management</span>
  </a>-->

  <a href="manage_user" class="flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200" <?= $authorize ?>>
    <img src="../static/images/team_management.png" alt="Manage Users" class="w-8 h-8">
    <span class="text-xs font-medium mt-1 text-gray-700">Employee Management</span>
  </a>

  <a href="booking_request" class="relative flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200">
    <img src="../static/images/email.png" alt="Bookings" class="w-8 h-8">
    <span class="text-xs font-medium mt-1 text-gray-700">Bookings</span>

    <span style="display:none;" class="PendingAppointmentCount absolute top-1 right-4 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
      0
    </span>
  </a>

  <a href="restock_alert" class="relative flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200">
    <img src="../static/images/notification.png" alt="Notification" class="w-8 h-8">
    <span class="text-xs font-medium mt-1 text-gray-700">Notification</span>

    <span style="display:none;" class="UnreadRestockAlertCount absolute top-1 right-4 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
      0
    </span>
  </a>
</div>

</div>

  <!-- Bottom Items -->
  <div class="space-y-6 mb-4 text-center">
    <a href="logout" class="flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200">
      <img src="../static/images/logout.png" alt="Logout" class="w-8 h-8">
      <span class="text-xs font-medium mt-1 text-gray-700">LogOut</span>
    </a>

    <a href="settings" class="flex flex-col items-center justify-center w-full p-2 rounded-lg hover:bg-gray-200 hover:scale-105 transition duration-200">
      <img src="../static/images/settings.png" alt="Settings" class="w-8 h-8">
      <span class="text-xs font-medium mt-1 text-gray-700">Settings</span>
    </a>
  </div>
</aside>


  <!-- Bottom Navigation (mobile only) -->
  <nav class="fixed bottom-0 left-0 right-0 bg-gray-100 border-t flex justify-around py-2 md:hidden">
    <!-- <a href="sales" class="p-2 rounded-lg hover:bg-gray-200 hover:scale-110 transition duration-200">
      <img src="../static/images/menus.png" alt="Sales" class="h-6">
    </a> -->
    <a href="transaction" class="p-2 rounded-lg hover:bg-gray-200 hover:scale-110 transition duration-200" <?= $authorize ?>>
      <img src="../static/images/transaction.png" alt="Transaction" class="h-6">
    </a>
    <a href="inventory" class="p-2 rounded-lg hover:bg-gray-200 hover:scale-110 transition duration-200" <?= $authorize ?>>
      <img src="../static/images/inventory.png" alt="Inventory" class="h-6">
    </a>
    <a href="analytics" class="p-2 rounded-lg hover:bg-gray-200 hover:scale-110 transition duration-200" <?= $authorize ?>>
      <img src="../static/images/analytics.png" alt="Analytics" class="h-6">
    </a>
    <a href="employee" class="p-2 rounded-lg hover:bg-gray-200 hover:scale-110 transition duration-200 <?= $authorize ?>">
      <img src="../static/images/team_management.png" alt="Employee" class="h-6">
    </a>
    <a href="logout" class="p-2 rounded-lg hover:bg-gray-200 hover:scale-110 transition duration-200 ">
      <img src="../static/images/logout.png" alt="Logout" class="h-6">
    </a>
  </nav>

</body>
</html>