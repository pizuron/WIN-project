// Site-wide Chat Assistant with typing animation and emojis
;(function(){
  const CHAT_ID = 'chatbot';
  const TOGGLE_ID = 'chatbtn';

  const EMO = {
    book:["📅","🕰️","👥","✅"],
    menu:["🍝","🍕","🍷","🍮"],
    info:["🕒","📍","☎️"],
    greet:["👋","🙂","✨"],
  };
  const pick = (a)=> a[Math.floor(Math.random()*a.length)];

  function ensureUI(){
    if(!document.getElementById(CHAT_ID)){
      const panel = document.createElement('div');
      panel.id = CHAT_ID;
      panel.className = 'chatbot';
      panel.style.display = 'none';
      panel.setAttribute('aria-live','polite');
      panel.innerHTML = `
        <div class="chatbot__head">
          <strong>GIANNI Assistant</strong>
          <button class="x" type="button" aria-label="Close chat">✕</button>
        </div>
        <div id="chatlog" class="chatbot__messages"></div>
        <form class="chatbot__input">
          <input id="chattext" type="text" placeholder="Ask about menu, hours, or type 'book'…" aria-label="Your message">
          <button type="submit">Send</button>
        </form>`;
      document.body.appendChild(panel);
    }
    if(!document.getElementById(TOGGLE_ID)){
      const btn = document.createElement('button');
      btn.id = TOGGLE_ID;
      btn.type = 'button';
      btn.className = 'chatbot__toggle';
      btn.setAttribute('aria-label','Open chat');
      btn.textContent = '💬';
      document.body.appendChild(btn);
    }
  }

  const chatState = { open:false, intent:null, booking:{ date:'', time:'', guests:'', name:'', phone:'' } };
  const kb = { location:'', hours:'', phone:'', menu:[] };

  function get(ids){ return document.getElementById(ids); }

  function toggleChat(open){
    const panel = get(CHAT_ID);
    const btn = get(TOGGLE_ID);
    chatState.open = open;
    panel.style.display = open ? 'flex' : 'none';
    btn.style.display = open ? 'none' : 'inline-flex';
    if(open){
      get('chattext')?.focus();
      greetIfFirstOpen();
    }
  }

  function chatAppend(text, who='bot'){
    const log = get('chatlog');
    const div = document.createElement('div');
    div.className = who === 'bot' ? 'bot' : 'user';
    div.innerHTML = `<p>${text}</p>`;
    log.appendChild(div);
    log.scrollTop = log.scrollHeight;
  }
  function showTyping(){
    const log = get('chatlog');
    const div = document.createElement('div');
    div.className = 'bot typing';
    div.innerHTML = '<span class="dots"><i></i><i></i><i></i></span>';
    log.appendChild(div);
    log.scrollTop = log.scrollHeight;
    return div;
  }
  function typeAndAppend(text){
    const typing = showTyping();
    const delay = Math.min(1800, Math.max(400, text.length*25));
    setTimeout(()=>{ typing.remove(); chatAppend(text, 'bot'); }, delay);
  }
  function greetIfFirstOpen(){
    const log = get('chatlog');
    if(log && log.children.length === 0){
      typeAndAppend("Ciao! 🇮🇹 Welcome to GIANNI. I can book a table, explain our menu, or share hours & location. Try ‘book’, ‘menu’, or ‘hours’. 🍝✨");
    }
  }

  function chatHandle(raw){
    const m = (raw||'').toLowerCase();
    if(m.includes('book')){ chatState.intent='book'; typeAndAppend(`${pick(EMO.book)} Let’s make a reservation!`); return askBookingNext(); }
    if(m.includes('menu')){ chatState.intent='menu'; return typeAndAppend(`${pick(EMO.menu)} Our menu highlights: handmade pasta, wood-fired pizza, seasonal antipasti, and classic desserts. Ask for pasta, pizza, or desserts recommendations. ${pick(EMO.menu)}`); }
    if(m.includes('hour') || m.includes('open')){ return typeAndAppend(`${pick(EMO.info)} We are open 7 days. Dinner from 5:30pm; lunch Tue–Sun from 12:00pm.`); }
    if(m.includes('where') || m.includes('location')){ return typeAndAppend(`${pick(EMO.info)} Find us at 60 Alinga Street, Canberra City Centre.`); }
    if(chatState.intent==='book') return handleBookingStep(raw);
    typeAndAppend(`${pick(EMO.greet)} I can help you book a table, explain the menu, and share hours & location. Type 'book', 'menu', or 'hours'.`);
  }

  function askBookingNext(){
    const b = chatState.booking;
    if(!b.date) return typeAndAppend(`${pick(EMO.book)} Great! What date would you like? (YYYY-MM-DD)`);
    if(!b.time) return typeAndAppend(`${pick(EMO.book)} What time? (e.g., 19:30)`);
    if(!b.guests) return typeAndAppend(`${pick(EMO.book)} How many guests?`);
    if(!b.name) return typeAndAppend(`Your name, please ${pick(EMO.greet)}`);
    if(!b.phone) return typeAndAppend(`A phone number for confirmation ${pick(EMO.info)}`);
    try{ get('date').value=b.date; get('time').value=b.time; get('size').value=String(Math.max(2,Math.min(6, parseInt(b.guests)||2))); }catch(e){}
    typeAndAppend(`Grazie, ${b.name}! ${pick(EMO.book)} I’ve pre-filled your reservation for ${b.guests} on ${b.date} at ${b.time}. Click the reservation link to confirm. ${pick(EMO.greet)}`);
    chatState.intent = null;
  }
  function handleBookingStep(val){
    const b = chatState.booking;
    if(!b.date){ b.date = val; return askBookingNext(); }
    if(!b.time){ b.time = val; return askBookingNext(); }
    if(!b.guests){ b.guests = val; return askBookingNext(); }
    if(!b.name){ b.name = val; return askBookingNext(); }
    if(!b.phone){ b.phone = val; return askBookingNext(); }
  }

  function bind(){
    ensureUI();
    // remove any leftover inline chat markup/messages
    const log = get('chatlog');
    if(log) log.innerHTML = '';
    buildKnowledgeBase();
    get(TOGGLE_ID)?.addEventListener('click', ()=> toggleChat(true));
    document.querySelector(`#${CHAT_ID} .x`)?.addEventListener('click', ()=> toggleChat(false));
    document.querySelector(`#${CHAT_ID} form`)?.addEventListener('submit', (e)=>{
      e.preventDefault();
      const input = get('chattext');
      const val = (input.value||'').trim();
      if(!val) return;
      chatAppend(val, 'user');
      input.value = '';
      chatHandle(val);
    });
  }

  if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bind);
  else bind();

  // --- Lightweight scraping so the bot knows your site ---
  function buildKnowledgeBase(){
    // Try to scrape location/hours/phone from visible content
    const bodyText = document.body.innerText || '';
    // Location (looks for a street or ACT)
    const locMatch = bodyText.match(/\b\d+\s+[^\n]+Canberra[^\n]*/i);
    if(locMatch) kb.location = locMatch[0].trim();
    // Phone
    const tel = document.querySelector('a[href^="tel:"]');
    if(tel) kb.phone = tel.textContent.trim();
    // Hours (simple heuristic)
    const hrs = bodyText.match(/Open\s+7\s+days.*|Mon.*Sun.*|Tuesday.*Sunday.*|Opening Hours[\s\S]{0,120}/i);
    if(hrs) kb.hours = hrs[0].replace(/\s+/g,' ').trim();

    // Menu: if menu is on page, scrape; else fetch embedded menu
    const items = document.querySelectorAll('.menu-item');
    if(items.length){
      kb.menu = Array.from(items).slice(0,200).map(el=>({
        name: (el.querySelector('.menu-item-name')?.textContent||'').trim(),
        desc: (el.querySelector('.menu-item-description')?.textContent||'').trim(),
        tags: Array.from(el.querySelectorAll('.dietary-tag')).map(t=>t.textContent.trim())
      }));
    } else {
      tryFetchMenu();
    }
  }

  function tryFetchMenu(){
    fetch('menu.php?embed=1', { credentials:'same-origin' })
      .then(r=> r.text())
      .then(html=>{
        const doc = new DOMParser().parseFromString(html, 'text/html');
        const items = doc.querySelectorAll('.menu-item');
        kb.menu = Array.from(items).slice(0,300).map(el=>({
          name: (el.querySelector('.menu-item-name')?.textContent||'').trim(),
          desc: (el.querySelector('.menu-item-description')?.textContent||'').trim(),
          tags: Array.from(el.querySelectorAll('.dietary-tag')).map(t=>t.textContent.trim())
        }));
      })
      .catch(()=>{});
  }

  // Override some answers using scraped knowledge
  const answer = {
    hours(){ return kb.hours ? `${pick(EMO.info)} ${kb.hours}` : `${pick(EMO.info)} We are open 7 days. Dinner from 5:30pm; lunch Tue–Sun from 12:00pm.`; },
    location(){ return kb.location ? `${pick(EMO.info)} Find us at ${kb.location}.` : `${pick(EMO.info)} Find us at 60 Alinga Street, Canberra City Centre.`; },
    phone(){ return kb.phone ? `${pick(EMO.info)} Call us at ${kb.phone}.` : `${pick(EMO.info)} Call us at (02) 6248 5444.`; },
    menuQuery(q){
      if(!kb.menu.length) return `${pick(EMO.menu)} Handmade pasta, wood-fired pizza, seasonal antipasti, and classic desserts.`;
      const norm = (s)=> (s||'').toLowerCase();
      const found = kb.menu.filter(m=> norm(m.name+" "+m.desc+" "+(m.tags||[]).join(' ')).includes(norm(q))).slice(0,5);
      if(!found.length) return `${pick(EMO.menu)} Popular: ${kb.menu.slice(0,4).map(m=>m.name).filter(Boolean).join(', ')}.`;
      return `${pick(EMO.menu)} ${found.map(m=> m.name).join(', ')}`;
    }
  };

  // Patch chatHandle to use knowledge base (augment existing logic)
  const _origHandle = chatHandle;
  function chatHandle(raw){
    const m = (raw||'').toLowerCase();
    if(m.includes('hour') || m.includes('open')) return typeAndAppend(answer.hours());
    if(m.includes('where') || m.includes('location') || m.includes('address')) return typeAndAppend(answer.location());
    if(m.includes('phone') || m.includes('call') || m.includes('contact')) return typeAndAppend(answer.phone());
    if(m.includes('menu')){
      // try to look for keyword after 'menu'
      const kw = m.replace('menu','').trim();
      if(kw.length>1) return typeAndAppend(answer.menuQuery(kw));
    }
    // fallback to original handler
    return _origHandle(raw);
  }
})();

