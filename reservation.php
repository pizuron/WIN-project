<?php 
$ACTIVE_PAGE = "reservation.php"; 
$PAGE_TITLE = "Reservations";
include __DIR__ . "/includes/header.php"; 
?>

<div class="reservation-container">
  <div class="reservation-header">
    <h1>Make a Reservation</h1>
    <p>Book your table at GIANI for an unforgettable Italian dining experience</p>
  </div>

  <div class="reservation-form-container">
    <form id="reservationForm" class="reservation-form">
      <!-- Step 1: Date & Time Selection -->
      <div class="form-step active" id="step1">
        <h2>Select Date & Time</h2>
        
        <!-- Party Size -->
        <div class="form-group">
          <label class="form-label">How many people?</label>
          <div class="party-size-options">
            <button type="button" class="party-btn" data-size="2">2</button>
            <button type="button" class="party-btn" data-size="4">4</button>
            <button type="button" class="party-btn" data-size="6">6</button>
            <button type="button" class="party-btn" data-size="8">8</button>
            <button type="button" class="party-btn" data-size="10">10</button>
            <button type="button" class="party-btn" data-size="12">12</button>
          </div>
          <div class="custom-party">
            <label for="customPartySize">Or enter custom number:</label>
            <input type="number" id="customPartySize" name="partySize" min="1" max="30" value="2">
          </div>
          <div class="large-group-notice" id="largeGroupNotice" style="display: none;">
            <p><strong>Special Menu Notice:</strong> For parties of 8 or more, our special banquet menus will apply.</p>
          </div>
        </div>

        <!-- Date Selection -->
        <div class="form-group">
          <label class="form-label">Choose your date</label>
          <div class="date-options">
            <div class="quick-dates">
              <button type="button" class="date-btn" data-date="">Today</button>
              <button type="button" class="date-btn" data-date="">Tomorrow</button>
              <button type="button" class="date-btn" data-date="">This Weekend</button>
            </div>
            <div class="custom-date">
              <label for="reservationDate">Or select a specific date:</label>
              <input type="date" id="reservationDate" name="date" min="<?php echo date('Y-m-d'); ?>">
            </div>
          </div>
        </div>

        <!-- Service Selection -->
        <div class="form-group" id="serviceSelection" style="display: none;">
          <label class="form-label">Choose your dining time</label>
          <div class="service-options">
            <button type="button" class="service-btn" data-service="lunch">
              <span class="service-icon">🌞</span>
              <span class="service-name">Lunch</span>
              <span class="service-time">12:00 PM - 2:00 PM</span>
            </button>
            <button type="button" class="service-btn" data-service="dinner">
              <span class="service-icon">🌙</span>
              <span class="service-name">Dinner</span>
              <span class="service-time">5:30 PM - 8:20 PM</span>
            </button>
          </div>
        </div>

        <!-- Time Selection -->
        <div class="form-group" id="timeSelection" style="display: none;">
          <label class="form-label">Select your time</label>
          <div class="time-options">
            <!-- Time slots will be populated by JavaScript -->
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-primary" id="nextStep1">Continue</button>
        </div>
      </div>

      <!-- Step 2: Contact Details -->
      <div class="form-step" id="step2">
        <h2>Your Details</h2>
        
        <div class="form-group">
          <label for="customerName" class="form-label">Full Name *</label>
          <input type="text" id="customerName" name="customerName" required>
        </div>

        <div class="form-group">
          <label for="customerEmail" class="form-label">Email Address *</label>
          <input type="email" id="customerEmail" name="customerEmail" required>
        </div>

        <div class="form-group">
          <label for="customerPhone" class="form-label">Phone Number</label>
          <input type="tel" id="customerPhone" name="customerPhone" placeholder="+61 4XX XXX XXX">
        </div>

        <div class="form-group">
          <label for="specialRequests" class="form-label">Special Requests</label>
          <textarea id="specialRequests" name="specialRequests" rows="3" placeholder="Any dietary requirements, celebrations, or special requests..."></textarea>
        </div>

        <!-- Booking Summary -->
        <div class="booking-summary">
          <h3>Booking Summary</h3>
          <div class="summary-details">
            <div class="summary-item">
              <span class="label">Date:</span>
              <span class="value" id="summaryDate">-</span>
            </div>
            <div class="summary-item">
              <span class="label">Time:</span>
              <span class="value" id="summaryTime">-</span>
            </div>
            <div class="summary-item">
              <span class="label">Party Size:</span>
              <span class="value" id="summaryParty">-</span>
            </div>
            <div class="summary-item">
              <span class="label">Service:</span>
              <span class="value" id="summaryService">-</span>
            </div>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-secondary" id="backStep1">Back</button>
          <button type="button" class="btn btn-primary" id="nextStep2">Continue</button>
        </div>
      </div>

      <!-- Step 3: Confirmation -->
      <div class="form-step" id="step3">
        <div class="confirmation-container">
          <div class="confirmation-header">
            <div class="success-icon">🍝</div>
            <h2>Prenotazione Confermata!</h2>
            <p>Grazie mille! Il vostro tavolo è stato prenotato con successo presso Gianni.</p>
            <p>Benvenuti nella nostra famiglia italiana! 🇮🇹</p>
          </div>

          <div class="confirmation-details">
            <div class="detail-card">
              <h3>Booking Details</h3>
              <div class="detail-item">
                <span class="label">Date:</span>
                <span class="value" id="confirmDate">-</span>
              </div>
              <div class="detail-item">
                <span class="label">Time:</span>
                <span class="value" id="confirmTime">-</span>
              </div>
              <div class="detail-item">
                <span class="label">Number of People:</span>
                <span class="value" id="confirmParty">-</span>
              </div>
              <div class="detail-item">
                <span class="label">Name:</span>
                <span class="value" id="confirmName">-</span>
              </div>
              <div class="detail-item">
                <span class="label">Service:</span>
                <span class="value" id="confirmService">-</span>
              </div>
              <div class="detail-item">
                <span class="label">Booking ID:</span>
                <span class="value" id="confirmCode">-</span>
              </div>
            </div>

            <div class="notification-card">
              <h3>What Happens Next?</h3>
              <p>📧 A confirmation email has been sent to your email address</p>
              <p id="smsNotification" style="display: none;">📱 A confirmation SMS has been sent to your phone with all details</p>
              <p>📅 You can manage your booking using the link in the email</p>
              <p>🍝 We look forward to welcoming you to Gianni!</p>
            </div>
          </div>

          <div class="confirmation-actions">
            <button type="button" class="btn btn-primary" id="newReservation">Make Another Booking</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back to Home</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Special Menu Popup for Large Groups -->
