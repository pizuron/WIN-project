<?php
// FREE Email Services - No cost, no credit card required

class FreeEmailSender {
    
    // Method 1: Gmail SMTP (FREE)
    public static function sendViaGmail($to, $subject, $message, $fromEmail, $fromPassword) {
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ' . $fromEmail,
            'Reply-To: ' . $fromEmail,
            'X-Mailer: PHP/' . phpversion()
        ];
        
        // Use PHP mail() with Gmail SMTP settings
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
    
    // Method 2: Mailgun (FREE - 10,000 emails/month)
    public static function sendViaMailgun($to, $subject, $message, $apiKey, $domain) {
        $url = "https://api.mailgun.net/v3/{$domain}/messages";
        
        $data = [
            'from' => "Gianni Restaurant <noreply@{$domain}>",
            'to' => $to,
            'subject' => $subject,
            'html' => $message
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "api:{$apiKey}");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $httpCode === 200;
    }
    
    // Method 3: SendGrid (FREE - 100 emails/day)
    public static function sendViaSendGrid($to, $subject, $message, $apiKey) {
        $url = "https://api.sendgrid.com/v3/mail/send";
        
        $data = [
            'personalizations' => [
                [
                    'to' => [
                        ['email' => $to]
                    ]
                ]
            ],
            'from' => [
                'email' => 'noreply@gianni.com.au',
                'name' => 'Gianni Restaurant'
            ],
            'subject' => $subject,
            'content' => [
                [
                    'type' => 'text/html',
                    'value' => $message
                ]
            ]
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $httpCode === 202;
    }
    
    // Method 4: Elastic Email (FREE - 100 emails/day)
    public static function sendViaElasticEmail($to, $subject, $message, $apiKey) {
        $url = "https://api.elasticemail.com/v2/email/send";
        
        $data = [
            'apikey' => $apiKey,
            'from' => 'noreply@gianni.com.au',
            'fromName' => 'Gianni Restaurant',
            'to' => $to,
            'subject' => $subject,
            'bodyHtml' => $message,
            'isTransactional' => true
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $httpCode === 200;
    }
    
    // Method 5: Simple PHP mail() - Works on most servers
    public static function sendViaPHPMail($to, $subject, $message) {
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: Gianni Restaurant <noreply@gianni.com.au>',
            'Reply-To: info@gianni.com.au',
            'X-Mailer: PHP/' . phpversion()
        ];
        
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
}

// Easy setup function
function sendFreeEmail($to, $subject, $message, $method = 'php') {
    $result = false;
    
    switch ($method) {
        case 'gmail':
            // You need to configure Gmail SMTP in your server
            $result = FreeEmailSender::sendViaGmail($to, $subject, $message, 'your-email@gmail.com', 'your-app-password');
            break;
            
        case 'mailgun':
            // Get free account at https://www.mailgun.com/
            $result = FreeEmailSender::sendViaMailgun($to, $subject, $message, 'your-mailgun-api-key', 'your-mailgun-domain');
            break;
            
        case 'sendgrid':
            // Get free account at https://sendgrid.com/
            $result = FreeEmailSender::sendViaSendGrid($to, $subject, $message, 'your-sendgrid-api-key');
            break;
            
        case 'elastic':
            // Get free account at https://elasticemail.com/
            $result = FreeEmailSender::sendViaElasticEmail($to, $subject, $message, 'your-elastic-api-key');
            break;
            
        case 'php':
        default:
            // Uses server's built-in mail function
            $result = FreeEmailSender::sendViaPHPMail($to, $subject, $message);
            break;
    }
    
    // Always save to backup file
    $backupFile = __DIR__ . '/../data/email_backup.html';
    $backupContent = "=== EMAIL SENT ===\n";
    $backupContent .= "To: $to\n";
    $backupContent .= "Subject: $subject\n";
    $backupContent .= "Method: $method\n";
    $backupContent .= "Time: " . date('Y-m-d H:i:s') . "\n";
    $backupContent .= "Status: " . ($result ? 'SENT' : 'FAILED') . "\n";
    $backupContent .= "========================\n\n";
    $backupContent .= $message;
    $backupContent .= "\n\n========================\n\n";
    
    file_put_contents($backupFile, $backupContent, FILE_APPEND);
    
    return $result;
}
?>
