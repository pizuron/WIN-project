<?php $ACTIVE_PAGE = "index.php"; include __DIR__ . "/includes/header.php"; ?>

    <div class="frontgrid">
      <!-- Left column (like the reference) -->
      <aside class="side" aria-label="Details">
        <div class="block">
          <a class="underline" href="#" data-open="book">Make a reservation</a>
        </div>
        <div class="block">
          <span class="label">Location</span>
          <div>60 Alinga Street<br/>Canberra, ACT 2601<br/>Canberra City Centre</div>
        </div>
        <div class="block">
          <span class="label">Opening Hours</span>
          <div>
            <div>Open 7 days</div>
            <div>Mon–Sun from 5:30pm</div>
            <div>Tue–Sun from 12:00pm</div>
          </div>
        </div>
        <div class="block">
          <span class="label">Contact</span>
          <div>
            Briscola Italian<br/>
            <a href="tel:+61262485444" class="underline">(02) 6248 5444</a>
          </div>
        </div>
      </aside>

      <!-- Right column big image -->
      <div class="heroimg" aria-hidden="true">
        <!-- Provided photos inserted as the GIANI dining room; will fall back if one cannot load -->
        <img src="assets/Images/bp.png" alt="GIANI dining room"/>
      </div>
    </div>

  <!-- Transparent / glass popup for reservations -->
  <dialog id="book">
    <div class="modal__head">
      <strong>Reserve at GIANI</strong>
      <button class="x" data-close aria-label="Close">✕</button>
    </div>
    <div class="modal__body">
      <form id="bookForm" onsubmit="event.preventDefault(); bookSubmit();">
        <div class="field"><label for="date">Date</label><input id="date" type="date" required></div>
        <div class="field"><label for="time">Time</label><input id="time" type="time" required></div>
        <div class="field"><label for="size">Guests</label>
          <select id="size" required>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </div>
        <div class="field"><label for="note">Notes (optional)</label><textarea id="note" rows="3" placeholder="Anniversary? High chair? Allergies?"></textarea></div>
        <div class="row-end">
          <button class="btn" type="button" data-close>Cancel</button>
          <button class="btn" type="submit">Request booking</button>
        </div>
      </form>
    </div>
  </dialog>

  <script>
    // Modal open/close
    document.querySelectorAll('[data-open]').forEach(b=>b.addEventListener('click', e=>{
      e.preventDefault();
      const id = b.getAttribute('data-open');
      const d = document.getElementById(id);
      if(d) d.showModal();
    }));
    document.querySelectorAll('[data-close]').forEach(b=>b.addEventListener('click', ()=> document.querySelector('dialog[open]')?.close()));
    document.addEventListener('keydown', e=>{ if(e.key==='Escape') document.querySelector('dialog[open]')?.close(); });

    function bookSubmit(){
      const date = document.getElementById('date').value;
      const time = document.getElementById('time').value;
      const size = document.getElementById('size').value;
      document.querySelector('dialog[open]')?.close();
      setTimeout(()=> alert(`Grazie! Your request for ${date} @ ${time} (party of ${size}) has been received.`), 10);
    }
    
    // Set minimum date to today for the date picker
    document.getElementById('date').min = new Date().toISOString().split('T')[0];
  </script>

<?php include __DIR__ . "/includes/footer.php"; ?>