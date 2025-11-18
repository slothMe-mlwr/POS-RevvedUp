
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require __DIR__ . '/../vendor/autoload.php'; // adjust path if needed

    include ('config.php');

    date_default_timezone_set('Asia/Manila');

    class global_class extends db_connect
    {
        public function __construct()
        {
            $this->connect();
        }


           public function RequestAppointment(
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
    $problemDescription = null
) {
    // Generate unique reference number
    do {
        $reference_number = rand(100000, 999999);
        $checkQuery = "SELECT COUNT(*) as count FROM appointments WHERE reference_number = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bind_param("i", $reference_number);
        $checkStmt->execute();
        $result = $checkStmt->get_result()->fetch_assoc();
    } while ($result['count'] > 0);


    // ---------------------------------------------
    // 1️⃣ GLOBAL LIMIT: maximum 3 bookings per date+time
    // ---------------------------------------------
    $checkTotal = $this->conn->prepare("
        SELECT COUNT(*) AS total 
        FROM appointments 
        WHERE appointmentDate = ? 
          AND appointmentTime = ?
    ");
    $checkTotal->bind_param("ss", $appointmentDate, $appointmentTime);
    $checkTotal->execute();
    $totalResult = $checkTotal->get_result()->fetch_assoc();

    if ($totalResult['total'] >= 3) {
        return [
            'success' => false,
            'message' => 'This appointment time is fully booked (maximum of 3 customers allowed).'
        ];
    }


    // ---------------------------------------------
    // 2️⃣ EMPLOYEE CHECK: prevent double-booking a specific employee
    // ---------------------------------------------
    if (!empty($employee_id)) {
        $checkEmp = $this->conn->prepare("
            SELECT COUNT(*) AS empCount 
            FROM appointments 
            WHERE appointmentDate = ? 
              AND appointmentTime = ? 
              AND employee_id = ?
        ");
        $checkEmp->bind_param("ssi", $appointmentDate, $appointmentTime, $employee_id);
        $checkEmp->execute();
        $empResult = $checkEmp->get_result()->fetch_assoc();

        if ($empResult['empCount'] >= 1) {
            return [
                'success' => false,
                'message' => 'This employee is already booked at that time.'
            ];
        }
    }



    // ---------------------------------------------
    // PROCEED WITH INSERT (unchanged)
    // ---------------------------------------------

    $query = "INSERT INTO appointments 
        (reference_number, service, employee_id, fullname, contact, appointmentDate, appointmentTime, emergency, status, appointment_customer_id, city, street, problem_description) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($query);

    if ($stmt === false) {
        return [
            'success' => false,
            'message' => 'Query preparation failed: ' . $this->conn->error
        ];
    }

    // Convert empty employee_id to null
    if ($employee_id === null || $employee_id === '') {
        $employee_id = null;
    }

    $stmt->bind_param(
        "isissssiisss",
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
        $street,
        $problemDescription
    );

    // Execute
    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Appointment booked successfully. Pending for approval.',
            'reference_number' => $reference_number
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

      public function fetchReviews() {
    $sql = "SELECT customer_name, review_text FROM reviews ORDER BY created_at DESC";
    $result = $this->conn->query($sql);

    if ($result && $result->num_rows > 0) {
      $reviews = [];
      while ($row = $result->fetch_assoc()) {
        $reviews[] = [
          "text" => $row["review_text"],
          "author" => "- " . $row["customer_name"]
        ];
      }
      return ["status" => 200, "data" => $reviews];
    } else {
      return ["status" => 404, "message" => "No reviews found."];
    }
}

        public function getDailyTrivia() {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM trivia");
        $count = $stmt->fetch_assoc()['total'];

        $day = date('j'); // 1–31
        $offset = ($day - 1) % $count; // loops around if day > trivia count

        $stmt = $this->conn->prepare("SELECT text FROM trivia ORDER BY id LIMIT 1 OFFSET ?");
        $stmt->bind_param("i", $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['text'];
        } else {
            return "No trivia available today.";
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
                // Set timezone
                date_default_timezone_set('Asia/Manila');
                $now = date('Y-m-d H:i:s');

                // Update past pending appointments to expired
                $this->conn->query("
                    UPDATE appointments
                    SET status = 'expired'
                    WHERE status = 'pending'
                    AND CONCAT(appointmentDate, ' ', appointmentTime) < '$now'
                ");



                $sql = "SELECT a.*, 
                            u.nickname AS employee_name
                        FROM appointments AS a
                        LEFT JOIN user AS u 
                            ON a.employee_id = u.user_id
                        WHERE a.appointment_customer_id = '$customer_id'
                        ORDER BY a.appointment_id DESC";

                $result = $this->conn->query($sql);


                $appointments = [];
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $appointments[] = $row;
                    }
                }
                return $appointments;
            }




       public function cancel_appointment($appointment_id) {
            // Prepare statement
            $stmt = $this->conn->prepare("UPDATE appointments SET status = 'canceled' WHERE appointment_id = ?");
            
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

}

?>