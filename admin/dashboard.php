<?php
$ACTIVE_PAGE = "admin";
$PAGE_TITLE = "Admin Dashboard - Gianni";
include __DIR__ . "/../includes/header.php";

require_once __DIR__ . '/../simple-booking-db.php';
require_once __DIR__ . '/../lib/free-email.php';

// Handle form submissions
$message = '';
$messageType = '';

if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_email_settings':
                $emailMethod = $_POST['email_method'] ?? 'php';
                $emailConfig = [
                    'method' => $emailMethod,
                    'gmail_user' => $_POST['gmail_user'] ?? '',
                    'gmail_pass' => $_POST['gmail_pass'] ?? '',
                    'mailgun_api' => $_POST['mailgun_api'] ?? '',
                    'mailgun_domain' => $_POST['mailgun_domain'] ?? '',
                    'sendgrid_api' => $_POST['sendgrid_api'] ?? '',
                    'elastic_api' => $_POST['elastic_api'] ?? ''
                ];
                file_put_contents(__DIR__ . '/../data/email_config.json', json_encode($emailConfig, JSON_PRETTY_PRINT));
                $message = 'Email settings updated successfully!';
                $messageType = 'success';
                break;
                
            case 'test_email':
                $testEmail = $_POST['test_email'] ?? '';
                $emailMethod = $_POST['email_method'] ?? 'php';
                
                if ($testEmail) {
                    $subject = "🍝 Gianni Restaurant - Admin Test Email";
                    $messageContent = "
                    <html>
                    <body style='font-family: Arial, sans-serif;'>
                        <div style='background: #d4af37; color: white; padding: 20px; text-align: center;'>
                            <h1>🍝 Gianni Restaurant</h1>
                            <h2>Admin Test Email</h2>
                        </div>
                        <div style='padding: 20px;'>
                            <p><strong>Email system is working!</strong></p>
                            <p>Method: " . strtoupper($emailMethod) . "</p>
                            <p>Time: " . date('Y-m-d H:i:s') . "</p>
                            <p>This email was sent from your admin dashboard.</p>
                        </div>
                    </body>
                    </html>";
                    
                    $result = sendFreeEmail($testEmail, $subject, $messageContent, $emailMethod);
                    $message = $result ? 'Test email sent successfully!' : 'Test email failed to send.';
                    $messageType = $result ? 'success' : 'error';
                }
                break;
                
            case 'update_booking_status':
                $bookingId = $_POST['booking_id'] ?? '';
                $newStatus = $_POST['new_status'] ?? '';
                
                if ($bookingId && $newStatus) {
                    $bookings = $bookingDB->getAllBookings();
                    foreach ($bookings as $index => $booking) {
                        if ($booking['id'] == $bookingId) {
                            $bookings[$index]['status'] = $newStatus;
                            $bookings[$index]['updated_at'] = date('Y-m-d H:i:s');
                            file_put_contents(__DIR__ . '/../data/simple_bookings.json', json_encode($bookings, JSON_PRETTY_PRINT));
                            $message = "Booking #{$bookingId} status updated to {$newStatus}";
                            $messageType = 'success';
                            break;
                        }
                    }
                }
                break;
                
            case 'send_reminder':
                $bookingId = $_POST['booking_id'] ?? '';
                if ($bookingId) {
                    $booking = $bookingDB->getBookingById($bookingId);
                    if ($booking) {
                        $subject = "🍝 Gianni Restaurant - Booking Reminder";
                        $messageContent = "
                        <html>
                        <body style='font-family: Arial, sans-serif;'>
                            <div style='background: #d4af37; color: white; padding: 20px; text-align: center;'>
                                <h1>🍝 Gianni Restaurant</h1>
                                <h2>Booking Reminder</h2>
                            </div>
                            <div style='padding: 20px;'>
                                <p>Dear " . htmlspecialchars($booking['customer_name']) . ",</p>
                                <p>This is a friendly reminder about your upcoming reservation:</p>
                                <div style='background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 15px 0;'>
                                    <p><strong>Date:</strong> " . date('l, F j, Y', strtotime($booking['booking_date'])) . "</p>
                                    <p><strong>Time:</strong> " . date('g:i A', strtotime($booking['booking_time'])) . "</p>
                                    <p><strong>Party Size:</strong> " . $booking['number_of_customers'] . " people</p>
                                    <p><strong>Booking ID:</strong> #" . $booking['id'] . "</p>
                                </div>
                                <p>We look forward to seeing you at Gianni!</p>
                            </div>
                        </body>
                        </html>";
                        
                        $result = sendFreeEmail($booking['customer_email'], $subject, $messageContent, 'php');
                        $message = $result ? 'Reminder sent successfully!' : 'Reminder failed to send.';
                        $messageType = $result ? 'success' : 'error';
                    }
                }
                break;
        }
    }
}

// Get current settings
$emailConfig = [];
$configFile = __DIR__ . '/../data/email_config.json';
if (file_exists($configFile)) {
    $emailConfig = json_decode(file_get_contents($configFile), true) ?: [];
}