// Lightweight site-wide chat assistant
;(function(){
  const CHAT_ID = 'chatbot-global';
  const TOGGLE_ID = 'chatbot-toggle-global';

  function ensureContainers(){
    if(!document.getElementById(CHAT_ID)){
      const panel = document.createElement('div');
      panel.id = CHAT_ID;
      panel.className = 'chatbot';
      panel.style.display = 'none';
      panel.innerHTML = `
        <div class="chatbot__head">
          <strong>GIANI Assistant</strong>
          <button class="x" type="button" aria-label="Close chat">✕</button>
        </div>
        <div class="chatbot__messages" id="chatbot-messages">
          <div class="bot"><p>Ciao! I can help book a table, explain the menu, and share hours & location. Type "book" to start a reservation.</p></div>
        </div>
        <form class="chatbot__input" id="chatbot-form">
          <input id="chatbot-input" type="text" placeholder="Ask about menu, hours, or type 'book'…" aria-label="Your message">
          <button type="submit">Send</button>
        </form>`;
      document.body.appendChild(panel);
    }
    if(!document.getElementById(TOGGLE_ID)){
      const btn = document.createElement('button');
      btn.id = TOGGLE_ID;
      btn.type = 'button';
      btn.className = 'chatbot__toggle';
      btn.setAttribute('aria-label', 'Open chat');
      btn.textContent = '💬';
      document.body.appendChild(btn);
    }
  }

  const state = { open:false, intent:null, booking:{ date:'', time:'', guests:'', name:'', phone:'' } };

  function toggle(open){
    const panel = document.getElementById(CHAT_ID);
    const btn = document.getElementById(TOGGLE_ID);
    state.open = open;
    panel.style.display = open ? 'flex' : 'none';
    btn.style.display = open ? 'none' : 'inline-flex';
    if(open) document.getElementById('chatbot-input')?.focus();
  }

  function append(text, who='bot'){
    const log = document.getElementById('chatbot-messages');
    const div = document.createElement('div');
    div.className = who === 'bot' ? 'bot' : 'user';
    div.innerHTML = `<p>${text}</p>`;
    log.appendChild(div);
    log.scrollTop = log.scrollHeight;
  }

  function handle(raw){
    const m = (raw||'').toLowerCase();
    if(m.includes('book')){ state.intent='book'; return askNext(); }
    if(m.includes('menu')){ state.intent='menu'; return append('Our menu highlights: handmade pasta, wood-fired pizza, seasonal antipasti, and classic desserts. Ask for pasta, pizza, or desserts recommendations.'); }
    if(m.includes('hour') || m.includes('open')) return append('We are open 7 days. Dinner from 5:30pm; lunch Tue–Sun from 12:00pm.');
    if(m.includes('where') || m.includes('location')) return append('Find us at 60 Alinga Street, Canberra City Centre.');
    if(state.intent==='book') return collectBooking(raw);
    append("I can help you book a table, explain the menu, and share hours & location. Type 'book', 'menu', or 'hours'.");
  }

  function askNext(){
    const b = state.booking;
    if(!b.date) return append('Great! What date would you like? (YYYY-MM-DD)');
    if(!b.time) return append('What time? (e.g., 19:30)');
    if(!b.guests) return append('How many guests?');
    if(!b.name) return append('Your name?');
    if(!b.phone) return append('Your phone number?');
    // Try prefilling if reservation form exists on page
    try{
      const d = document.getElementById('date'); if(d) d.value = b.date;
      const t = document.getElementById('time'); if(t) t.value = b.time;
      const s = document.getElementById('size'); if(s) s.value = String(Math.max(2, Math.min(6, parseInt(b.guests)||2)));
    }catch(e){}
    append(`Thanks ${b.name}! I’ve pre-filled your reservation for ${b.guests} on ${b.date} at ${b.time}. Please confirm via the reservation button.`);
    state.intent = null;
  }

  function collectBooking(val){
    const b = state.booking;
    if(!b.date){ b.date = val; return askNext(); }
    if(!b.time){ b.time = val; return askNext(); }
    if(!b.guests){ b.guests = val; return askNext(); }
    if(!b.name){ b.name = val; return askNext(); }
    if(!b.phone){ b.phone = val; return askNext(); }
  }

  function bind(){
    ensureContainers();
    document.getElementById(TOGGLE_ID)?.addEventListener('click', ()=> toggle(true));
    document.querySelector(`#${CHAT_ID} .x`)?.addEventListener('click', ()=> toggle(false));
    document.getElementById('chatbot-form')?.addEventListener('submit', (e)=>{
      e.preventDefault();
      const input = document.getElementById('chatbot-input');
      const val = input.value.trim();
      if(!val) return;
      append(val, 'user');
      input.value = '';
      handle(val);
    });
  }

  if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', bind);
  else bind();
})();


