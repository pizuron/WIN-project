<?php
// Notification Configuration
// Free SMS and Email Setup

// TWILIO SMS Configuration (FREE TIER)
define('TWILIO_SID', 'your_twilio_account_sid'); // Get from https://console.twilio.com/
define('TWILIO_TOKEN', 'your_twilio_auth_token'); // Get from https://console.twilio.com/
define('TWILIO_FROM', '+1234567890'); // Your Twilio phone number (free trial number)

// EMAIL Configuration (FREE SMTP)
define('SMTP_HOST', 'smtp.gmail.com'); // Gmail SMTP (free)
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com'); // Your Gmail
define('SMTP_PASSWORD', 'your-app-password'); // Gmail App Password
define('SMTP_FROM_EMAIL', 'your-email@gmail.com');
define('SMTP_FROM_NAME', 'Gianni Restaurant');

// Alternative: Use Mailgun (free tier)
// define('MAILGUN_API_KEY', 'your-mailgun-api-key');
// define('MAILGUN_DOMAIN', 'your-mailgun-domain');

// Alternative: Use SendGrid (free tier)
// define('SENDGRID_API_KEY', 'your-sendgrid-api-key');
?>
