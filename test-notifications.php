<?php
$ACTIVE_PAGE = "test";
$PAGE_TITLE = "Test Notifications";
include __DIR__ . "/includes/header.php";

// Include the simple email/SMS functions
require_once __DIR__ . '/simple-email-sms.php';

// Handle test request
$result = null;
if ($_POST && isset($_POST['test_notifications'])) {
    $result = testNotifications();
}
?>

<div class="test-container">
    <div class="test-header">
        <h1>🧪 Test Email & SMS Notifications</h1>
        <p>Test if your notification system is working properly</p>
    </div>

    <?php if ($result): ?>
        <div class="test-result <?php echo $result['email_sent'] && $result['sms_sent'] ? 'success' : 'warning'; ?>">
            <h2>Test Results:</h2>
            <ul>
                <li><strong>Email:</strong> <?php echo $result['email_sent'] ? '✅ SENT' : '❌ FAILED'; ?></li>
                <li><strong>SMS:</strong> <?php echo $result['sms_sent'] ? '✅ SENT' : '❌ FAILED'; ?></li>
            </ul>
            <p><?php echo $result['message']; ?></p>
        </div>
    <?php endif; ?>

    <div class="test-actions">
        <form method="POST">
            <button type="submit" name="test_notifications" class="btn btn-primary">
                🚀 Send Test Notifications
            </button>
        </form>
        
        <div class="test-info">
            <h3>What This Test Does:</h3>
            <ul>
                <li>📧 Sends a test email to <code>test@example.com</code></li>
                <li>📱 Sends a test SMS to <code>+61412345678</code></li>
                <li>💾 Saves notifications to backup files</li>
                <li>📊 Shows you the results</li>
            </ul>
        </div>
    </div>

    <div class="file-links">
        <h3>📁 Check Notification Files:</h3>
        <ul>
            <li><a href="data/email_backup.html" target="_blank">📧 View Email Backup</a></li>
            <li><a href="data/sms_backup.txt" target="_blank">📱 View SMS Backup</a></li>
            <li><a href="data/email_sent.html" target="_blank">📧 View All Emails</a></li>
            <li><a href="data/sms_sent.txt" target="_blank">📱 View All SMS</a></li>
        </ul>
    </div>

    <div class="troubleshooting">
        <h3>🔧 Troubleshooting:</h3>
        <div class="troubleshoot-section">
            <h4>If Email is Not Working:</h4>
            <ul>
                <li>Check if your XAMPP server has mail configured</li>
                <li>Look at the backup files to see what was attempted</li>
                <li>For production, configure SMTP settings</li>
            </ul>
        </div>
        
        <div class="troubleshoot-section">
            <h4>If SMS is Not Working:</h4>
            <ul>
                <li>SMS is currently simulated (saved to files)</li>
                <li>For real SMS, configure Twilio or similar service</li>
                <li>Check the backup files to see the SMS content</li>
            </ul>
        </div>
    </div>

    <div class="next-steps">
        <h3>🎯 Next Steps:</h3>
        <ol>
            <li>Run the test above</li>
            <li>Check the backup files to see notifications</li>
            <li>Make a real booking at <a href="reservation.php">reservation.php</a></li>
            <li>Check <a href="admin/notifications.php">admin/notifications.php</a> for logs</li>
        </ol>
    </div>
</div>

<style>
.test-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.test-header {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    background: linear-gradient(135deg, #d4af37, #b8941f);
    color: white;
    border-radius: 10px;
}

.test-header h1 {
    margin: 0 0 10px 0;
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

.test-actions {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 20px 0;
    text-align: center;
}

.btn {
    display: inline-block;
    padding: 15px 30px;
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

.test-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.test-info h3 {
    color: #d4af37;
    margin-top: 0;
}

.test-info ul {
    margin: 10px 0;
    padding-left: 20px;
}

.test-info li {
    margin: 5px 0;
}

.file-links {
    background: #e3f2fd;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.file-links h3 {
    color: #1976d2;
    margin-top: 0;
}

.file-links ul {
    list-style: none;
    padding: 0;
}

.file-links li {
    margin: 10px 0;
}

.file-links a {
    display: inline-block;
    padding: 10px 15px;
    background: white;
    color: #1976d2;
    text-decoration: none;
    border-radius: 5px;
    border: 1px solid #1976d2;
    transition: all 0.3s;
}

.file-links a:hover {
    background: #1976d2;
    color: white;
}

.troubleshooting {
    background: #fff3cd;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #ffc107;
}

.troubleshoot-section {
    margin: 15px 0;
}

.troubleshoot-section h4 {
    color: #856404;
    margin-bottom: 10px;
}

.next-steps {
    background: #d4edda;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #28a745;
}

.next-steps h3 {
    color: #155724;
    margin-top: 0;
}

.next-steps ol {
    margin: 10px 0;
    padding-left: 20px;
}

.next-steps li {
    margin: 8px 0;
}

.next-steps a {
    color: #155724;
    text-decoration: none;
    font-weight: bold;
}

.next-steps a:hover {
    text-decoration: underline;
}

code {
    background: #f8f9fa;
    padding: 2px 6px;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
    color: #e83e8c;
}
</style>

<?php include __DIR__ . "/includes/footer.php"; ?>
