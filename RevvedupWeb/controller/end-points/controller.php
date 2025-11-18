<?php
include('../class.php');

$db = new global_class();



if (isset($_POST['action']) && $_POST['action'] === 'getBookingStatus') {
    $date = $_POST['appointmentDate'];
    $rawResult = $db->getBookingStatus($date); // returns data from class.php

    // Transform to proper structure for frontend
    $result = [];
    foreach ($rawResult as $time => $info) {
        $result[$time] = [
            'total' => $info['total'],
            'employees' => array_map('intval', $info['employees'])
        ];
    }

    echo json_encode($result);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'getFullyBookedDates') {
    $stmt = $conn->prepare("SELECT appointmentDate, COUNT(*) as total FROM appointments GROUP BY appointmentDate HAVING total >= 3");
    $stmt->execute();
    $result = $stmt->get_result();
    $dates = [];
    while($row = $result->fetch_assoc()) {
        $dates[] = $row['appointmentDate'];
    }
    echo json_encode($dates);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['requestType'])) {
        if ($_POST['requestType'] == 'LoginCustomer') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $loginResult = $db->Login($email, $password);

            if ($loginResult['success']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => $loginResult['message']
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $loginResult['message']
                ]);
            }
        }else if ($_POST['requestType'] == 'cancel_appointment') {
            $appointment_id = $_POST['appointment_id'];
            $result = $db->cancel_appointment($appointment_id);

            if ($result['success']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => $result['message']   // <-- use $result, not $loginResult
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $result['message']   // <-- use $result, not $loginResult
                ]);
            }

        }else if ($_POST['requestType'] == 'RegisterCustomer') {
                $fullname = $_POST['fullname'];
                $email  = $_POST['email'];
                $password      = $_POST['password'];

                $result = $db->RegisterCustomer($fullname, $email, $password);

                if ($result['success']) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => $result['message'],
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => $result['message']
                    ]);
                }

        }else if ($_POST['requestType'] == 'ForgotPassword') {
        
            $email = $_POST['email'];

            $forgotPassword = $db->CheckEmail($email);

                if ($forgotPassword['status'] === 'success') {
                echo json_encode([
                    'status' => 'success',
                    'message' => $forgotPassword['message']
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $forgotPassword['message']
                ]);
            }
        }else if ($_POST['requestType'] == 'VerifyOtp') {
            $otp = $_POST['otp'];
            $new_password = $_POST['new_password'];

            $verifyotp = $db->VerifyOTP($otp, $new_password);

            if ($verifyotp['success']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => $verifyotp['message']
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $verifyotp['message']
                ]);
            }
            }else if ($_POST['requestType'] == 'RequestAppointment') {

                date_default_timezone_set('Asia/Manila'); // Set Manila timezone

                $customer_id = $_SESSION['customer_id'] ?? '';

                // ✅ Handle multiple selected services safely
                if (isset($_POST['service']) && !empty($_POST['service'])) {
                    if (is_array($_POST['service'])) {
                        // Join multiple selected services into one string
                        $service = implode(", ", $_POST['service']);
                    } else {
                        // Single service selected
                        $service = $_POST['service'];
                    }
                } else {
                    $service = '';
                }

                // ✅ Handle "other" service (if user typed their own)
                if ($service === "other") {
                    $service = trim($_POST['otherService'] ?? '');
                }

                $employee_id = !empty($_POST['employee_id']) ? (int)$_POST['employee_id'] : null;
                $fullname         = $_POST['fullname'] ?? '';
                $contact          = $_POST['contact'] ?? '';
                $appointmentDate  = $_POST['appointmentDate'];
                $appointmentTime  = $_POST['appointmentTime'];
                $city             = $_POST['city'] ?? '';
                $street           = $_POST['street'] ?? '';
                $emergency        = isset($_POST['emergency']) ? $_POST['emergency'] : 0;

                // ✅ Validation: check required fields
                if (empty($service)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Please select at least one service.'
                    ]);
                    exit;
                }

                if (empty($employee_id) || empty($fullname) || empty($contact) || empty($appointmentDate) || empty($appointmentTime)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'All fields are required.'
                    ]);
                    exit;
                }

                // ✅ Validate appointment time (8:00 AM - 6:00 PM)
                // ✅ Validate appointment time range
                $time = DateTime::createFromFormat('H:i', $appointmentTime);
                $startTime = DateTime::createFromFormat('H:i', '08:00');
                $endTime = DateTime::createFromFormat('H:i', '18:00');

                if (!$time || $time < $startTime || $time > $endTime) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Appointment time must be between 8:00 AM and 6:00 PM.'
                    ]);
                    exit;
                }

                // ✅ Validate appointment date (cannot be in the past)
                $today = date('Y-m-d'); // today's date
                $currentTime = new DateTime(); // current time in Manila
                $currentDate = $currentTime->format('Y-m-d');

                if ($appointmentDate < $today) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Cannot book an appointment on a past date.'
                    ]);
                    exit;
                }

                // ✅ If booking is for today, block all times earlier than the next hour
                if ($appointmentDate == $today) {
                    // round current time to the next full hour
                    $nextHour = (clone $currentTime)->modify('+1 hour')->format('H:00');
                    $nextAvailable = DateTime::createFromFormat('H:i', $nextHour);

                    if ($time < $nextAvailable) {
                        echo json_encode([
                            'status' => 'error',
                            'message' => 'Cannot book an appointment for a past or current time. Please select another appointment time.'
                        ]);
                        exit;
                    }
                }
                if (empty($service)) { /* ... */ }
