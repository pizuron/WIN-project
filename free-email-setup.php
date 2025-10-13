<?php
$ACTIVE_PAGE = "setup";
$PAGE_TITLE = "Free Email Setup";
include __DIR__ . "/includes/header.php";

require_once __DIR__ . '/lib/free-email.php';

// Handle test email
$testResult = null;
if ($_POST && isset($_POST['test_email'])) {
    $to = $_POST['test_email'];
    $method = $_POST['email_method'] ?? 'php';
    
    $subject = "🍝 Gianni Restaurant - Test Email";
    $message = "
    <html>
    <body style='font-family: Arial, sans-serif;'>
        <div style='background: #d4af37; color: white; padding: 20px; text-align: center;'>
            <h1>🍝 Gianni Restaurant</h1>
            <h2>Test Email - FREE Service</h2>
        </div>
        <div style='padding: 20px;'>
            <p><strong>Congratulations!</strong> Your free email service is working!</p>
            <p>This email was sent using: <strong>" . strtoupper($method) . "</strong></p>
            <p>Time: " . date('Y-m-d H:i:s') . "</p>
            <p>If you received this email, your notification system is ready!</p>
        </div>
    </body>
    </html>";
    
    $testResult = sendFreeEmail($to, $subject, $message, $method);
}
?>

<div class="setup-container">
    <div class="setup-header">
        <h1>📧 FREE Email Services Setup</h1>
        <p>Choose from multiple free email services - no credit card required!</p>
    </div>

    <?php if ($testResult !== null): ?>
        <div class="test-result <?php echo $testResult ? 'success' : 'warning'; ?>">
            <h2>Test Result:</h2>
            <p><?php echo $testResult ? '✅ Email sent successfully!' : '❌ Email failed to send'; ?></p>
            <p>Check your email inbox and the backup file at <a href="data/email_backup.html" target="_blank">data/email_backup.html</a></p>
        </div>
    <?php endif; ?>

    <div class="email-services">
        <!-- Method 1: PHP Mail -->
        <div class="service-card">
            <h2>1. 🚀 PHP Mail (Easiest - No Setup Required)</h2>
            <div class="service-info">
                <p><strong>Cost:</strong> FREE</p>
                <p><strong>Setup:</strong> None required - works immediately</p>
                <p><strong>Limits:</strong> Depends on your server</p>
                <p><strong>Best for:</strong> Quick testing and development</p>
            </div>
            <div class="test-form">
                <form method="POST">
                    <input type="hidden" name="email_method" value="php">
                    <label>Test Email Address:</label>
                    <input type="email" name="test_email" placeholder="your-email@example.com" required>
                    <button type="submit" class="btn btn-primary">Test PHP Mail</button>
                </form>
            </div>
        </div>

        <!-- Method 2: Mailgun -->
        <div class="service-card">
            <h2>2. 📬 Mailgun (10,000 emails/month FREE)</h2>
            <div class="service-info">
                <p><strong>Cost:</strong> FREE (10,000 emails/month)</p>
                <p><strong>Setup:</strong> Sign up at <a href="https://www.mailgun.com/" target="_blank">mailgun.com</a></p>
                <p><strong>Limits:</strong> 10,000 emails/month</p>
                <p><strong>Best for:</strong> Production use</p>
            </div>
            <div class="setup-steps">
                <h3>Setup Steps:</h3>
                <ol>
                    <li>Go to <a href="https://www.mailgun.com/" target="_blank">mailgun.com</a></li>
                    <li>Sign up for free account</li>
                    <li>Get your API key and domain</li>
                    <li>Update the code with your credentials</li>
                </ol>
            </div>
        </div>

        <!-- Method 3: SendGrid -->
        <div class="service-card">
            <h2>3. 📧 SendGrid (100 emails/day FREE)</h2>
            <div class="service-info">
                <p><strong>Cost:</strong> FREE (100 emails/day)</p>
                <p><strong>Setup:</strong> Sign up at <a href="https://sendgrid.com/" target="_blank">sendgrid.com</a></p>
                <p><strong>Limits:</strong> 100 emails/day</p>
                <p><strong>Best for:</strong> Small to medium use</p>
            </div>
            <div class="setup-steps">
                <h3>Setup Steps:</h3>
                <ol>
                    <li>Go to <a href="https://sendgrid.com/" target="_blank">sendgrid.com</a></li>
                    <li>Sign up for free account</li>
                    <li>Get your API key</li>
                    <li>Update the code with your API key</li>
                </ol>
            </div>
        </div>

        <!-- Method 4: Elastic Email -->
        <div class="service-card">
            <h2>4. ⚡ Elastic Email (100 emails/day FREE)</h2>
            <div class="service-info">
                <p><strong>Cost:</strong> FREE (100 emails/day)</p>
                <p><strong>Setup:</strong> Sign up at <a href="https://elasticemail.com/" target="_blank">elasticemail.com</a></p>
                <p><strong>Limits:</strong> 100 emails/day</p>
                <p><strong>Best for:</strong> Reliable delivery</p>
            </div>
            <div class="setup-steps">
                <h3>Setup Steps:</h3>
                <ol>
                    <li>Go to <a href="https://elasticemail.com/" target="_blank">elasticemail.com</a></li>
                    <li>Sign up for free account</li>
                    <li>Get your API key</li>
                    <li>Update the code with your API key</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="recommendations">
        <h2>💡 Recommendations:</h2>
        <div class="recommendation-grid">
            <div class="rec-card">
                <h3>For Testing:</h3>
                <p><strong>PHP Mail</strong> - Works immediately, no setup required</p>
            </div>
            <div class="rec-card">
                <h3>For Production:</h3>
                <p><strong>Mailgun</strong> - 10,000 emails/month free, very reliable</p>
            </div>
            <div class="rec-card">
                <h3>For Small Business:</h3>
                <p><strong>SendGrid</strong> - 100 emails/day free, easy setup</p>
            </div>
        </div>
    </div>

    <div class="next-steps">
        <h2>🎯 Next Steps:</h2>
        <ol>
            <li><strong>Test PHP Mail first</strong> - Use the form above</li>
            <li><strong>Check your email inbox</strong> for the test email</li>
            <li><strong>If PHP Mail works</strong> - You're ready to go!</li>
            <li><strong>If you need more emails</strong> - Set up Mailgun or SendGrid</li>
            <li><strong>Make a test booking</strong> at <a href="reservation.php">reservation.php</a></li>
        </ol>
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

