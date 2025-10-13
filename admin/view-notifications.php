<?php
$ACTIVE_PAGE = "admin";
$PAGE_TITLE = "View Notifications";
include __DIR__ . "/../includes/header.php";
?>

<div class="admin-container">
    <div class="admin-header">
        <h1>📧📱 View Sent Notifications</h1>
        <div class="admin-actions">
            <a href="reservations.php" class="btn btn-secondary">Back to Reservations</a>
        </div>
    </div>

    <div class="notifications-view">
        <!-- Email Notifications -->
        <div class="notification-section">
            <h2>📧 Email Notifications</h2>
            <?php
            $emailFile = __DIR__ . '/../data/email_sent.html';
            if (file_exists($emailFile)): ?>
                <div class="notification-content">
                    <h3>Latest Email Sent:</h3>
                    <div class="email-preview">
                        <pre><?php echo htmlspecialchars(file_get_contents($emailFile)); ?></pre>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <p>No emails sent yet.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- SMS Notifications -->
        <div class="notification-section">
            <h2>📱 SMS Notifications</h2>
            <?php
            $smsFile = __DIR__ . '/../data/sms_sent.txt';
            if (file_exists($smsFile)): ?>
                <div class="notification-content">
                    <h3>Latest SMS Sent:</h3>
                    <div class="sms-preview">
                        <pre><?php echo htmlspecialchars(file_get_contents($smsFile)); ?></pre>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <p>No SMS sent yet.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Instructions -->
        <div class="instructions-section">
            <h2>ℹ️ How to Test Notifications</h2>
            <div class="instructions">
                <h3>To see notifications working:</h3>
                <ol>
                    <li>Go to <a href="../reservation.php" target="_blank">Make a Reservation</a></li>
                    <li>Fill out the form with your real email and phone number</li>
                    <li>Submit the booking</li>
                    <li>Check this page to see the notifications that were "sent"</li>
                    <li>Check your email inbox (if SMTP is configured)</li>
                </ol>
                
                <h3>For Production:</h3>
                <ul>
                    <li><strong>Email:</strong> Configure SMTP settings in your server</li>
                    <li><strong>SMS:</strong> Integrate with Twilio, AWS SNS, or similar service</li>
                    <li><strong>Current:</strong> Notifications are logged and saved to files for testing</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.admin-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #d4af37;
}

.admin-header h1 {
    color: #d4af37;
    margin: 0;
}

.notification-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    padding: 20px;
}

.notification-section h2 {
    color: #d4af37;
    margin-top: 0;
    margin-bottom: 20px;
}

.notification-content h3 {
    color: #333;
    margin-bottom: 15px;
}

.email-preview,
.sms-preview {
    background: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    max-height: 400px;
    overflow-y: auto;
}

.email-preview pre,
.sms-preview pre {
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: 'Courier New', monospace;
    font-size: 12px;
    line-height: 1.4;
}

.instructions-section {
    background: #e3f2fd;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid #2196f3;
}

.instructions h3 {
    color: #1976d2;
    margin-top: 0;
}

.instructions ol,
.instructions ul {
    margin: 15px 0;
    padding-left: 20px;
}

.instructions li {
    margin: 8px 0;
    line-height: 1.5;
}

.instructions a {
    color: #1976d2;
    text-decoration: none;
    font-weight: bold;
}

.instructions a:hover {
    text-decoration: underline;
}

.no-data {
    text-align: center;
    padding: 40px;
    background: #f8f9fa;
    border-radius: 8px;
    color: #666;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .email-preview,
    .sms-preview {
        font-size: 10px;
    }
}
</style>

<?php include __DIR__ . "/../includes/footer.php"; ?>
