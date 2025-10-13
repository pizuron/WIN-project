<?php $ACTIVE_PAGE = "index.php"; include __DIR__ . "/includes/header.php"; ?>

    <div class="frontgrid">
      <!-- Left column (like the reference) -->
      <aside class="side" aria-label="Details">
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
            Gianni Italian<br/>
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

    <!-- Gallery Section -->
    <section class="gallery" aria-label="Photo gallery">
      <div class="gallery-head">
        <h2>Gallery</h2>
        <div class="gallery-actions">
          <input id="gallery-input" type="file" accept="image/*" multiple style="display:none">
          <button class="btn" type="button" onclick="document.getElementById('gallery-input').click()">Upload images</button>
          <button class="btn" type="button" onclick="clearGallery()">Remove</button>
        </div>
      </div>
      <div id="gallery-grid" class="gallery-grid"></div>
    </section>


  <script>
    // --- Gallery ---
    const galleryGrid = document.getElementById('gallery-grid');
    const galleryInput = document.getElementById('gallery-input');
    const galleryImages = [];

    function renderGallery(){
      if(!galleryGrid) return;
      galleryGrid.innerHTML = '';
      galleryImages.forEach((src, i) => {
        const d = document.createElement('div');
        d.className = 'gallery-item';
        d.innerHTML = `<img src="${src}" alt="gallery image ${i+1}" />`;
        d.addEventListener('click', () => openLightbox(i));
        galleryGrid.appendChild(d);
      });
    }

    function clearGallery(){
      galleryImages.length = 0;
      renderGallery();
    }

    galleryInput?.addEventListener('change', (e)=>{
      const files = Array.from(e.target.files || []);
      files.forEach(file => {
        if(!file.type.startsWith('image/')) return;
        const r = new FileReader();
        r.onload = ev => { galleryImages.push(String(ev.target.result)); renderGallery(); };
        r.readAsDataURL(file);
      });
      e.target.value = '';
    });

    // Lightbox
    let lbIndex = 0;
    function openLightbox(i){
      lbIndex = i;
      const wrap = document.createElement('div');
      wrap.className = 'lightbox';
      wrap.innerHTML = `
        <div class="lightbox__inner">
          <button class="lightbox__x" onclick="closeLightbox()">✕</button>
          <button class="lightbox__prev" onclick="lbPrev()">‹</button>
          <img id="lightbox-img" src="${galleryImages[lbIndex]}" alt="image ${lbIndex+1}">
          <button class="lightbox__next" onclick="lbNext()">›</button>
        </div>`;
      document.body.appendChild(wrap);
      document.body.style.overflow = 'hidden';
      document.addEventListener('keydown', lbKeys);
    }
    function closeLightbox(){
      document.querySelector('.lightbox')?.remove();
      document.body.style.overflow = '';
      document.removeEventListener('keydown', lbKeys);
    }
    function lbPrev(){ lbIndex = (lbIndex - 1 + galleryImages.length) % galleryImages.length; document.getElementById('lightbox-img').src = galleryImages[lbIndex]; }
    function lbNext(){ lbIndex = (lbIndex + 1) % galleryImages.length; document.getElementById('lightbox-img').src = galleryImages[lbIndex]; }
    function lbKeys(e){ if(e.key==='Escape') closeLightbox(); if(e.key==='ArrowLeft') lbPrev(); if(e.key==='ArrowRight') lbNext(); }

  </script>

<?php include __DIR__ . "/includes/footer.php"; ?>