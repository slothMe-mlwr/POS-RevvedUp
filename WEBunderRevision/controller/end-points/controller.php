<?php
include('../class.php');

$db = new global_class();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
        } else if ($_POST['requestType'] == 'RequestAppointment') {

        date_default_timezone_set('Asia/Manila'); // Set Manila timezone

        $customer_id      = $_SESSION['customer_id'];
        $servicesJSON     = $_POST['services'] ?? '[]'; // Array of services as JSON string
        $servicesArray    = json_decode($servicesJSON, true) ?? [];
        $service          = implode(", ", $servicesArray); // Comma-separated string

        $employee_id      = $_POST['employee_id'] ?? '';
        $fullname         = $_POST['fullname'] ?? '';
        $contact          = $_POST['contact'] ?? '';
        $appointmentDate  = $_POST['appointmentDate'] ?? '';
        $appointmentTime  = $_POST['appointmentTime'] ?? '';
        $city             = $_POST['city'] ?? '';
        $street           = $_POST['street'] ?? '';
        $emergency        = isset($_POST['emergency']) ? $_POST['emergency'] : 0;

        // ✅ Capture problem description, allow null if empty
        $problemDescription = isset($_POST['problemDescription']) && $_POST['problemDescription'] !== ''
            ? $_POST['problemDescription']
            : null;

        // ✅ Validation: check required fields
// ✅ Validation: must have either at least one service OR a description
            if (empty($servicesArray) && empty($problemDescription)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Please select at least one service or provide a description in "Other".'
                ]);
                exit;
            }


            if (empty($fullname) || empty($contact) || empty($appointmentDate) || empty($appointmentTime)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'All fields are required (except employee selection).'
                ]);
                exit;
            }

            // ✅ Convert empty employee_id to null
            $employee_id = !empty($_POST['employee_id']) ? $_POST['employee_id'] : null;


        // ✅ Validate appointment time (8:00 AM - 6:00 PM)
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

        // ✅ Call DB function — pass problemDescription
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
            $street,
            $problemDescription // <--- new parameter
        );

        // ✅ Response
        if (!empty($result['success']) && $result['success'] === true) {
            echo json_encode([
                'status' => 'success',
                'message' => $result['message'],
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $result['message'] ?? 'Failed to process appointment.'
            ]);
        }
    } else {
                echo "<pre>";
                print_r($_POST);
                echo "</pre>";
                echo "No Request Type";
            }

    }else {
        echo 'No POST REQUEST';
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

   if (isset($_GET['requestType']))
    {
        if ($_GET['requestType'] == 'fetch_appointment') {

            $result = $db->fetch_appointment($_SESSION['customer_id']);
            echo json_encode([
                'status' => 200,
                'data' => $result
            ]);
        } else if ($_GET['requestType'] == 'get_trivia') {
            $result = $db->getDailyTrivia();
            echo json_encode([
                'status' => 200,
                'data' => $result

            ]);

        } else if ($_GET['requestType'] == 'fetch_reviews') {

            $result = $db->fetchReviews();
            echo json_encode([
                'status' => 200,
                'data' => $result

            ]);
        } else {
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