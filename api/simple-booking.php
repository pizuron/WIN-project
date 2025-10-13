<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../simple-booking-db.php';
require_once __DIR__ . '/../lib/free-email.php';

// Email and SMS notification functions
function sendEmailConfirmation($booking) {
    $to = $booking['customer_email'];
    $subject = "🍝 Gianni Restaurant - Booking Confirmed!";
    
    $message = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background: #d4af37; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background: #f9f9f9; }
            .booking-details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .detail-row { display: flex; justify-content: space-between; margin: 8px 0; padding: 5px 0; border-bottom: 1px solid #eee; }
            .label { font-weight: bold; color: #d4af37; }
            .footer { background: #333; color: white; padding: 15px; text-align: center; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h1>🍝 Gianni Restaurant</h1>
            <h2>Booking Confirmed!</h2>
        </div>
        
        <div class='content'>
            <p>Dear " . htmlspecialchars($booking['customer_name']) . ",</p>
            
            <p>Thank you for choosing Gianni Restaurant! Your table has been successfully reserved.</p>
            
            <div class='booking-details'>
                <h3>Booking Details:</h3>
                <div class='detail-row'>
                    <span class='label'>Date:</span>
                    <span>" . date('l, F j, Y', strtotime($booking['booking_date'])) . "</span>
                </div>
                <div class='detail-row'>
                    <span class='label'>Time:</span>
                    <span>" . date('g:i A', strtotime($booking['booking_time'])) . "</span>
                </div>
                <div class='detail-row'>
                    <span class='label'>Party Size:</span>
                    <span>" . $booking['number_of_customers'] . " people</span>
                </div>
                <div class='detail-row'>
                    <span class='label'>Booking ID:</span>
                    <span>#" . $booking['id'] . "</span>
                </div>
            </div>
            
            <p><strong>What to expect:</strong></p>
            <ul>
                <li>Please arrive 5 minutes before your reservation time</li>
                <li>If you need to modify or cancel, please call us at (02) 6248 5444</li>
                <li>We look forward to welcoming you to Gianni!</li>
            </ul>
        </div>
        
        <div class='footer'>
            <p>Gianni Restaurant | (02) 6248 5444</p>
            <p>Thank you for choosing us! 🇮🇹</p>
        </div>
    </body>
    </html>";
    
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: Gianni Restaurant <noreply@gianni.com.au>',
        'Reply-To: info@gianni.com.au',
        'X-Mailer: PHP/' . phpversion()
    ];
    
    // Send free email
    $success = sendFreeEmail($to, $subject, $message, 'php');
    
    // Also create a file for backup/logging
    $emailFile = __DIR__ . '/../data/email_sent.html';
    $emailContent = "=== EMAIL NOTIFICATION ===\n";
    $emailContent .= "To: $to\n";
    $emailContent .= "Subject: $subject\n";
    $emailContent .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $emailContent .= "Status: " . ($success ? 'SENT' : 'FAILED') . "\n";
    $emailContent .= "========================\n\n";
    $emailContent .= $message;
    $emailContent .= "\n\n========================\n\n";
    
    file_put_contents($emailFile, $emailContent, FILE_APPEND);
    
    // Log email attempt
    logEmailNotification($booking, $success);
    
    return $success;
}

function sendRealEmail($to, $subject, $message, $headers) {
    // Check if SMTP is configured
    if (SMTP_USERNAME === 'your-email@gmail.com' || SMTP_PASSWORD === 'your-app-password') {
        // Fallback to PHP mail() if not configured
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
    
    try {
        $smtp = new SMTPEmail(
            SMTP_HOST,
            SMTP_PORT,
            SMTP_USERNAME,
            SMTP_PASSWORD,
            SMTP_FROM_EMAIL,
            SMTP_FROM_NAME
        );
        
        $result = $smtp->sendEmail($to, $subject, $message, true);
        
        if ($result['success']) {
            error_log("EMAIL SENT SUCCESSFULLY to $to");
            return true;
        } else {
            error_log("EMAIL FAILED to $to: " . $result['error']);
            return false;
        }
    } catch (Exception $e) {
        error_log("EMAIL ERROR: " . $e->getMessage());
        return false;
    }
}

function sendSMSConfirmation($booking) {
    $phone = $booking['customer_phone'];
    
    // Format phone number (remove spaces, add + if needed)
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    if (!str_starts_with($phone, '+')) {
        $phone = '+61' . ltrim($phone, '0'); // Assume Australian number
    }
    
    $message = "🍝 GIANNI RESTAURANT\n\n";
    $message .= "Booking Confirmed!\n\n";
    $message .= "📅 Date: " . date('d/m/Y', strtotime($booking['booking_date'])) . "\n";
    $message .= "🕐 Time: " . date('H:i', strtotime($booking['booking_time'])) . "\n";
    $message .= "👥 People: " . $booking['number_of_customers'] . "\n";
    $message .= "🔑 Booking ID: #" . $booking['id'] . "\n\n";
    $message .= "Thank you for choosing Gianni! 🇮🇹\n";
    $message .= "Call (02) 6248 5444 for changes.";
    
    // Send simple SMS
    $success = sendSimpleSMS($phone, $message);
    
    // Log SMS attempt
    logSMSNotification($booking, $phone, $message, $success);
    
    return $success;
}

function sendRealSMS($phone, $message) {
    global $config;
    
    // Check if Twilio is configured
    if (TWILIO_SID === 'your_twilio_account_sid' || TWILIO_TOKEN === 'your_twilio_auth_token') {
        // Fallback to file logging if not configured
        return simulateSMSSending($phone, $message);
    }
    
    try {
        $twilio = new TwilioSMS(TWILIO_SID, TWILIO_TOKEN, TWILIO_FROM);
        $result = $twilio->sendSMS($phone, $message);
        
        if ($result['success']) {
            error_log("SMS SENT SUCCESSFULLY to $phone: " . $result['message_sid']);
            return true;
        } else {
            error_log("SMS FAILED to $phone: " . $result['error']);
            return false;
        }
    } catch (Exception $e) {
        error_log("SMS ERROR: " . $e->getMessage());
        return false;
    }
}

function simulateSMSSending($phone, $message) {
    // For local development, we'll create a file that shows what SMS would be sent
    $smsFile = __DIR__ . '/../data/sms_sent.txt';
    $smsContent = "=== SMS NOTIFICATION ===\n";
    $smsContent .= "To: $phone\n";
    $smsContent .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $smsContent .= "Message:\n$message\n";
    $smsContent .= "========================\n\n";
    
    file_put_contents($smsFile, $smsContent, FILE_APPEND);
    
    // Also log to error log for visibility
    error_log("SMS NOTIFICATION SENT TO: $phone");
    error_log("SMS MESSAGE: $message");
    
    return true;
}

function logEmailNotification($booking, $success) {
    $logFile = __DIR__ . '/../data/email_log.json';
    $logData = [];
    
    if (file_exists($logFile)) {
        $logData = json_decode(file_get_contents($logFile), true) ?: [];
    }
    
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'booking_id' => $booking['id'],
        'to' => $booking['customer_email'],
        'customer_name' => $booking['customer_name'],
        'status' => $success ? 'sent' : 'failed',
        'subject' => 'Gianni Restaurant - Booking Confirmed!'
    ];
    
    $logData[] = $logEntry;
    file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));
}