<div id="menuModal" class="modal">
  <div class="modal-content">
    <span class="close-button">&times;</span>
    <h2>Special Menu Options</h2>
    <p class="modal-description">For parties of <span id="modalPartySize"></span> people, please select your preferred menu:</p>
    
    <div class="menu-options">
      <!-- Lunch Banquet Option -->
      <div class="menu-card" data-menu="lunch-banquet">
        <h3>LUNCH BANQUET</h3>
        <p class="price">$38 pp</p>
        <p class="note">20 PERSON LIMIT | LUNCH ONLY</p>
        <div class="menu-details">
          <h4>STARTER:</h4>
          <ul>
            <li>GARLIC BREAD</li>
          </ul>
          <h4>PIZZA + SALAD:</h4>
          <ul>
            <li>SELECTION OF PIZZAS</li>
            <li>ROCKET SALAD / SHAVED PARMESAN / FRESH PEAR / BALSAMIC GLAZE</li>
          </ul>
          <h4>PASTA:</h4>
          <ul>
            <li>CHOOSE ONE PASTA:</li>
            <li>SPAGHETTI 'CACIO E PEPE' / PECORINO / BLACK PEPPER</li>
            <li>PENNE DIAVOLA / CHILLI / CREAMY TOMATO 'MACCHIATO' SAUCE</li>
            <li>SPAGHETTI 'AGLIO OLIO' / GARLIC / FRESH CHILLI / CHERRY TOMATO / PANGRATTATO</li>
            <li>RIGATONI PESTO / BASIL PESTO / GARLIC CREAM SAUCE / SHAVED PARMESAN</li>
          </ul>
          <p class="addon">// CHOOSE TWO PASTAS ADD $5pp</p>
          <p class="addon">//add chicken or pancetta $3pp per pasta</p>
        </div>
        <button type="button" class="select-menu-btn">Select Lunch Banquet</button>
      </div>

      <!-- Pizza & Pasta Banquet Option -->
      <div class="menu-card" data-menu="pizza-pasta-banquet">
        <h3>PIZZA AND PASTA BANQUET</h3>
        <p class="price">$50 pp</p>
        <div class="menu-details">
          <h4>STARTER:</h4>
          <ul>
            <li>BRUSCHETTA / WHIPPED RICOTTA / HEIRLOOM TOMATO / BASIL / FIG GLAZE</li>
          </ul>
          <h4>PIZZA + SALAD:</h4>
          <ul>
            <li>SELECTION OF PIZZAS</li>
            <li>ROCKET SALAD / SHAVED PARMESAN / FRESH PEAR / BALSAMIC GLAZE</li>
          </ul>
          <h4>PASTA + GNOCCHI:</h4>
          <ul>
            <li>RIGATONI / CHICKEN BREAST / PANCETTA / ROASTED PEPPERS / GARLIC / NAPOLI SUGO</li>
            <li>GNOCCHI / GORGONZOLA / BABY SPINACH / CREAM / SHAVED PARMESAN {v}</li>
          </ul>
        </div>
        <button type="button" class="select-menu-btn">Select Pizza & Pasta Banquet</button>
      </div>

      <!-- Three Course Banquet Option -->
      <div class="menu-card" data-menu="three-course-banquet">
        <h3>THREE COURSE BANQUET</h3>
        <p class="price">$65 pp</p>
        <div class="menu-details">
          <h4>ANTIPASTO:</h4>
          <ul>
            <li>WARM PANE DI CASA / EVO OIL</li>
            <li>ANTIPASTO BOARDS / LOCAL SALUME / PROSCIUTTO / GIARDINIERA / OLIVES</li>
            <li>SEA SALT CALAMARETTI / LEMON / GORGONZOLA MAIONESE</li>
          </ul>
          <h4>PIZZA + SALAD:</h4>
          <ul>
            <li>SELECTION OF PIZZAS</li>
            <li>ROCKET SALAD / SHAVED PARMESAN / FRESH PEAR / BALSAMIC GLAZE</li>
          </ul>
          <h4>PASTA + MAINS:</h4>
          <ul>
            <li>LINGUINE ALLA NORMA / GRILLED EGGPLANT / SPICY ARRABBIATA SUGO / RICOTTA / BASIL</li>
            <li>CHICKEN BREAST FILLETS / MARSALA / MUSHROOM / SHALLOTS / GARLIC CREAM SAUCE</li>
            <li>CHAT POTATO / ROAST VEG</li>
          </ul>
        </div>
        <button type="button" class="select-menu-btn">Select Three Course Banquet</button>
      </div>

      <!-- Ten Course Tasting Menu Option -->
      <div class="menu-card" data-menu="ten-course-tasting">
        <h3>TEN COURSE ASSAGGINI MENU</h3>
        <p class="price">$90 pp | MIN 4 ppl</p>
        <p class="note">{includes bottomless san pellegrino mineral water}</p>
        <div class="menu-details">
          <h4>TASTING MENU:</h4>
          <ul>
            <li>CALAMARETTI / ROCKET / GORGONZOLA MAIONESE</li>
            <li>ARANCINI / MUSHROOM & FONTINA RISOTTO BALLS / ROAST CAPSICUM SUGO</li>
            <li>POLPETTE / VEAL & PORK MEATBALLS / SHAVED PARMESAN</li>
            <li>BURRATA / HEIRLOOM TOMATO / BASIL / FIG & BALSAMIC GLAZE</li>
            <li>KING PRAWNS / CHILLI / FREGOLA / BRANDY MACCHIATO SUGO</li>
            <li>RUCOLA / ROCKET SALAD / SHAVED PECORINO / FRESH PEAR / BALSAMIC GLAZE</li>
            <li>RAVIOLI DEL GIORNO / RAVIOLI OF THE DAY</li>
            <li>EGG PAPPARDELLE / SLOW COOKED THREE-MEAT RAGU / BASIL</li>
            <li>VEAL SALTIMBOCCA / PROSCIUTTO / SAGE / GARLIC / VINO BIANCO s/w CHAT POTATO / ROAST VEG</li>
            <li>SELECT ANY DESSERT</li>
          </ul>
        </div>
        <button type="button" class="select-menu-btn">Select Ten Course Tasting</button>
      </div>
    </div>
    
    <div class="modal-actions">
      <button type="button" class="btn btn-secondary" id="backToPartySize">Back to Party Size</button>
      <button type="button" class="btn btn-primary" id="confirmMenuSelection" disabled>Continue with Selected Menu</button>
    </div>
  </div>
