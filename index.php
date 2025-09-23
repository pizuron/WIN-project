<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GIANI — Italian Dining</title>
  <meta name="description" content="GIANI — minimal, elegant Italian dining in Canberra. Reservations, menu, private dining."/>
  <!-- Fonts to match the reference vibe: refined serif for headings/brand, clean sans for body -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root{
      /* Neutral, softer palette */
      --cream: #f5f5f3;   /* page bg (neutral stone) */
      --ink:   #222222;   /* primary text */
      --muted: #6f6f6a;   /* secondary text */
      --line:  #e6e5e1;   /* hairline borders */
      --accent:#3a3a3a;   /* subtle neutral accent */
      --accent-2:#8a8a8a; /* muted secondary */
      --shadow: 0 24px 60px rgba(0,0,0,.10);
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{margin:0; background:var(--cream); color:var(--ink); font: 400 17px/1.7 Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji","Segoe UI Emoji"}
    h1,h2,h3,h4{font-family: 'Cormorant Garamond', ui-serif, Georgia, Cambria, Times, "Times New Roman", serif; margin:0 0 8px}
    h1{letter-spacing:2px}
    a{color:inherit}

    .wrap{width:min(1240px,92%); margin-inline:auto}

    /* Top nav - updated for right alignment */
    header.nav{position:sticky; top:0; z-index:30; background:var(--cream); border-bottom:1px solid var(--line)}
    .nav__inner{display:flex; justify-content:space-between; align-items:center; padding:18px 0}
    .brand{font-family: 'Cormorant Garamond', ui-serif, Georgia, Cambria, Times, serif; letter-spacing:8px; text-decoration:none; font-weight:700; font-size:24px; flex-shrink:0}
    .menu{display:flex; gap:28px; justify-content:flex-end}
    .menu a{font-size:14px; text-transform:uppercase; letter-spacing:2px; text-decoration:none; color:var(--ink)}
    .menu a:hover{opacity:.7}
    .cta{font-size:14px; text-transform:uppercase; letter-spacing:2px; text-decoration:none; border-bottom:1px solid var(--ink); margin-left:28px}

    /* Hamburger (mobile) */
    .hamburger{display:none; position:relative; width:40px; height:32px; background:none; border:none; cursor:pointer}
    .hamburger span,
    .hamburger::before,
    .hamburger::after{content:''; position:absolute; left:6px; right:6px; height:2px; background:var(--ink); transition:transform .2s ease, opacity .2s ease}
    .hamburger::before{top:8px}
    .hamburger span{top:15px}
    .hamburger::after{top:22px}
    .hamburger[aria-expanded="true"]::before{transform:translateY(7px) rotate(45deg)}
    .hamburger[aria-expanded="true"] span{opacity:0}
    .hamburger[aria-expanded="true"]::after{transform:translateY(-7px) rotate(-45deg)}

    /* Front layout (like the reference) */
    .front{padding:56px 0 96px}
    .frontgrid{display:grid; grid-template-columns: 320px 1fr; gap:36px; align-items:start}

    .side{position:sticky; top:96px; align-self:start; font-size:12px; line-height:1.7}
    .side .block{margin:20px 0 28px}
    .label{display:block; font-size:11px; text-transform:uppercase; letter-spacing:2px; color:var(--muted); margin-bottom:10px}
    .side a.underline{border-bottom:1px solid var(--ink); text-decoration:none}

    .heroimg{border:1px solid var(--line); background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 10px 40px rgba(0,0,0,.06)}
    .heroimg img{display:block; width:100%; height:auto; object-fit:cover; min-height:400px}

    /* Menu sections from the screenshot */
    .menu-sections {margin-top: 60px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 40px;}
    .menu-section h3 {font-size: 24px; letter-spacing: 2px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid var(--line);}
    .menu-item {margin-bottom: 20px;}
    .menu-item h4 {font-size: 18px; margin-bottom: 5px; font-weight: 600;}
    .menu-item p {font-size: 15px; color: var(--muted); margin: 0; line-height: 1.5;}

    footer{border-top:1px solid var(--line); color:var(--muted); padding:30px 0 60px}

    /* Transparent (glassy) reservation popup */
    dialog{border:none; padding:0; width:min(680px,92%); border-radius:14px; background:rgba(255,255,255,.7); box-shadow:var(--shadow); color:var(--ink); backdrop-filter:blur(12px)}
    dialog::backdrop{backdrop-filter: blur(12px) saturate(120%); background:rgba(0,0,0,.25)}
    .modal__head{display:flex; justify-content:space-between; align-items:center; padding:16px 18px; border-bottom:1px solid var(--line)}
    .modal__body{padding:18px}
    .x{background:none; border:1px solid var(--line); padding:6px 10px; border-radius:8px; cursor:pointer}
    .field{display:grid; gap:6px; margin-bottom:12px}
    label{font-size:14px; color:var(--muted)}
    input, select, textarea{padding:10px 12px; border:1px solid var(--line); border-radius:10px; background:rgba(255,255,255,.8); font-family:inherit}
    .btn{display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid var(--line); background:#fff; cursor:pointer; transition:all 0.2s ease}
    .btn:hover{background:var(--line)}

    @media (max-width: 980px){
      .nav__inner{flex-wrap: wrap; gap: 12px;}
      .brand {order: 1;}
      .hamburger{display:block; order: 2;}
      .cta{order:3; display:none} /* Hide desktop CTA on mobile */
      .menu{display:none; order: 4; width: 100%;}
      .menu.is-open{
        display:flex;
        flex-direction:column;
        gap:18px;
        background:rgba(245,245,243,.98);
        backdrop-filter:saturate(120%) blur(6px);
        padding:18px 24px 24px;
        border-top:1px solid var(--line);
        z-index:60;
      }
      .menu a{font-size:18px; letter-spacing:1.5px}
      .frontgrid{grid-template-columns:1fr; gap:24px}
      .side{position:static}
      .menu-sections {grid-template-columns: 1fr;}
      /* Show mobile CTA in menu */
      .menu .cta-mobile{display:block; border-bottom:none; text-align:center; margin-top:12px; font-size:18px}
    }
    
    /* Add mobile CTA that appears in menu */
    .cta-mobile{display:none}
  </style>
</head>
<body>
  <header class="nav">
    <div class="wrap nav__inner">
      <a class="brand" href="#home" aria-label="GIANI home">GIANI</a>
      <button class="hamburger" aria-label="Open menu" aria-controls="primaryNav" aria-expanded="false"><span></span></button>
      <a class="cta" href="#book" data-open="book">Reservations</a>
      <nav class="menu" id="primaryNav" aria-label="Primary">
        <a href="#book" data-open="book">Reservations</a>
        <a href="#menu">Menu</a>
        <a href="#drinks">Drinks</a>
        <a href="#private">Private Dining</a>
        <a href="#gifts">Gift Vouchers</a>
        <a href="#book" data-open="book" class="cta-mobile">Reservations</a>
      </nav>
    </div>
  </header>

  <main id="home" class="wrap front">
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
        <img src="Screenshot%202025-09-22%20at%205.25.49%E2%80%AFpm.png" alt="GIANI dining room"/>
      </div>
    </div>
    

  <footer>
    <div class="wrap">
      <small>© <span id="year"></span> GIANI • Canberra, Australia</small>
    </div>
  </footer>

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
        <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:6px">
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
    
    // Set minimum date to today for the date picker
    document.getElementById('date').min = new Date().toISOString().split('T')[0];
  </script>
</body>
</html>