if (empty($fullname) || empty($contact) || empty($appointmentDate) || empty($appointmentTime)) { /* ... */ }

// ✅ Validate appointment time (8:00 - 18:00) and past dates
// ... your existing time/date checks here ...

// ------------------ Check booking limit ------------------
$bookingStatus = $db->getBookingStatus($appointmentDate);

// Count total bookings at this time, regardless of mechanic
$currentTotal = $bookingStatus[$appointmentTime]['total'] ?? 0;

if ($currentTotal >= 3) {
    echo json_encode([
        'status' => 'error',
        'message' => 'This time slot is fully booked. Please select another time.'
    ]);
    exit;
}

// ------------------ Check specific mechanic availability ------------------
if (!empty($employee_id) && isset($_POST['specificMechanic']) && $_POST['specificMechanic'] == 'on') {
    $bookedEmployees = $bookingStatus[$appointmentTime]['employees'] ?? [];
    if (in_array((int)$employee_id, $bookedEmployees)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Selected employee is unavailable at this time. Please choose another employee or time.'
        ]);
        exit;
    }
}

                // ✅ Call DB function
                $result = $db->RequestAppointment(
                    $service, 
                    $employee_id, 
                    $fullname, 
                    $contact, 
                    $appointmentDate, 
                    $appointmentTime, 
                    $emergency, 
                    $customer_id, 
                    $city, 
                    $street
                );

                // ✅ Response
                if (!empty($result['success']) && $result['success'] === true) {

                    // ✅ INSERTED: Payment QR data response
                    $totalAmount = $result['amount'] ?? 300; // fallback example
                    echo json_encode([
                        'status' => 'success',
                        'message' => $result['message'],
                        'amount' => $totalAmount // ✅ Added for frontend modal
                    ]);
                    // ✅ END INSERTED

                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => $result['message'] ?? 'Failed to process appointment.'
                    ]);
                }

        }else {
                echo "<pre>";
                print_r($_POST);
                echo "</pre>";
                echo "No Request Type";
            }

    }else {
        echo 'No POST REQUEST';
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

   if (isset($_GET['requestType']))
    {
        if ($_GET['requestType'] == 'fetch_appointment') {

            $result = $db->fetch_appointment($_SESSION['customer_id']);
            echo json_encode([
                'status' => 200,
                'data' => $result
            ]);
        }else{
            echo "<pre>";
            print_r($_GET);
            echo "</pre>";
            echo "No Request Type";
        }


    }else {
        echo 'No GET REQUEST';
    }
}



?>
