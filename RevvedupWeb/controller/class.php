<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../vendor/autoload.php'; // adjust path if needed

require_once __DIR__ . '/config.php';

date_default_timezone_set('Asia/Manila');

class global_class extends db_connect
{
    public function __construct()
    {
        $this->connect();
    }

    // Get all feedbacks with customer names
   /* public function GetAllFeedbacks() {
    $sql = "SELECT f.*, c.customer_fullname 
            FROM feedback f 
            JOIN customer c ON f.customer_id = c.customer_id
            ORDER BY f.submitted_at DESC";
    $result = $this->conn->query($sql);
    $feedbacks = [];
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $feedbacks[] = $row;
        }
    }
    return $feedbacks;
} */

    public function RequestAppointment($service, $employee_id, $fullname, $contact, $appointmentDate, $appointmentTime, $emergency, $customer_id, $city, $street) {

    // ✅ Check if this time slot already reached 3 bookings (global)
    $checkQuery = "SELECT COUNT(*) as total FROM appointments WHERE appointmentDate = ? AND appointmentTime = ?";
$checkStmt = $this->conn->prepare($checkQuery);
$checkStmt->bind_param("ss", $appointmentDate, $appointmentTime);
$checkStmt->execute();
$checkResult = $checkStmt->get_result()->fetch_assoc();

if ($checkResult['total'] >= 3) {
    return [
        'success' => false,
        'message' => 'This time slot is fully booked. Please choose another time.'
    ];
}

// Check specific mechanic only if selected
if (!empty($employee_id)) {
    $empQuery = "SELECT COUNT(*) as total FROM appointments WHERE appointmentDate = ? AND appointmentTime = ? AND employee_id = ?";
    $empStmt = $this->conn->prepare($empQuery);
    $empStmt->bind_param("ssi", $appointmentDate, $appointmentTime, $employee_id);
    $empStmt->execute();
    $empResult = $empStmt->get_result()->fetch_assoc();

    if ($empResult['total'] > 0) {
        return [
            'success' => false,
            'message' => 'The selected mechanic is already booked for this time. Please choose another time or mechanic.'
        ];
    }

        }

    // Step 3: If no employee selected, leave employee_id as null or assign automatically (optional)
    if (empty($employee_id)) {
        $employee_id = null; // or pick a free employee if you want
    }

    // ✅ Generate unique reference number
    do {
        $reference_number = rand(100000, 999999); // 6-digit number
        $checkQuery = "SELECT COUNT(*) as count FROM appointments WHERE reference_number = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bind_param("i", $reference_number);
        $checkStmt->execute();
        $result = $checkStmt->get_result()->fetch_assoc();
    } while ($result['count'] > 0);

    // ✅ Build query (with reference_number)
    $query = "INSERT INTO appointments 
            (reference_number, service, employee_id, fullname, contact, appointmentDate, appointmentTime, emergency, status, appointment_customer_id, city, street) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?)";

    $stmt = $this->conn->prepare($query);
    if ($stmt === false) {
        return [
            'success' => false,
            'message' => 'Query preparation failed: ' . $this->conn->error
        ];
    }

    $stmt->bind_param(
        "isissssiiss", 
        $reference_number,
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

    // ✅ Execute insert and add payment info
    if ($stmt->execute()) {
        $paymentInfo = [
            'gcash_qr' => 'uploads/277ed08d-f3b0-417c-91cf-29713d38c121.png',
            'maya_qr' => 'uploads/32bd4283-c79c-4254-9dae-89dfc3ea08ac.png',
            'note' => '⚠️ Important: Please only send a downpayment after confirming with our staff.
                These QR codes are for agreed downpayments only between the customer and the store.'
        ];

        return [
            'success' => true,
            'message' => 'Appointment booked successfully. Pending for approval.',
            'reference_number' => $reference_number,
            'payment' => $paymentInfo
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Appointment failed: ' . $stmt->error
        ];
    }

    if ($stmt->execute()) {
        $paymentInfo = [
            'gcash_qr' => 'uploads/277ed08d-f3b0-417c-91cf-29713d38c121.png',
            'maya_qr' => 'uploads/32bd4283-c79c-4254-9dae-89dfc3ea08ac.png',
            'note' => '⚠️ Important: Please only send a downpayment after confirming with our staff.
            These QR codes are for agreed downpayments only between the customer and the store.'
        ];

        return [
            'success' => true,
            'message' => 'Appointment booked successfully. Pending for approval.',
            'reference_number' => $reference_number,
            'payment' => $paymentInfo
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Appointment failed: ' . $stmt->error
        ];
    }
}
    
