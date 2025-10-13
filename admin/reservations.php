<?php
$ACTIVE_PAGE = "admin";
$PAGE_TITLE = "Reservations";
include __DIR__ . "/../includes/header.php";

// Include simple database
require_once __DIR__ . '/../simple-booking-db.php';

// Handle status updates
if ($_POST && isset($_POST['action']) && isset($_POST['reservation_id'])) {
    $reservation_id = intval($_POST['reservation_id']);
    $action = $_POST['action'];
    
    $valid_actions = ['confirm', 'cancel', 'complete'];
    if (in_array($action, $valid_actions)) {
        $status_map = [
            'confirm' => 'confirmed',
            'cancel' => 'cancelled',
            'complete' => 'completed'
        ];
        
        // Update status in simple booking database
        $bookings = $bookingDB->getAllBookings();
        foreach ($bookings as $index => $booking) {
            if ($booking['id'] == $reservation_id) {
                $bookings[$index]['status'] = $status_map[$action];
                file_put_contents(__DIR__ . '/../data/simple_bookings.json', json_encode($bookings, JSON_PRETTY_PRINT));
                break;
            }
        }
        $message = "Reservation " . $action . "ed successfully";
    }
}

// Get reservations
$filter = $_GET['filter'] ?? 'all';
$date_filter = $_GET['date'] ?? '';

$allReservations = $bookingDB->getAllBookings();
$reservations = [];

foreach ($allReservations as $index => $reservation) {
    // Apply filters
    if ($filter !== 'all' && $reservation['status'] !== $filter) {
        continue;
    }
    
    if ($date_filter && $reservation['booking_date'] !== $date_filter) {
        continue;
    }
    
    // Add index for admin operations
    $reservation['id'] = $index;
    $reservations[] = $reservation;
}

// Sort by date and time
usort($reservations, function($a, $b) {
    $dateCompare = strcmp($b['booking_date'], $a['booking_date']);
    if ($dateCompare === 0) {
        return strcmp($b['booking_time'], $a['booking_time']);
    }
    return $dateCompare;
});
?>

<div class="admin-container">
  <div class="admin-header">
    <h1>Reservation Management</h1>
        <div class="admin-actions">
          <a href="dashboard.php" class="btn btn-primary">Admin Dashboard</a>
          <a href="notifications.php" class="btn btn-secondary">View Notifications</a>
          <a href="view-notifications.php" class="btn btn-secondary">View Sent Messages</a>
      <a href="?filter=all" class="btn <?php echo $filter === 'all' ? 'active' : ''; ?>">All</a>
      <a href="?filter=pending" class="btn <?php echo $filter === 'pending' ? 'active' : ''; ?>">Pending</a>
      <a href="?filter=confirmed" class="btn <?php echo $filter === 'confirmed' ? 'active' : ''; ?>">Confirmed</a>
      <a href="?filter=cancelled" class="btn <?php echo $filter === 'cancelled' ? 'active' : ''; ?>">Cancelled</a>
    </div>
  </div>

  <?php if (isset($message)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <div class="reservations-table">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Time</th>
          <th>Customer</th>
          <th>Party Size</th>
          <th>Service</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $reservation): ?>
          <tr class="reservation-row status-<?php echo $reservation['status']; ?>">
            <td><?php echo date('M j, Y', strtotime($reservation['booking_date'])); ?></td>
            <td><?php echo date('g:i A', strtotime($reservation['booking_time'])); ?></td>
            <td>
              <div class="customer-info">
                <strong><?php echo htmlspecialchars($reservation['customer_name']); ?></strong>
                <br>
                <small><?php echo htmlspecialchars($reservation['customer_email']); ?></small>
                <?php if ($reservation['customer_phone']): ?>
                  <br>
                  <small><?php echo htmlspecialchars($reservation['customer_phone']); ?></small>
                <?php endif; ?>
              </div>
            </td>
            <td><?php echo $reservation['number_of_customers']; ?> people</td>
            <td><?php echo date('H:i', strtotime($reservation['booking_time'])) >= '17:30' ? 'Dinner' : 'Lunch'; ?></td>
            <td>
              <span class="status-badge status-<?php echo $reservation['status']; ?>">
                <?php echo ucfirst($reservation['status']); ?>
              </span>
            </td>
            <td>
              <div class="action-buttons">
                <?php if ($reservation['status'] === 'pending'): ?>
                  <form method="POST" style="display: inline;">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <input type="hidden" name="action" value="confirm">
                    <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                  </form>
                <?php endif; ?>
                
                <?php if ($reservation['status'] !== 'cancelled' && $reservation['status'] !== 'completed'): ?>
                  <form method="POST" style="display: inline;">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <input type="hidden" name="action" value="cancel">
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this reservation?')">Cancel</button>
                  </form>
                <?php endif; ?>
                
                <?php if ($reservation['status'] === 'confirmed'): ?>
                  <form method="POST" style="display: inline;">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    <input type="hidden" name="action" value="complete">
                    <button type="submit" class="btn btn-sm btn-primary">Complete</button>
                  </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          
          <?php if ($reservation['special_requests']): ?>
            <tr class="special-requests">
              <td colspan="7">
                <strong>Special Requests:</strong> <?php echo htmlspecialchars($reservation['special_requests']); ?>
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
    
    <?php if (empty($reservations)): ?>
      <div class="no-reservations">
        <p>No reservations found.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<style>
.admin-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.admin-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.admin-header h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem;
  color: #2c2c2c;
}

.admin-actions {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  text-decoration: none;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn.active {
  background: #d4af37;
  color: #fff;
}

.btn:not(.active) {
  background: #f5f5f5;
  color: #666;
}

.btn:hover {
  opacity: 0.8;
}

.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.8rem;
}

.btn-success {
  background: #28a745;
  color: #fff;
}

.btn-danger {
  background: #dc3545;
  color: #fff;
}

.btn-primary {
  background: #007bff;
  color: #fff;
}

.alert {
  padding: 1rem;
  margin-bottom: 1rem;
  border-radius: 4px;
}

.alert-success {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.reservations-table {
  background: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #e5e5e5;
}

th {
  background: #f8f9fa;
  font-weight: 600;
  color: #2c2c2c;
}

.reservation-row:hover {
  background: #f8f9fa;
}

.customer-info {
  line-height: 1.4;
}

.status-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
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

.action-buttons {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.special-requests {
  background: #f8f9fa;
}

.special-requests td {
  padding: 0.5rem 1rem;
  font-size: 0.9rem;
  color: #666;
}

.no-reservations {
  text-align: center;
  padding: 3rem;
  color: #666;
}

@media (max-width: 768px) {
  .admin-container {
    padding: 1rem;
  }
  
  .admin-header {
    flex-direction: column;
    align-items: flex-start;
  }
  
  table {
    font-size: 0.9rem;
  }
  
  th, td {
    padding: 0.5rem;
  }
  
  .action-buttons {
    flex-direction: column;
  }
}
</style>

<?php include __DIR__ . "/../includes/footer.php"; ?>