</div>

<style>
.reservation-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
}

.reservation-header {
  text-align: center;
  margin-bottom: 3rem;
}

.reservation-header h1 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.5rem;
  font-weight: 700;
  color: #2c2c2c;
  margin-bottom: 1rem;
}

.reservation-header p {
  font-size: 1.1rem;
  color: #666;
  max-width: 600px;
  margin: 0 auto;
}

.reservation-form-container {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  overflow: hidden;
}

.form-step {
  padding: 2rem;
  display: none;
}

.form-step.active {
  display: block;
}

.form-step h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.8rem;
  font-weight: 600;
  color: #2c2c2c;
  margin-bottom: 2rem;
  text-align: center;
}

.form-group {
  margin-bottom: 2rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #2c2c2c;
  margin-bottom: 1rem;
  font-size: 1.1rem;
}

.party-size-options {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
  gap: 1rem;
  margin-bottom: 1rem;
}

.party-btn {
  padding: 1rem;
  border: 2px solid #e5e5e5;
  background: #fff;
  border-radius: 8px;
  font-size: 1.2rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.party-btn:hover {
  border-color: #d4af37;
  background: #faf9f6;
}

.party-btn.selected {
  border-color: #d4af37;
  background: #d4af37;
  color: #fff;
}

.custom-party {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid #e5e5e5;
}

.custom-party input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e5e5e5;
  border-radius: 8px;
  font-size: 1rem;
}