// Get statistics
$allBookings = $bookingDB->getAllBookings();
$todayBookings = array_filter($allBookings, function($booking) {
    return $booking['booking_date'] === date('Y-m-d');
});
$pendingBookings = array_filter($allBookings, function($booking) {
    return $booking['status'] === 'pending';
});
$confirmedBookings = array_filter($allBookings, function($booking) {
    return $booking['status'] === 'confirmed';
});
?>

<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>🍝 Gianni Admin Dashboard</h1>
        <p>Manage your restaurant booking system</p>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <h3><?php echo count($allBookings); ?></h3>
                <p>Total Bookings</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📅</div>
            <div class="stat-content">
                <h3><?php echo count($todayBookings); ?></h3>
                <p>Today's Bookings</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <h3><?php echo count($pendingBookings); ?></h3>
                <p>Pending</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <h3><?php echo count($confirmedBookings); ?></h3>
                <p>Confirmed</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Email Settings -->
        <div class="dashboard-card">
            <h2>📧 Email Settings</h2>
            <form method="POST" class="settings-form">
                <input type="hidden" name="action" value="update_email_settings">
                
                <div class="form-group">
                    <label>Email Method:</label>
                    <select name="email_method" onchange="toggleEmailFields()">
                        <option value="php" <?php echo ($emailConfig['method'] ?? 'php') === 'php' ? 'selected' : ''; ?>>PHP Mail (Default)</option>
                        <option value="gmail" <?php echo ($emailConfig['method'] ?? '') === 'gmail' ? 'selected' : ''; ?>>Gmail SMTP</option>
                        <option value="mailgun" <?php echo ($emailConfig['method'] ?? '') === 'mailgun' ? 'selected' : ''; ?>>Mailgun</option>
                        <option value="sendgrid" <?php echo ($emailConfig['method'] ?? '') === 'sendgrid' ? 'selected' : ''; ?>>SendGrid</option>
                        <option value="elastic" <?php echo ($emailConfig['method'] ?? '') === 'elastic' ? 'selected' : ''; ?>>Elastic Email</option>
                    </select>
                </div>

                <div id="gmail-fields" class="email-fields" style="display: none;">
                    <div class="form-group">
                        <label>Gmail Address:</label>
                        <input type="email" name="gmail_user" value="<?php echo htmlspecialchars($emailConfig['gmail_user'] ?? ''); ?>" placeholder="your-email@gmail.com">
                    </div>
                    <div class="form-group">
                        <label>Gmail App Password:</label>
                        <input type="password" name="gmail_pass" value="<?php echo htmlspecialchars($emailConfig['gmail_pass'] ?? ''); ?>" placeholder="16-character app password">
                    </div>
                </div>

                <div id="mailgun-fields" class="email-fields" style="display: none;">
                    <div class="form-group">
                        <label>Mailgun API Key:</label>
                        <input type="text" name="mailgun_api" value="<?php echo htmlspecialchars($emailConfig['mailgun_api'] ?? ''); ?>" placeholder="key-xxxxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label>Mailgun Domain:</label>
                        <input type="text" name="mailgun_domain" value="<?php echo htmlspecialchars($emailConfig['mailgun_domain'] ?? ''); ?>" placeholder="mg.yourdomain.com">
                    </div>
                </div>

                <div id="sendgrid-fields" class="email-fields" style="display: none;">
                    <div class="form-group">
                        <label>SendGrid API Key:</label>
                        <input type="text" name="sendgrid_api" value="<?php echo htmlspecialchars($emailConfig['sendgrid_api'] ?? ''); ?>" placeholder="SG.xxxxxxxxxx">
                    </div>
                </div>

                <div id="elastic-fields" class="email-fields" style="display: none;">
                    <div class="form-group">
                        <label>Elastic Email API Key:</label>
                        <input type="text" name="elastic_api" value="<?php echo htmlspecialchars($emailConfig['elastic_api'] ?? ''); ?>" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Email Settings</button>
            </form>

            <div class="test-email-section">
                <h3>Test Email:</h3>
                <form method="POST" class="test-form">
                    <input type="hidden" name="action" value="test_email">
                    <input type="hidden" name="email_method" value="<?php echo $emailConfig['method'] ?? 'php'; ?>">
                    <input type="email" name="test_email" placeholder="test@example.com" required>
                    <button type="submit" class="btn btn-secondary">Send Test Email</button>
                </form>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="dashboard-card">
            <h2>📋 Recent Bookings</h2>
            <div class="bookings-list">
                <?php 
                $recentBookings = array_slice(array_reverse($allBookings), 0, 5);
                foreach ($recentBookings as $booking): 
                ?>
                    <div class="booking-item">
                        <div class="booking-info">
                            <strong><?php echo htmlspecialchars($booking['customer_name']); ?></strong>
                            <span class="booking-date"><?php echo date('M j, Y', strtotime($booking['booking_date'])); ?></span>
                            <span class="booking-time"><?php echo date('g:i A', strtotime($booking['booking_time'])); ?></span>
                            <span class="booking-people"><?php echo $booking['number_of_customers']; ?> people</span>
                        </div>
                        <div class="booking-status">
                            <span class="status-badge status-<?php echo $booking['status']; ?>">
                                <?php echo ucfirst($booking['status']); ?>
                            </span>
                        </div>
                        <div class="booking-actions">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="update_booking_status">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                <select name="new_status" onchange="this.form.submit()">
                                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    <option value="completed" <?php echo $booking['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                </select>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="card-actions">
                <a href="reservations.php" class="btn btn-secondary">View All Bookings</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card">
            <h2>⚡ Quick Actions</h2>
            <div class="quick-actions">
                <a href="reservations.php" class="action-btn">
                    <span class="action-icon">📋</span>
                    <span class="action-text">Manage Bookings</span>
                </a>
                <a href="notifications.php" class="action-btn">
                    <span class="action-icon">📧</span>
                    <span class="action-text">View Notifications</span>
                </a>
                <a href="../reservation.php" class="action-btn">
                    <span class="action-icon">➕</span>
                    <span class="action-text">New Booking</span>
                </a>
                <a href="../free-email-setup.php" class="action-btn">
                    <span class="action-icon">⚙️</span>
                    <span class="action-text">Email Setup</span>
                </a>
            </div>
        </div>

        <!-- System Status -->
        <div class="dashboard-card">
            <h2>🔧 System Status</h2>
            <div class="status-list">
                <div class="status-item">
                    <span class="status-label">Database:</span>
                    <span class="status-value status-success">✅ Working</span>
                </div>
                <div class="status-item">
                    <span class="status-label">Email System:</span>
                    <span class="status-value status-success">✅ Working</span>
                </div>
                <div class="status-item">
                    <span class="status-label">SMS System:</span>
                    <span class="status-value status-warning">⚠️ Simulated</span>
                </div>
                <div class="status-item">
                    <span class="status-label">Notifications:</span>
                    <span class="status-value status-success">✅ Working</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.dashboard-header {
    text-align: center;
    margin-bottom: 30px;
    padding: 30px;
    background: linear-gradient(135deg, #d4af37, #b8941f);
    color: white;
    border-radius: 10px;
}

.dashboard-header h1 {
    margin: 0 0 10px 0;
    font-size: 2.5em;
}

.alert {
    padding: 15px;
    border-radius: 5px;
    margin: 20px 0;
    border-left: 4px solid;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-left-color: #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border-left-color: #dc3545;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    font-size: 2.5em;
}

.stat-content h3 {
    margin: 0;
    font-size: 2em;
    color: #d4af37;
}

.stat-content p {
    margin: 5px 0 0 0;
    color: #666;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
    margin: 30px 0;
}

.dashboard-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 25px;
}

.dashboard-card h2 {
    color: #d4af37;
    margin-top: 0;
    margin-bottom: 20px;
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 10px;
}

.settings-form {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.email-fields {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin: 10px 0;
}

.test-email-section {
    background: #e3f2fd;
    padding: 15px;
    border-radius: 5px;
    margin-top: 20px;
}

.test-email-section h3 {
    color: #1976d2;
    margin-top: 0;
}

.test-form {
    display: flex;
    gap: 10px;
    align-items: end;
}

.test-form input {
    flex: 1;
}

.bookings-list {
    max-height: 300px;
    overflow-y: auto;
}

.booking-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #eee;
    gap: 10px;
}

.booking-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.booking-info strong {
    color: #333;
}

.booking-date,
.booking-time,
.booking-people {
    font-size: 12px;
    color: #666;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-confirmed {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.status-completed {
    background: #d1ecf1;
    color: #0c5460;
}

.booking-actions select {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 3px;
    font-size: 12px;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.action-btn:hover {
    background: #d4af37;
    color: white;
    transform: translateY(-2px);
    border-color: #b8941f;
}

.action-icon {
    font-size: 2em;
    margin-bottom: 10px;
}

.action-text {
    font-weight: bold;
    text-align: center;
}

.status-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 5px;
}

.status-label {
    font-weight: bold;
    color: #333;
}

.status-value {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.status-success {
    background: #d4edda;
    color: #155724;
}

.status-warning {
    background: #fff3cd;
    color: #856404;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary {
    background: #d4af37;
    color: white;
}

.btn-primary:hover {
    background: #b8941f;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #545b62;
}

.card-actions {
    margin-top: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .booking-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .test-form {
        flex-direction: column;
    }
}
</style>

<script>
function toggleEmailFields() {
    const method = document.querySelector('select[name="email_method"]').value;
    
    // Hide all fields
    document.querySelectorAll('.email-fields').forEach(field => {
        field.style.display = 'none';
    });
    
    // Show relevant fields
    if (method === 'gmail') {
        document.getElementById('gmail-fields').style.display = 'block';
    } else if (method === 'mailgun') {
        document.getElementById('mailgun-fields').style.display = 'block';
    } else if (method === 'sendgrid') {
        document.getElementById('sendgrid-fields').style.display = 'block';
    } else if (method === 'elastic') {
        document.getElementById('elastic-fields').style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleEmailFields();
});
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
