<?php
// Twilio SMS Integration
// Free tier: $15 credit, ~1000 SMS messages

class TwilioSMS {
    private $accountSid;
    private $authToken;
    private $fromNumber;
    
    public function __construct($accountSid, $authToken, $fromNumber) {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->fromNumber = $fromNumber;
    }
    
    public function sendSMS($to, $message) {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->accountSid}/Messages.json";
        
        $data = [
            'From' => $this->fromNumber,
            'To' => $to,
            'Body' => $message
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->accountSid . ':' . $this->authToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 201) {
            $result = json_decode($response, true);
            return [
                'success' => true,
                'message_sid' => $result['sid'] ?? null,
                'status' => $result['status'] ?? 'sent'
            ];
        } else {
            $error = json_decode($response, true);
            return [
                'success' => false,
                'error' => $error['message'] ?? 'SMS sending failed',
                'http_code' => $httpCode
            ];
        }
    }
    
    public function getAccountInfo() {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->accountSid}.json";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->accountSid . ':' . $this->authToken);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            return json_decode($response, true);
        }
        
        return null;
    }
}
?>