    public function Login($email, $password){

        $query = $this->conn->prepare("SELECT * FROM `customer` WHERE `customer_email` = ?");
        $query->bind_param("s", $email);

        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['customer_password'])) {

                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['customer_id'] = $user['customer_id'];

                    $query->close();
                    return [
                        'success' => true,
                        'message' => 'Login successful.',
                        'data' => [
                            'customer_id' => $user['customer_id']
                        ]
                    ];
                } else {
                    $query->close();
                    return ['success' => false, 'message' => 'Incorrect password.'];
                }
            } else {
                $query->close();
                return ['success' => false, 'message' => 'Email not exist on the record.'];
            }
        } else {
            $query->close();
            return ['success' => false, 'message' => 'Database error during execution.'];
        }
    }

    public function RegisterCustomer($fullname, $email, $password) {

        $checkQuery = "SELECT customer_id FROM `customer` WHERE `customer_email` = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            return [
                'success' => false,
                'message' => 'Email already registered.'
            ];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `customer`(`customer_fullname`, `customer_email`, `customer_password`) 
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $fullname,$email, $hashedPassword);

        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Registration successful.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ];
        }
    }

    // Fetch all users with position 'user', without password or pin
    public function fetch_appointment($customer_id) {
        $sql = "SELECT appointments.*
                FROM appointments 
                WHERE appointment_customer_id = '$customer_id'
                ORDER BY appointment_id DESC";
        $result = $this->conn->query($sql);

        $users = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function cancel_appointment($appointment_id) {
        // Prepare statement
        $stmt = $this->conn->prepare("UPDATE appointments SET status = 'request canceled' WHERE appointment_id = ?");
        
        if ($stmt) {
            // Bind parameter
            $stmt->bind_param("i", $appointment_id); // "i" means integer
            
            // Execute statement
            if ($stmt->execute()) {
                $stmt->close();
                return [
                    'success' => true,
                    'message' => 'Appointment canceled successfully.'
                ];
            } else {
                $stmt->close();
                return [
                    'success' => false,
                    'message' => 'Failed to cancel appointment. Please try again.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Failed to prepare the statement.'
            ];
        }
    }

    public function getBookingStatus($date) {
    $result = [];

    // Get all bookings for the date that are NOT canceled
    $stmt = $this->conn->prepare("SELECT appointmentTime, employee_id FROM appointments WHERE appointmentDate = ? AND status != 'canceled'");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Aggregate bookings
    foreach ($bookings as $booking) {
        $time = $booking['appointmentTime'];
        $emp = $booking['employee_id'];

        if (!isset($result[$time])) {
            $result[$time] = [
                'total' => 0,       // total bookings at this time
                'employees' => []   // booked employee IDs
            ];
        }

        $result[$time]['total'] += 1;
        if ($emp !== null) $result[$time]['employees'][] = (int)$emp;
    }

    return $result;
}

    public function CheckEmail($email) {
        $query = $this->conn->prepare("SELECT * FROM customer WHERE customer_email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $otp = rand(100000, 999999);
            $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

            $update = $this->conn->prepare("UPDATE customer SET otp=?, otp_expiry=? WHERE customer_email=?");
            $update->bind_param("sss", $otp, $expiry, $email);
            $update->execute();

            $sendResult = $this->sendOTP($email, $otp);

            if ($sendResult['success']) {
                $_SESSION['reset_email'] = $email;
                return [
                    'status' => 'success',
                    'message' => 'OTP sent successfully. Please check your email.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to send OTP. ' . $sendResult['message']
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Email not found in records.'
            ];
        }
    }

    public function sendOTP($email, $otp)
    {
        // Load private mail config
        $mailConfig = include __DIR__ . '/../../../private/mail_config.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $mailConfig['MAIL_USERNAME'];
            $mail->Password   = $mailConfig['MAIL_PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Optional (helps with Gmail/Hostinger SSL issues)
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom($mailConfig['MAIL_USERNAME'], $mailConfig['MAIL_SENDER_NAME']);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = "Your OTP code is <b>$otp</b>. It will expire in 5 minutes.";

            $mail->send();
            return ['success' => true, 'message' => 'Mail sent successfully'];
        } catch (Exception $e) {
            // Return detailed error message
            return ['success' => false, 'message' => $mail->ErrorInfo];
        }
    }

    public function VerifyOtp($otp, $new_password) {
        if (!isset($_SESSION['reset_email'])) {
            return [
                'success' => false,
                'message' => 'Session expired. Please request a new OTP.'
            ];
        }

        $email = $_SESSION['reset_email'];

        // Check if OTP is valid and not expired
        $query = $this->conn->prepare("SELECT * FROM customer WHERE customer_email=? AND otp=? AND otp_expiry > NOW()");
        $query->bind_param("ss", $email, $otp);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            // Update password and clear OTP
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $this->conn->prepare("UPDATE customer SET customer_password=?, otp=NULL, otp_expiry=NULL WHERE customer_email=?");
            $update->bind_param("ss", $hashed, $email);

            if ($update->execute()) {
                unset($_SESSION['reset_email']);
                return [
                    'success' => true,
                    'message' => 'Password reset successful! Redirecting to login...'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Database error while updating password.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Invalid or expired OTP.'
            ];
        }
    }


    // ✅ FEEDBACK SYSTEM METHOD
  /*  public function SubmitFeedback($customer_id, $rating, $comments) {
    $query = "INSERT INTO feedback (customer_id, rating, comments, submitted_at) VALUES (?, ?, ?, NOW())";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("iis", $customer_id, $rating, $comments);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Feedback saved successfully.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to save feedback: ' . $stmt->error
        ];
    }
}
}*/
}
?>
