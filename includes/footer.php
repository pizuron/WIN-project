  </main>

  <footer>
    <div class="wrap">
      <small>© <span id="year"></span> GIANI • Canberra, Australia</small>
    </div>
  </footer>

  <!-- Reserve FAB -->
  

  <script>
    // Mobile menu toggle
    const burger = document.querySelector('.hamburger');
    const primary = document.getElementById('primaryNav');
    if(burger && primary){
      burger.addEventListener('click', ()=>{
        const open = burger.getAttribute('aria-expanded') === 'true';
        burger.setAttribute('aria-expanded', String(!open));
        primary.classList.toggle('is-open', !open);
        document.body.style.overflow = !open ? 'hidden' : '';
      });
      primary.querySelectorAll('a').forEach(a=>a.addEventListener('click', () =>{
        burger.setAttribute('aria-expanded','false');
        primary.classList.remove('is-open');
        document.body.style.overflow = '';
      }));
      window.addEventListener('resize', ()=>{
        if(window.innerWidth > 980){
          burger.setAttribute('aria-expanded','false');
          primary.classList.remove('is-open');
          document.body.style.overflow = '';
        }
      });
    }

    document.getElementById('year').textContent = new Date().getFullYear();

    // Menu item description toggle with subtle animation (uses CSS .is-open state)
    document.querySelectorAll('.menu-item').forEach((item) => {
      const clickable = item.querySelector('.menu-item-name, .menu-item-content');
      const desc = item.querySelector('.menu-item-description');
      if (!clickable || !desc) return;

      clickable.addEventListener('click', () => {
        item.classList.toggle('is-open');
      });
    });
    // Vertical reservation sheet (glass pane)
    function openReserveSheet(){
      if(document.getElementById('reserveSheet')){ document.getElementById('reserveOverlay').style.display='block'; return; }
      const overlay = document.createElement('div');
      overlay.id = 'reserveOverlay';
      overlay.className = 'sheet-overlay';
      overlay.addEventListener('click', (e)=>{ if(e.target === overlay) closeReserveSheet(); });

      const sheet = document.createElement('aside');
      sheet.id = 'reserveSheet';
      sheet.className = 'reserve-sheet';
      sheet.innerHTML = `
        <div class="sheet-head">
          <strong>Reserve at GIANNI</strong>
          <button class="x" type="button" aria-label="Close" onclick="closeReserveSheet()">✕</button>
        </div>
        <form class="sheet-body" onsubmit="event.preventDefault(); submitReserveSheet();">
          <label>Date<input id="date" type="date" required></label>
          <label>Time<input id="time" type="time" required></label>
          <label>Guests<select id="size" required>
            <option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>
          </select></label>
          <label>Notes<textarea id="note" rows="3" placeholder="Anniversary? High chair? Allergies?"></textarea></label>
          <div class="sheet-actions">
            <button type="button" class="btn" onclick="closeReserveSheet()">Cancel</button>
            <button type="submit" class="btn">Request booking</button>
          </div>
        </form>`;

      overlay.appendChild(sheet);
      document.body.appendChild(overlay);
      document.getElementById('date').min = new Date().toISOString().split('T')[0];
      requestAnimationFrame(()=> overlay.classList.add('is-open'));
    }
    function closeReserveSheet(){
      const overlay = document.getElementById('reserveOverlay');
      if(!overlay) return;
      overlay.classList.remove('is-open');
      setTimeout(()=> overlay.style.display='none', 150);
    }
    function submitReserveSheet(){
      const date = document.getElementById('date').value;
      const time = document.getElementById('time').value;
      const size = document.getElementById('size').value;
      closeReserveSheet();
      setTimeout(()=> alert(`Grazie! Your request for ${date} @ ${time} (party of ${size}) has been received.`), 10);
    }

    // Menu glass popup (loads menu.php)
    function openMenuSheet(){
      if(document.getElementById('menuSheet')){ document.getElementById('menuOverlay').style.display='block'; return; }
      const overlay = document.createElement('div');
      overlay.id = 'menuOverlay';
      overlay.className = 'sheet-overlay';
      overlay.addEventListener('click', (e)=>{ if(e.target === overlay) closeMenuSheet(); });

      const sheet = document.createElement('div');
      sheet.id = 'menuSheet';
      sheet.className = 'center-sheet';
      sheet.innerHTML = `
        <div class=\"sheet-head\">
          <strong>Menu — GIANNI</strong>
          <button class=\"x\" type=\"button\" aria-label=\"Close\" onclick=\"closeMenuSheet()\">✕</button>
        </div>
        <div class=\"sheet-body\" style=\"padding:0;\">
          <iframe src=\"menu.php?embed=1\" title=\"Menu\" style=\"border:0;width:100%;height:calc(90vh - 52px);border-bottom-left-radius:12px;\"></iframe>
        </div>`;

      overlay.appendChild(sheet);
      document.body.appendChild(overlay);
      requestAnimationFrame(()=> overlay.classList.add('is-open'));
    }
    function closeMenuSheet(){
      const overlay = document.getElementById('menuOverlay');
      if(!overlay) return;
      overlay.classList.remove('is-open');
      setTimeout(()=> overlay.style.display='none', 150);
    }

    // Wire header Menu link to open the glass popup
    document.querySelector('[data-menu-open]')?.addEventListener('click', function(e){
      e.preventDefault();
      openMenuSheet();
    });

    // Wire any Reservations link to the glass reservation sheet (works on all pages)
    document.querySelectorAll('[data-open="book"]').forEach((el)=>{
      el.addEventListener('click', function(e){
        e.preventDefault();
        openReserveSheet();
      });
    });
  </script>
  <script src="assets/chatbot.js"></script>
</body>
</html>