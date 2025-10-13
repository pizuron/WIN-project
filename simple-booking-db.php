<?php
// Simple Booking Database - Stores basic booking information
class SimpleBookingDB {
    private $file;
    
    public function __construct() {
        $this->file = __DIR__ . '/data/simple_bookings.json';
        $this->ensureDataDir();
    }
    
    private function ensureDataDir() {
        $dir = __DIR__ . '/data';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    
    public function saveBooking($customerName, $customerPhone, $customerEmail, $numberOfCustomers, $bookingDate, $bookingTime) {
        // Get existing bookings
        $bookings = $this->getAllBookings();
        
        // Create new booking
        $newBooking = [
            'id' => count($bookings) + 1,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_email' => $customerEmail,
            'number_of_customers' => $numberOfCustomers,
            'booking_date' => $bookingDate,
            'booking_time' => $bookingTime,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 'confirmed'
        ];
        
        // Add to bookings
        $bookings[] = $newBooking;
        
        // Save to file
        file_put_contents($this->file, json_encode($bookings, JSON_PRETTY_PRINT));
        
        return $newBooking;
    }
    
    public function getAllBookings() {
        if (!file_exists($this->file)) {
            return [];
        }
        $data = file_get_contents($this->file);
        return json_decode($data, true) ?: [];
    }
    
    public function getBookingById($id) {
        $bookings = $this->getAllBookings();
        foreach ($bookings as $booking) {
            if ($booking['id'] == $id) {
                return $booking;
            }
        }
        return null;
    }
    
    public function getBookingsByDate($date) {
        $bookings = $this->getAllBookings();
        $result = [];
        foreach ($bookings as $booking) {
            if ($booking['booking_date'] == $date) {
                $result[] = $booking;
            }
        }
        return $result;
    }
}

// Initialize the database
$bookingDB = new SimpleBookingDB();
?>
