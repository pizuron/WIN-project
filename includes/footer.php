  </main>

  <footer>
    <div class="wrap">
      <small>© <span id="year"></span> GIANI • Canberra, Australia</small>
    </div>
  </footer>

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
  </script>
</body>
</html>