.large-group-notice {
  background: #fff3cd;
  border: 1px solid #ffeaa7;
  border-radius: 8px;
  padding: 1rem;
  margin-top: 1rem;
}

.large-group-notice p {
  margin: 0;
  color: #856404;
  font-weight: 500;
}

.date-options {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.quick-dates {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.date-btn {
  padding: 0.75rem 1.5rem;
  border: 2px solid #e5e5e5;
  background: #fff;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.date-btn:hover {
  border-color: #d4af37;
  background: #faf9f6;
}

.date-btn.selected {
  border-color: #d4af37;
  background: #d4af37;
  color: #fff;
}

.custom-date input {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e5e5e5;
  border-radius: 8px;
  font-size: 1rem;
}

.service-options {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.service-btn {
  padding: 1.5rem;
  border: 2px solid #e5e5e5;
  background: #fff;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
}

.service-btn:hover {
  border-color: #d4af37;
  background: #faf9f6;
  transform: translateY(-2px);
}

.service-btn.selected {
  border-color: #d4af37;
  background: #d4af37;
  color: #fff;
}

.service-icon {
  font-size: 2rem;
  display: block;
  margin-bottom: 0.5rem;
}

.service-name {
  display: block;
  font-weight: 600;
  font-size: 1.1rem;
  margin-bottom: 0.25rem;
}

.service-time {
  display: block;
  font-size: 0.9rem;
  opacity: 0.8;
}

.time-options {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  gap: 0.5rem;
}

.time-btn {
  padding: 0.75rem;
  border: 2px solid #e5e5e5;
  background: #fff;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  font-size: 0.9rem;
}

.time-btn:hover {
  border-color: #d4af37;
  background: #faf9f6;
}

.time-btn.selected {
  border-color: #d4af37;
  background: #d4af37;
  color: #fff;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
}

.btn {
  padding: 0.75rem 2rem;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-block;
  text-align: center;
}

.btn-primary {
  background: #d4af37;
  color: #fff;
}

.btn-primary:hover {
  background: #b8941f;
  transform: translateY(-2px);
}

.btn-secondary {
  background: #f5f5f5;
  color: #666;
  border: 2px solid #e5e5e5;
}

.btn-secondary:hover {
  background: #e5e5e5;
}

input, textarea {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e5e5e5;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

input:focus, textarea:focus {
  outline: none;
  border-color: #d4af37;
}

.booking-summary {
  background: #faf9f6;
  border-radius: 8px;
  padding: 1.5rem;
  margin: 2rem 0;
}

.booking-summary h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.5rem;
  margin-bottom: 1rem;
  color: #2c2c2c;
}

.summary-details {
  display: grid;
  gap: 0.5rem;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 0;
  border-bottom: 1px solid #e5e5e5;
}

.summary-item:last-child {
  border-bottom: none;
}

.summary-item .label {
  font-weight: 600;
  color: #666;
}

.summary-item .value {
  color: #2c2c2c;
}

.confirmation-container {
  text-align: center;
}

.confirmation-header {
  margin-bottom: 2rem;
}

.success-icon {
  font-size: 4rem;
  margin-bottom: 1rem;
}

.confirmation-header h2 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem;
  color: #2c2c2c;
  margin-bottom: 0.5rem;
}

.confirmation-details {
  display: grid;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.detail-card, .notification-card {
  background: #faf9f6;
  border-radius: 8px;
  padding: 1.5rem;
  text-align: left;
}

.detail-card h3, .notification-card h3 {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.3rem;
  margin-bottom: 1rem;
  color: #2c2c2c;
}

.detail-item {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 0;
  border-bottom: 1px solid #e5e5e5;
}

.detail-item:last-child {
  border-bottom: none;
}

.detail-item .label {
  font-weight: 600;
  color: #666;
}

.detail-item .value {
  color: #2c2c2c;
}

.notification-card p {
  margin: 0.5rem 0;
  color: #666;
}

.confirmation-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 30px;
  border-radius: 12px;
  width: 90%;
  max-width: 900px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.3);
  position: relative;
  animation: fadeIn 0.3s ease-out;
  max-height: 90vh;
  overflow-y: auto;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}

.close-button {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  top: 15px;
  right: 25px;
  cursor: pointer;
}

.close-button:hover,
.close-button:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.modal-content h2 {
  text-align: center;
  color: #2c2c2c;
  margin-bottom: 15px;
  font-family: 'Cormorant Garamond', serif;
  font-size: 2.2rem;
}

.modal-description {
  text-align: center;
  margin-bottom: 25px;
  color: #666;
  font-size: 1.1rem;
}

.menu-options {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-bottom: 30px;
}

.menu-card {
  border: 2px solid #e5e5e5;
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  transition: all 0.3s ease;
  cursor: pointer;
  background-color: #fdfdfd;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.menu-card:hover {
  border-color: #d4af37;
  box-shadow: 0 4px 12px rgba(212, 175, 55, 0.1);
  transform: translateY(-2px);
}

.menu-card.selected {
  border-color: #d4af37;
  background-color: #faf9f6;
  box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
}

.menu-card h3 {
  font-size: 1.4rem;
  color: #2c2c2c;
  margin-bottom: 10px;
  font-family: 'Cormorant Garamond', serif;
}

.menu-card .price {
  font-size: 1.3rem;
  font-weight: bold;
  color: #d4af37;
  margin-bottom: 10px;
}

.menu-card .note {
  font-size: 0.9rem;
  color: #666;
  margin-bottom: 15px;
  font-style: italic;
}

.menu-details {
  text-align: left;
  margin-bottom: 20px;
  flex-grow: 1;
}

.menu-details h4 {
  color: #2c2c2c;
  font-size: 1.1rem;
  margin: 15px 0 8px 0;
  border-bottom: 1px solid #e5e5e5;
  padding-bottom: 5px;
}

.menu-details ul {
  list-style: none;
  padding: 0;
  margin: 0 0 15px 0;
}

.menu-details li {
  margin-bottom: 5px;
  color: #555;
  font-size: 0.9rem;
  line-height: 1.4;
}

.menu-details .addon {
  font-size: 0.8rem;
  color: #888;
  font-style: italic;
  margin: 5px 0;
}

.select-menu-btn {
  width: 100%;
  padding: 12px;
  background: #d4af37;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.select-menu-btn:hover {
  background: #b8941f;
  transform: translateY(-1px);
}

.menu-card.selected .select-menu-btn {
  background: #28a745;
}

.modal-actions {
  display: flex;
  justify-content: space-between;
  gap: 15px;
  margin-top: 30px;
}

.modal-actions button {
  flex: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .reservation-container {
    padding: 1rem;
  }
  
  .service-options {
    grid-template-columns: 1fr;
  }
  
  .party-size-options {
    grid-template-columns: repeat(3, 1fr);
  }
  
  .quick-dates {
    flex-direction: column;
  }
  
  .confirmation-actions {
    flex-direction: column;
  }
  
  .menu-options {
    grid-template-columns: 1fr;
  }
  
  .modal-content {
    padding: 20px;
    width: 95%;
  }
  
  .modal-content h2 {
    font-size: 1.8rem;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('reservationForm');
  const step1 = document.getElementById('step1');
  const step2 = document.getElementById('step2');
  const step3 = document.getElementById('step3');
  
  let currentStep = 1;
  let formData = {
    partySize: 2,
    date: '',
    service: '',
    time: '',
    customerName: '',
    customerEmail: '',
    customerPhone: '',
    specialRequests: '',
    selectedMenu: ''
  };

  const BIG_BOOKING_THRESHOLD = 8; // Define what constitutes a "bigger booking"

  // Party size selection
  document.querySelectorAll('.party-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.party-btn').forEach(b => b.classList.remove('selected'));
      this.classList.add('selected');
      formData.partySize = parseInt(this.dataset.size);
      document.getElementById('customPartySize').value = formData.partySize;
      updateLargeGroupNotice();
    });
  });

  document.getElementById('customPartySize').addEventListener('change', function() {
    formData.partySize = parseInt(this.value) || 2;
    document.querySelectorAll('.party-btn').forEach(b => b.classList.remove('selected'));
    updateLargeGroupNotice();
  });

  function updateLargeGroupNotice() {
    const notice = document.getElementById('largeGroupNotice');
    if (formData.partySize >= BIG_BOOKING_THRESHOLD) {
      notice.style.display = 'block';
    } else {
      notice.style.display = 'none';
    }
  }

  // Date selection
  document.querySelectorAll('.date-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('selected'));
      this.classList.add('selected');
      
      const today = new Date();
      const tomorrow = new Date(today);
      tomorrow.setDate(tomorrow.getDate() + 1);
      
      if (this.textContent.includes('Today')) {
        formData.date = today.toISOString().split('T')[0];
      } else if (this.textContent.includes('Tomorrow')) {
        formData.date = tomorrow.toISOString().split('T')[0];
      } else if (this.textContent.includes('Weekend')) {
        // Find next Saturday
        const nextSaturday = new Date(tomorrow);
        while (nextSaturday.getDay() !== 6) {
          nextSaturday.setDate(nextSaturday.getDate() + 1);
        }
        formData.date = nextSaturday.toISOString().split('T')[0];
      }
      
      document.getElementById('reservationDate').value = formData.date;
      showServiceOptions();
    });
  });

  document.getElementById('reservationDate').addEventListener('change', function() {
    formData.date = this.value;
    document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('selected'));
    showServiceOptions();
  });

  function showServiceOptions() {
    if (formData.date) {
      document.getElementById('serviceSelection').style.display = 'block';
      // Reset service and time when date changes
      formData.service = '';
      formData.time = '';
      document.querySelectorAll('.service-btn').forEach(b => b.classList.remove('selected'));
      document.getElementById('timeSelection').style.display = 'none';
      document.querySelector('.time-options').innerHTML = '';
    }
  }

  // Service selection
  document.querySelectorAll('.service-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.service-btn').forEach(b => b.classList.remove('selected'));
      this.classList.add('selected');
      formData.service = this.dataset.service;
      
      // Show time selection
      document.getElementById('timeSelection').style.display = 'block';
      generateTimeSlots(formData.service);
    });
  });

  function generateTimeSlots(service) {
    const timeContainer = document.querySelector('.time-options');
    timeContainer.innerHTML = '';
    
    let times = [];
    const now = new Date();
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const isToday = formData.date === today.toISOString().split('T')[0];

    if (service === 'lunch') {
      // Lunch: 12:00 PM - 2:00 PM (15-minute intervals)
      for (let hour = 12; hour <= 13; hour++) {
        for (let minute = 0; minute < 60; minute += 15) {
          if (hour === 13 && minute > 45) break;
          const timeStr = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
          
          // Check if it's today and if the time has passed
          if (isToday) {
            const slotTime = new Date();
            slotTime.setHours(hour, minute, 0, 0);
            if (slotTime <= now) continue; // Skip past times for today
          }
          
          const displayTime = formatTime(timeStr);
          times.push({ value: timeStr, display: displayTime });
        }
      }
    } else if (service === 'dinner') {
      // Dinner: 5:30 PM - 8:20 PM (15-minute intervals)
      for (let hour = 17; hour <= 20; hour++) {
        for (let minute = 0; minute < 60; minute += 15) {
          if (hour === 17 && minute < 30) continue; // Skip times before 5:30 PM
          if (hour === 20 && minute > 20) break; // Stop at 8:20 PM
          
          const timeStr = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
          
          // Check if it's today and if the time has passed
          if (isToday) {
            const slotTime = new Date();
            slotTime.setHours(hour, minute, 0, 0);
            if (slotTime <= now) continue; // Skip past times for today
          }
          
          const displayTime = formatTime(timeStr);
          times.push({ value: timeStr, display: displayTime });
        }
      }
    }
    
    times.forEach(time => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'time-btn';
      btn.textContent = time.display;
      btn.dataset.time = time.value;
      btn.addEventListener('click', function() {
        document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('selected'));
        this.classList.add('selected');
        formData.time = this.dataset.time;
      });
      timeContainer.appendChild(btn);
    });
  }

  function formatTime(timeStr) {
    const [hour, minute] = timeStr.split(':').map(Number);
    const period = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
    return `${displayHour}:${minute.toString().padStart(2, '0')} ${period}`;
  }

  // Step navigation
  document.getElementById('nextStep1').addEventListener('click', function() {
    if (validateStep1()) {
      if (formData.partySize >= BIG_BOOKING_THRESHOLD) {
        // Show menu selection modal for large parties
        showMenuModal();
      } else {
        // Proceed directly to Step 2 for smaller parties
        showStep(2);
        updateSummary();
      }
    }
  });

  document.getElementById('backStep1').addEventListener('click', function() {
    showStep(1);
  });

  document.getElementById('nextStep2').addEventListener('click', function() {
    if (validateStep2()) {
      submitReservation();
    }
  });

  document.getElementById('newReservation').addEventListener('click', function() {
    resetForm();
    showStep(1);
  });

  function validateStep1() {
    if (!formData.date) {
      alert('Please select a date');
      return false;
    }
    if (!formData.service) {
      alert('Please select a service (Lunch or Dinner)');
      return false;
    }
    if (!formData.time) {
      alert('Please select a time');
      return false;
    }
    return true;
  }

  function validateStep2() {
    const name = document.getElementById('customerName').value.trim();
    const email = document.getElementById('customerEmail').value.trim();
    
    if (!name) {
      alert('Please enter your full name');
      return false;
    }
    if (!email) {
      alert('Please enter your email address');
      return false;
    }
    if (!isValidEmail(email)) {
      alert('Please enter a valid email address');
      return false;
    }
    
    formData.customerName = name;
    formData.customerEmail = email;
    formData.customerPhone = document.getElementById('customerPhone').value.trim();
    formData.specialRequests = document.getElementById('specialRequests').value.trim();
    
    return true;
  }

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  function updateSummary() {
    document.getElementById('summaryDate').textContent = formatDate(formData.date);
    document.getElementById('summaryTime').textContent = formatTime(formData.time);
    document.getElementById('summaryParty').textContent = formData.partySize + ' people';
    document.getElementById('summaryService').textContent = formData.service.charAt(0).toUpperCase() + formData.service.slice(1);
  }

  function formatDate(dateStr) {
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', { 
      weekday: 'long', 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    });
  }

  function showStep(step) {
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    document.getElementById(`step${step}`).classList.add('active');
    currentStep = step;
  }

  function submitReservation() {
    // Show loading state
    const submitBtn = document.getElementById('nextStep2');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Processing...';
    submitBtn.disabled = true;

    // Prepare data for API
    const reservationData = {
      customerName: formData.customerName,
      customerEmail: formData.customerEmail,
      customerPhone: formData.customerPhone,
      partySize: formData.partySize,
      date: formData.date,
      time: formData.time,
      service: formData.service,
      specialRequests: formData.specialRequests,
      selectedMenu: formData.selectedMenu
    };

    // Submit to Simple Booking API
    fetch('api/simple-booking.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        customerName: formData.customerName,
        customerPhone: formData.customerPhone,
        customerEmail: formData.customerEmail,
        numberOfCustomers: formData.partySize,
        bookingDate: formData.date,
        bookingTime: formData.time
      })
    })
    .then(response => response.json())
    .then(data => {
      console.log('API Response:', data); // Debug log
      if (data.success) {
        // Update confirmation details
        document.getElementById('confirmDate').textContent = formatDate(formData.date);
        document.getElementById('confirmTime').textContent = formatTime(formData.time);
        document.getElementById('confirmParty').textContent = formData.partySize + ' persone';
        document.getElementById('confirmName').textContent = formData.customerName;
        document.getElementById('confirmService').textContent = formData.service === 'lunch' ? 'Pranzo' : 'Cena';
        document.getElementById('confirmCode').textContent = '#' + data.booking.id;
        
        // Show SMS notification if phone provided
        if (formData.customerPhone) {
          document.getElementById('smsNotification').style.display = 'block';
        }
        
        console.log('Showing confirmation step'); // Debug log
        showStep(3);
      } else {
        // Handle specific error messages
        let errorMessage = 'Failed to create reservation';
        if (data.error) {
          if (data.error.includes('already booked')) {
            errorMessage = 'This time slot is already booked. Please choose a different time.';
          } else if (data.error.includes('date cannot be in the past')) {
            errorMessage = 'Please select a future date.';
          } else if (data.error.includes('Invalid time format')) {
            errorMessage = 'Please select a valid time.';
          } else {
            errorMessage = data.error;
          }
        }
        alert('Error: ' + errorMessage);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Error: Network error. Please check your connection and try again.');
    })
    .finally(() => {
      // Reset button
      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
    });
  }

  function resetForm() {
    formData = {
      partySize: 2,
      date: '',
      service: '',
      time: '',
      customerName: '',
      customerEmail: '',
      customerPhone: '',
      specialRequests: '',
      selectedMenu: ''
    };
    
    form.reset();
    document.querySelectorAll('.party-btn, .date-btn, .service-btn, .time-btn').forEach(btn => {
      btn.classList.remove('selected');
    });
    document.getElementById('serviceSelection').style.display = 'none';
    document.getElementById('timeSelection').style.display = 'none';
    document.getElementById('smsNotification').style.display = 'none';
    updateLargeGroupNotice();
  }

  // Menu Modal Logic
  function showMenuModal() {
    const modal = document.getElementById('menuModal');
    const partySizeSpan = document.getElementById('modalPartySize');
    partySizeSpan.textContent = formData.partySize;
    modal.style.display = 'flex';
  }

  // Close modal handlers
  document.querySelector('.close-button').addEventListener('click', function() {
    document.getElementById('menuModal').style.display = 'none';
  });

  document.getElementById('backToPartySize').addEventListener('click', function() {
    document.getElementById('menuModal').style.display = 'none';
  });

  // Menu selection logic
  document.querySelectorAll('.menu-card').forEach(card => {
    card.addEventListener('click', function() {
      // Remove selected class from all cards
      document.querySelectorAll('.menu-card').forEach(c => c.classList.remove('selected'));
      // Add selected class to clicked card
      this.classList.add('selected');
      
      // Update form data
      formData.selectedMenu = this.dataset.menu;
      
      // Enable confirm button
      document.getElementById('confirmMenuSelection').disabled = false;
    });
  });

  document.getElementById('confirmMenuSelection').addEventListener('click', function() {
    if (formData.selectedMenu) {
      document.getElementById('menuModal').style.display = 'none';
      showStep(2);
      updateSummary();
    } else {
      alert('Please select a menu option.');
    }
  });

  // Close modal when clicking outside
  window.addEventListener('click', function(event) {
    const modal = document.getElementById('menuModal');
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });

  // Initialize with today's date as minimum
  const today = new Date();
  document.getElementById('reservationDate').min = today.toISOString().split('T')[0];
  
  // Initialize large group notice
  updateLargeGroupNotice();
});
</script>

<?php include __DIR__ . "/includes/footer.php"; ?>