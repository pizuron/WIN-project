<?php
$ACTIVE_PAGE = "admin";
$PAGE_TITLE = "Notifications Log";
include __DIR__ . "/../includes/header.php";
?>

<div class="admin-container">
    <div class="admin-header">
        <h1>📧📱 Notifications Log</h1>
        <div class="admin-actions">
            <a href="reservations.php" class="btn btn-secondary">Back to Reservations</a>
        </div>
    </div>

    <div class="notifications-tabs">
        <button class="tab-btn active" onclick="showTab('emails')">📧 Email Log</button>
        <button class="tab-btn" onclick="showTab('sms')">📱 SMS Log</button>
    </div>

    <!-- Email Log Tab -->
    <div id="emails-tab" class="tab-content active">
        <h2>Email Notifications</h2>
        <?php
        $emailFile = __DIR__ . '/../data/email_log.json';
        $emailLog = [];
        if (file_exists($emailFile)) {
            $emailLog = json_decode(file_get_contents($emailFile), true) ?: [];
        }
        
        if (empty($emailLog)): ?>
            <div class="no-data">
                <p>No email notifications sent yet.</p>
            </div>
        <?php else: ?>
            <div class="log-table">
                <table>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($emailLog) as $email): ?>
                            <tr class="status-<?php echo $email['status']; ?>">
                                <td><?php echo htmlspecialchars($email['timestamp']); ?></td>
                                <td>#<?php echo htmlspecialchars($email['booking_id']); ?></td>
                                <td><?php echo htmlspecialchars($email['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($email['to']); ?></td>
                                <td><?php echo htmlspecialchars($email['subject']); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $email['status']; ?>">
                                        <?php echo ucfirst($email['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- SMS Log Tab -->
    <div id="sms-tab" class="tab-content">
        <h2>SMS Notifications</h2>
        <?php
        $smsFile = __DIR__ . '/../data/sms_log.json';
        $smsLog = [];
        if (file_exists($smsFile)) {
            $smsLog = json_decode(file_get_contents($smsFile), true) ?: [];
        }
        
        if (empty($smsLog)): ?>
            <div class="no-data">
                <p>No SMS notifications sent yet.</p>
            </div>
        <?php else: ?>
            <div class="log-table">
                <table>
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>To</th>
                            <th>Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($smsLog) as $sms): ?>
                            <tr class="status-<?php echo $sms['status']; ?>">
                                <td><?php echo htmlspecialchars($sms['timestamp']); ?></td>
                                <td>#<?php echo htmlspecialchars($sms['booking_id']); ?></td>
                                <td><?php echo htmlspecialchars($sms['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($sms['to']); ?></td>
                                <td class="message-cell"><?php echo nl2br(htmlspecialchars($sms['message'])); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo $sms['status']; ?>">
                                        <?php echo ucfirst($sms['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
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

.notifications-tabs {
    display: flex;
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
}

.tab-btn {
    padding: 12px 24px;
    border: none;
    background: #f8f9fa;
    color: #666;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s;
}

.tab-btn.active {
    background: white;
    color: #d4af37;
    border-bottom-color: #d4af37;
}

.tab-btn:hover {
    background: #e9ecef;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

.log-table {
    overflow-x: auto;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.log-table table {
    width: 100%;
    border-collapse: collapse;
}

.log-table th,
.log-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.log-table th {
    background-color: #d4af37;
    color: white;
    font-weight: bold;
}

.log-table tr:hover {
    background-color: #f8f9fa;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.status-sent {
    background-color: #d4edda;
    color: #155724;
}

.status-failed {
    background-color: #f8d7da;
    color: #721c24;
}

.status-sent {
    background-color: #d4edda;
    color: #155724;
}

.message-cell {
    max-width: 300px;
    word-wrap: break-word;
    font-size: 12px;
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
    
    .log-table {
        font-size: 14px;
    }
    
    .log-table th,
    .log-table td {
        padding: 8px;
    }
    
    .message-cell {
        max-width: 200px;
    }
}
</style>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(tab => tab.classList.remove('active'));
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(btn => btn.classList.remove('active'));
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
