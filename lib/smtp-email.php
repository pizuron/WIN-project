<?php
// SMTP Email Integration
// Free with Gmail, Outlook, etc.

class SMTPEmail {
    private $host;
    private $port;
    private $username;
    private $password;
    private $fromEmail;
    private $fromName;
    
    public function __construct($host, $port, $username, $password, $fromEmail, $fromName) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }
    
    public function sendEmail($to, $subject, $message, $isHTML = true) {
        // Create SMTP connection
        $smtp = $this->createSMTPConnection();
        
        if (!$smtp) {
            return [
                'success' => false,
                'error' => 'Failed to connect to SMTP server'
            ];
        }
        
        try {
            // Send EHLO
            $this->sendCommand($smtp, "EHLO " . $_SERVER['HTTP_HOST']);
            
            // Start TLS if needed
            if ($this->port == 587) {
                $this->sendCommand($smtp, "STARTTLS");
                stream_socket_enable_crypto($smtp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                $this->sendCommand($smtp, "EHLO " . $_SERVER['HTTP_HOST']);
            }
            
            // Authenticate
            $this->sendCommand($smtp, "AUTH LOGIN");
            $this->sendCommand($smtp, base64_encode($this->username));
            $this->sendCommand($smtp, base64_encode($this->password));
            
            // Send email
            $this->sendCommand($smtp, "MAIL FROM: <{$this->fromEmail}>");
            $this->sendCommand($smtp, "RCPT TO: <{$to}>");
            $this->sendCommand($smtp, "DATA");
            
            $headers = [
                "From: {$this->fromName} <{$this->fromEmail}>",
                "To: {$to}",
                "Subject: {$subject}",
                "MIME-Version: 1.0",
                "Content-Type: " . ($isHTML ? "text/html" : "text/plain") . "; charset=UTF-8",
                "X-Mailer: PHP/" . phpversion()
            ];
            
            $emailData = implode("\r\n", $headers) . "\r\n\r\n" . $message . "\r\n.";
            $this->sendCommand($smtp, $emailData);
            
            // Quit
            $this->sendCommand($smtp, "QUIT");
            fclose($smtp);
            
            return [
                'success' => true,
                'message' => 'Email sent successfully'
            ];
            
        } catch (Exception $e) {
            fclose($smtp);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    private function createSMTPConnection() {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        
        $smtp = stream_socket_client(
            "tcp://{$this->host}:{$this->port}",
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT,
            $context
        );
        
        if (!$smtp) {
            return false;
        }
        
        // Read initial response
        $response = fgets($smtp);
        if (substr($response, 0, 3) !== '220') {
            return false;
        }
        
        return $smtp;
    }
    
    private function sendCommand($smtp, $command) {
        fwrite($smtp, $command . "\r\n");
        $response = fgets($smtp);
        
        if (substr($response, 0, 3) !== '250' && substr($response, 0, 3) !== '354') {
            throw new Exception("SMTP Error: " . trim($response));
        }
        
        return $response;
    }
}
?>