.email-services {
    display: grid;
    gap: 30px;
    margin: 30px 0;
}

.service-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    padding: 30px;
    border-left: 4px solid #d4af37;
}

.service-card h2 {
    color: #d4af37;
    margin-top: 0;
    margin-bottom: 20px;
}

.service-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.service-info p {
    margin: 8px 0;
}

.test-form {
    background: #e3f2fd;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.test-form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #1976d2;
}

.test-form input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    background: #d4af37;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn:hover {
    background: #b8941f;
    transform: translateY(-2px);
}

.setup-steps {
    background: #fff3cd;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #ffc107;
}

.setup-steps h3 {
    color: #856404;
    margin-top: 0;
}

.setup-steps ol {
    margin: 10px 0;
    padding-left: 20px;
}

.setup-steps li {
    margin: 8px 0;
}

.setup-steps a {
    color: #856404;
    text-decoration: none;
    font-weight: bold;
}

.setup-steps a:hover {
    text-decoration: underline;
}

.test-result {
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid;
}

.test-result.success {
    background: #d4edda;
    border-left-color: #28a745;
    color: #155724;
}

.test-result.warning {
    background: #fff3cd;
    border-left-color: #ffc107;
    color: #856404;
}

.recommendations {
    background: #e3f2fd;
    padding: 30px;
    border-radius: 10px;
    margin: 30px 0;
}

.recommendations h2 {
    color: #1976d2;
    margin-top: 0;
}

.recommendation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.rec-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.rec-card h3 {
    color: #d4af37;
    margin-top: 0;
}

.next-steps {
    background: #d4edda;
    padding: 30px;
    border-radius: 10px;
    margin: 30px 0;
    border-left: 4px solid #28a745;
}

.next-steps h2 {
    color: #155724;
    margin-top: 0;
}

.next-steps ol {
    margin: 15px 0;
    padding-left: 20px;
}

.next-steps li {
    margin: 10px 0;
    line-height: 1.6;
}

.next-steps a {
    color: #155724;
    text-decoration: none;
    font-weight: bold;
}

.next-steps a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .setup-container {
        padding: 10px;
    }
    
    .setup-header h1 {
        font-size: 2em;
    }
    
    .service-card {
        padding: 20px;
    }
}
</style>

<?php include __DIR__ . "/includes/footer.php"; ?>
