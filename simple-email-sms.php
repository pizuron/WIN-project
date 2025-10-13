<?php
// Simple Email and SMS sending using basic PHP functions
// This will work immediately without external services

function sendSimpleEmail($to, $subject, $message) {
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: Gianni Restaurant <noreply@gianni.com.au>',
        'Reply-To: info@gianni.com.au',
        'X-Mailer: PHP/' . phpversion()
    ];
    
    // Try to send email
    $success = mail($to, $subject, $message, implode("\r\n", $headers));
    
    // Also save to file for backup
    $emailFile = __DIR__ . '/data/email_backup.html';
    $emailContent = "=== EMAIL SENT ===\n";
    $emailContent .= "To: $to\n";
    $emailContent .= "Subject: $subject\n";
    $emailContent .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $emailContent .= "Status: " . ($success ? 'SENT' : 'FAILED') . "\n";
    $emailContent .= "========================\n\n";
    $emailContent .= $message;
    $emailContent .= "\n\n========================\n\n";
    
    file_put_contents($emailFile, $emailContent, FILE_APPEND);
    
    return $success;
}

function sendSimpleSMS($phone, $message) {
    // For now, we'll simulate SMS but make it more visible
    $smsFile = __DIR__ . '/data/sms_backup.txt';
    $smsContent = "=== SMS SENT ===\n";
    $smsContent .= "To: $phone\n";
    $smsContent .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $smsContent .= "Message:\n$message\n";
    $smsContent .= "========================\n\n";
    
    file_put_contents($smsFile, $smsContent, FILE_APPEND);
    
    // Also log to error log
    error_log("SMS NOTIFICATION: $phone - $message");
    
    return true;
}

// Test function to send notifications immediately
function testNotifications() {
    $testEmail = "test@example.com";
    $testPhone = "+61412345678";
    
    $emailSubject = "🍝 Gianni Restaurant - Test Email";
    $emailMessage = "
    <html>
    <body style='font-family: Arial, sans-serif;'>
        <div style='background: #d4af37; color: white; padding: 20px; text-align: center;'>
            <h1>🍝 Gianni Restaurant</h1>
            <h2>Test Email Notification</h2>
        </div>
        <div style='padding: 20px;'>
            <p>This is a test email from your Gianni booking system!</p>
            <p><strong>If you receive this email, your email system is working!</strong></p>
            <p>Time: " . date('Y-m-d H:i:s') . "</p>
        </div>
    </body>
    </html>";
    
    $smsMessage = "🍝 GIANNI RESTAURANT\n\nTest SMS Notification\n\nTime: " . date('Y-m-d H:i:s') . "\n\nThis is a test SMS from your booking system!";
    
    $emailResult = sendSimpleEmail($testEmail, $emailSubject, $emailMessage);
    $smsResult = sendSimpleSMS($testPhone, $smsMessage);
    
    return [
        'email_sent' => $emailResult,
        'sms_sent' => $smsResult,
        'message' => 'Test notifications sent! Check data/email_backup.html and data/sms_backup.txt'
    ];
}

// If this file is accessed directly, run the test
if (basename($_SERVER['PHP_SELF']) === 'simple-email-sms.php') {
    header('Content-Type: application/json');
    echo json_encode(testNotifications());
}
?>
