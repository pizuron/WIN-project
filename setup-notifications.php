<?php
$ACTIVE_PAGE = "setup";
$PAGE_TITLE = "Setup Real Notifications";
include __DIR__ . "/includes/header.php";
?>

<div class="setup-container">
    <div class="setup-header">
        <h1>🚀 Setup Real SMS & Email Notifications</h1>
        <p>Configure free services to send real SMS and email notifications</p>
    </div>

    <div class="setup-steps">
        <!-- Step 1: Twilio SMS Setup -->
        <div class="setup-step">
            <h2>📱 Step 1: Setup Free SMS with Twilio</h2>
            <div class="step-content">
                <h3>Get Free Twilio Account:</h3>
                <ol>
                    <li>Go to <a href="https://console.twilio.com/" target="_blank">https://console.twilio.com/</a></li>
                    <li>Sign up for a free account (no credit card required)</li>
                    <li>You get <strong>$15 free credit</strong> (~1000 SMS messages)</li>
                    <li>Get a free phone number for sending SMS</li>
                </ol>
                
                <h3>Get Your Credentials:</h3>
                <ul>
                    <li><strong>Account SID:</strong> Found in Twilio Console Dashboard</li>
                    <li><strong>Auth Token:</strong> Found in Twilio Console Dashboard</li>
                    <li><strong>Phone Number:</strong> Your Twilio phone number (e.g., +1234567890)</li>
                </ul>
                
                <div class="config-form">
                    <h3>Update Configuration:</h3>
                    <p>Edit <code>config/notifications.php</code> and replace:</p>
                    <pre><code>define('TWILIO_SID', 'your_twilio_account_sid');
define('TWILIO_TOKEN', 'your_twilio_auth_token');
define('TWILIO_FROM', '+1234567890');</code></pre>
                </div>
            </div>
        </div>

        <!-- Step 2: Email Setup -->
        <div class="setup-step">
            <h2>📧 Step 2: Setup Free Email with Gmail</h2>
            <div class="step-content">
                <h3>Gmail SMTP (Free):</h3>
                <ol>
                    <li>Use your existing Gmail account</li>
                    <li>Enable 2-Factor Authentication</li>
                    <li>Generate an App Password for this application</li>
                </ol>
                
                <h3>Generate App Password:</h3>
                <ol>
                    <li>Go to <a href="https://myaccount.google.com/security" target="_blank">Google Account Security</a></li>
                    <li>Enable 2-Step Verification if not already enabled</li>
                    <li>Go to "App passwords" section</li>
                    <li>Generate a new app password for "Mail"</li>
                    <li>Copy the 16-character password</li>
                </ol>
                
                <div class="config-form">
                    <h3>Update Configuration:</h3>
                    <p>Edit <code>config/notifications.php</code> and replace:</p>
                    <pre><code>define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-16-char-app-password');
define('SMTP_FROM_EMAIL', 'your-email@gmail.com');</code></pre>
                </div>
            </div>
        </div>

        <!-- Step 3: Test -->
        <div class="setup-step">
            <h2>🧪 Step 3: Test Your Setup</h2>
            <div class="step-content">
                <h3>Test Notifications:</h3>
                <ol>
                    <li>Make a test booking at <a href="reservation.php">reservation.php</a></li>
                    <li>Use your real email and phone number</li>
                    <li>Check if you receive the notifications</li>
                    <li>Check the logs at <a href="admin/notifications.php">admin/notifications.php</a></li>
                </ol>
                
                <div class="test-results">
                    <h3>What to Expect:</h3>
                    <ul>
                        <li>✅ <strong>SMS:</strong> You should receive a text message on your phone</li>
                        <li>✅ <strong>Email:</strong> You should receive an email in your inbox</li>
                        <li>✅ <strong>Logs:</strong> Both should show as "sent" in the admin panel</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Alternative Services -->
        <div class="setup-step">
            <h2>🔄 Alternative Free Services</h2>
            <div class="step-content">
                <h3>Email Alternatives:</h3>
                <ul>
                    <li><strong>Mailgun:</strong> 10,000 emails/month free</li>
                    <li><strong>SendGrid:</strong> 100 emails/day free</li>
                    <li><strong>Outlook SMTP:</strong> Similar to Gmail setup</li>
                </ul>
                
                <h3>SMS Alternatives:</h3>
                <ul>
                    <li><strong>AWS SNS:</strong> $0.75 per 100 SMS</li>
                    <li><strong>TextMagic:</strong> Free trial available</li>
                    <li><strong>MessageBird:</strong> Free tier available</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="setup-footer">
        <h3>🎉 Ready to Test?</h3>
        <p>Once you've configured the services above, make a test booking to see real notifications in action!</p>
        <a href="reservation.php" class="btn btn-primary">Make Test Booking</a>
        <a href="admin/notifications.php" class="btn btn-secondary">View Notification Logs</a>
    </div>
</div>

<style>
.setup-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.setup-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 30px;
    background: linear-gradient(135deg, #d4af37, #b8941f);
    color: white;
    border-radius: 10px;
}

.setup-header h1 {
    margin: 0 0 10px 0;
    font-size: 2.5em;
}

.setup-header p {
    margin: 0;
    font-size: 1.2em;
    opacity: 0.9;
}

.setup-step {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    overflow: hidden;
}

.setup-step h2 {
    background: #f8f9fa;
    margin: 0;
    padding: 20px;
    color: #333;
    border-bottom: 1px solid #dee2e6;
}

.step-content {
    padding: 30px;
}

.step-content h3 {
    color: #d4af37;
    margin-top: 25px;
    margin-bottom: 15px;
}

.step-content ol,
.step-content ul {
    margin: 15px 0;
    padding-left: 25px;
}

.step-content li {
    margin: 8px 0;
    line-height: 1.6;
}

.step-content a {
    color: #d4af37;
    text-decoration: none;
    font-weight: bold;
}

.step-content a:hover {
    text-decoration: underline;
}

.config-form {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #d4af37;
}

.config-form pre {
    background: #2d3748;
    color: #e2e8f0;
    padding: 15px;
    border-radius: 5px;
    overflow-x: auto;
    margin: 10px 0;
}

.test-results {
    background: #d4edda;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #28a745;
    margin: 20px 0;
}

.setup-footer {
    text-align: center;
    background: #e3f2fd;
    padding: 30px;
    border-radius: 10px;
    margin-top: 30px;
}

.setup-footer h3 {
    color: #1976d2;
    margin: 0 0 15px 0;
}

.setup-footer p {
    margin: 0 0 20px 0;
    color: #666;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    margin: 5px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary {
    background: #d4af37;
    color: white;
}

.btn-primary:hover {
    background: #b8941f;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .setup-container {
        padding: 10px;
    }
    
    .setup-header h1 {
        font-size: 2em;
    }
    
    .step-content {
        padding: 20px;
    }
    
    .config-form pre {
        font-size: 12px;
    }
}
</style>

<?php include __DIR__ . "/includes/footer.php"; ?>