function logSMSNotification($booking, $phone, $message, $success) {
    $logFile = __DIR__ . '/../data/sms_log.json';
    $logData = [];
    
    if (file_exists($logFile)) {
        $logData = json_decode(file_get_contents($logFile), true) ?: [];
    }
    
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'booking_id' => $booking['id'],
        'to' => $phone,
        'customer_name' => $booking['customer_name'],
        'status' => $success ? 'sent' : 'failed',
        'message' => $message
    ];
    
    $logData[] = $logEntry;
    file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            throw new Exception('Invalid JSON input');
        }
        
        // Validate required fields
        $requiredFields = ['customerName', 'customerPhone', 'customerEmail', 'numberOfCustomers', 'bookingDate', 'bookingTime'];
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }
        
        // Validate date (must be today or future)
        $bookingDate = new DateTime($input['bookingDate']);
        $today = new DateTime();
        $today->setTime(0, 0, 0);
        
        if ($bookingDate < $today) {
            throw new Exception('Booking date cannot be in the past');
        }
        
        // Validate time format
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $input['bookingTime'])) {
            throw new Exception('Invalid time format');
        }
        
        // Save booking to database
        $booking = $bookingDB->saveBooking(
            $input['customerName'],
            $input['customerPhone'],
            $input['customerEmail'],
            $input['numberOfCustomers'],
            $input['bookingDate'],
            $input['bookingTime']
        );
        
        // Send email confirmation
        sendEmailConfirmation($booking);
        
        // Send SMS confirmation if phone provided
        if (!empty($booking['customer_phone'])) {
            sendSMSConfirmation($booking);
        }
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Booking confirmed successfully!',
            'booking' => $booking
        ]);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get all bookings or filter by date
    $date = $_GET['date'] ?? null;
    
    if ($date) {
        $bookings = $bookingDB->getBookingsByDate($date);
    } else {
        $bookings = $bookingDB->getAllBookings();
    }
    
    echo json_encode([
        'success' => true,
        'bookings' => $bookings
    ]);
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed'
    ]);
}
?>
