<?php
$PAGE_TITLE = "Contact";
$ACTIVE_PAGE = "contact.php";
include __DIR__ . "/includes/header.php";
?>

<section class="contact-section">
  <div class="contact-container">

    <!-- Left Side: Contact Info -->
    <div class="contact-left">
      <h2>Contact Us</h2>
      <p>We’d love to hear from you! Reach out for reservations, questions, or feedback.</p>

      <div class="info-item">
        <i class="fas fa-map-marker-alt"></i>
        <div>
          <h3>Location</h3>
          <p>60 Alinga Street<br>Canberra, ACT 2601</p>
        </div>
      </div>

      <div class="info-item">
        <i class="fas fa-clock"></i>
        <div>
          <h3>Opening Hours</h3>
          <p>Mon–Sun from 12:00pm<br>Evenings from 5:30pm</p>
        </div>
      </div>

      <div class="info-item">
        <i class="fas fa-phone"></i>
        <div>
          <h3>Contact</h3>
          <a href="tel:+61262485444" class="call-btn">(02) 6248 5444</a>
        </div>
      </div>
    </div>

    <!-- Right Side: Phone Illustration -->
    <div class="contact-right">
      <img src="https://cdn-icons-png.flaticon.com/512/597/597177.png" alt="Phone Illustration" class="phone-img">
    </div>

  </div>
</section>

<style>
.contact-section {
  padding: 80px 20px;
  background: #f5f5f5;
  font-family: 'Helvetica Neue', sans-serif;
}

.contact-container {
  display: flex;
  flex-wrap: wrap;
  gap: 50px;
  max-width: 1000px;
  margin: 0 auto;
  background: #fff;
  padding: 40px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* Left Side */
.contact-left {
  flex: 1;
  min-width: 280px;
}

.contact-left h2 {
  font-size: 32px;
  color: #333;
  margin-bottom: 15px;
}

.contact-left p {
  font-size: 16px;
  color: #555;
  margin-bottom: 30px;
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 15px;
  margin-bottom: 20px;
}

.info-item i {
  font-size: 28px;
  color: #d4af37;
  margin-top: 3px;
}

.info-item h3 {
  margin: 0;
  font-size: 18px;
  color: #333;
}

.info-item p,
.info-item a {
  margin: 5px 0 0;
  font-size: 15px;
  color: #555;
  text-decoration: none;
}

.call-btn {
  display: inline-block;
  margin-top: 5px;
  padding: 6px 12px;
  background: #d4af37;
  color: #fff;
  border-radius: 6px;
  font-weight: 500;
  transition: background 0.3s ease;
}

.call-btn:hover {
  background: #b7952d;
}

/* Right Side Image */
.contact-right {
  flex: 0 0 150px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.phone-img {
  max-width: 120px;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 800px) {
  .contact-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  .contact-right {
    margin-top: 30px;
  }
}
</style>

<!-- Font Awesome CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<?php include __DIR__ . "/includes/footer.php"; ?>
