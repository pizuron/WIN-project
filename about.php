<?php
$PAGE_TITLE = "About";
$ACTIVE_PAGE = "about.php";
include __DIR__ . "/includes/header.php";
?>

<!-- Hero Section with Apple Design Tips -->
<section class="about-hero">
  <div class="about-hero-content">
    <h1 class="about-title">About GIANI</h1>
    <p class="about-subtitle">Where taste meets tradition</p>
  </div>
</section>

<!-- Main Content with Apple Design Tips -->
<section class="about-content">
  <div class="about-container">
    
    <!-- Story Section -->
    <div class="about-section">
      <h2 class="section-title">Our Story</h2>
      <div class="story-content">
        <p class="story-text">
          Welcome to <strong>GIANI Italian Restaurant</strong> — where taste meets tradition. 
          GIANI has established itself on the Canberra food scene by offering an
          unpretentious yet stylish approach to an authentic Italian dining experience. At the forefront
          it's about the food: simple, wholesome and traditional without being old fashioned.
        </p>
        
        <p class="story-text">
          What sets us apart is how we transport you to Italy. Start with an aperitivo to open the
          palate, enjoy a local or Italian wine varietal and finish with a fragrant & herbal digestive.
          GIANI seems to suit anyone… corporate luncheons, young couples, families and
          group functions.
        </p>
      </div>
    </div>

    <!-- Awards Section -->
    <div class="about-section awards-section">
      <h2 class="section-title">Recognition</h2>
      <div class="awards-grid">
        <div class="award-item">
          <div class="award-year">2014</div>
          <div class="award-title">Canberra's Best Pizzeria</div>
          <div class="award-org">ACT Savour Awards</div>
        </div>
        <div class="award-item">
          <div class="award-year">2015</div>
          <div class="award-title">Canberra's Best Italian Restaurant</div>
          <div class="award-org">ACT Savour Awards</div>
        </div>
        <div class="award-item">
          <div class="award-year">2016</div>
          <div class="award-title">Accreditation</div>
          <div class="award-org">Accademia Della Cucina Italiana</div>
        </div>
      </div>
    </div>

    <!-- Philosophy Section -->
    <div class="about-section philosophy-section">
      <h2 class="section-title">Our Philosophy</h2>
      <div class="philosophy-content">
        <p class="philosophy-text">
          Our chefs bring together classic recipes and modern twists, creating meals that leave 
          a lasting impression. Whether you're dining in, ordering takeaway, or celebrating a 
          special moment with us, we aim to make every experience truly flavorful.
        </p>
        
        <p class="philosophy-text">
          Since 2010 the restaurant has been family owned by Italians, bringing authentic 
          flavors and warm hospitality to every table. We believe in the power of good food 
          to bring people together and create lasting memories.
        </p>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="about-cta">
      <h3 class="cta-title">Experience GIANI</h3>
      <p class="cta-text">Thank you for being a part of our journey. We look forward to serving you soon and making your day a little more delicious!</p>
      <div class="cta-buttons">
        <a href="menu.php" class="btn btn-primary">Explore Our Menu</a>
      </div>
    </div>

  </div>
</section>

<style>
/* Apple Design Tips Implementation */
.about-hero {
  background: linear-gradient(135deg, rgba(245, 245, 243, 0.95) 0%, rgba(239, 238, 233, 0.98) 100%);
  padding: 120px 0 80px;
  text-align: center;
  position: relative;
  overflow: hidden;
}

.about-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(ellipse at 30% 20%, rgba(191, 164, 111, 0.1) 0%, transparent 50%);
  pointer-events: none;
}

.about-hero-content {
  position: relative;
  z-index: 1;
  max-width: 800px;
  margin: 0 auto;
  padding: 0 2rem;
}

.about-title {
  font-family: "Cormorant Garamond", ui-serif, Georgia, Cambria, Times, serif;
  font-size: clamp(3rem, 8vw, 5rem);
  font-weight: 600;
  color: var(--ink);
  margin: 0 0 1rem 0;
  letter-spacing: 2px;
  line-height: 1.1;
}

.about-subtitle {
  font-size: clamp(1.2rem, 3vw, 1.5rem);
  color: var(--muted);
  font-style: italic;
  margin: 0;
  font-weight: 400;
}

.about-content {
  padding: 80px 0;
  background: var(--cream);
}

.about-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 2rem;
}

.about-section {
  margin-bottom: 80px;
}

.section-title {
  font-family: "Cormorant Garamond", ui-serif, Georgia, Cambria, Times, serif;
  font-size: clamp(2rem, 5vw, 2.5rem);
  font-weight: 600;
  color: var(--ink);
  text-align: center;
  margin: 0 0 3rem 0;
  letter-spacing: 1px;
  position: relative;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: -12px;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 2px;
  background: var(--gold);
}

.story-content {
  display: grid;
  gap: 2rem;
  max-width: 800px;
  margin: 0 auto;
}

.story-text {
  font-size: 1.1rem;
  line-height: 1.7;
  color: var(--ink);
  margin: 0;
  text-align: justify;
}

.awards-section {
  background: var(--glass-bg);
  backdrop-filter: blur(24px) saturate(160%);
  -webkit-backdrop-filter: blur(24px) saturate(160%);
  border: 1px solid var(--glass-stroke);
  border-radius: 20px;
  padding: 60px 40px;
  margin: 60px 0;
}

.awards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  max-width: 800px;
  margin: 0 auto;
}

.award-item {
  text-align: center;
  padding: 2rem 1.5rem;
  background: rgba(255, 255, 255, 0.6);
  border-radius: 16px;
  border: 1px solid var(--glass-stroke);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.award-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.award-year {
  font-size: 2rem;
  font-weight: 600;
  color: var(--gold);
  margin-bottom: 0.5rem;
  font-family: "Cormorant Garamond", ui-serif, Georgia, Cambria, Times, serif;
}

.award-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--ink);
  margin-bottom: 0.5rem;
  line-height: 1.3;
}

.award-org {
  font-size: 0.9rem;
  color: var(--muted);
  font-style: italic;
}

.philosophy-section {
  background: linear-gradient(135deg, rgba(191, 164, 111, 0.05) 0%, rgba(245, 245, 243, 0.8) 100%);
  border-radius: 20px;
  padding: 60px 40px;
  margin: 60px 0;
}

.philosophy-content {
  max-width: 800px;
  margin: 0 auto;
  display: grid;
  gap: 2rem;
}

.philosophy-text {
  font-size: 1.1rem;
  line-height: 1.7;
  color: var(--ink);
  margin: 0;
  text-align: justify;
}

.about-cta {
  text-align: center;
  background: var(--glass-bg);
  backdrop-filter: blur(24px) saturate(160%);
  -webkit-backdrop-filter: blur(24px) saturate(160%);
  border: 1px solid var(--glass-stroke);
  border-radius: 20px;
  padding: 60px 40px;
  margin-top: 60px;
}

.cta-title {
  font-family: "Cormorant Garamond", ui-serif, Georgia, Cambria, Times, serif;
  font-size: 2.5rem;
  font-weight: 600;
  color: var(--ink);
  margin: 0 0 1rem 0;
  letter-spacing: 1px;
}

.cta-text {
  font-size: 1.2rem;
  color: var(--muted);
  margin: 0 0 2rem 0;
  line-height: 1.6;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 2rem;
}

.cta-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.btn-primary {
  background: var(--ink);
  color: #fff;
  border: 1px solid var(--ink);
  padding: 16px 32px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 500;
  font-size: 1rem;
  transition: all 0.3s ease;
  min-height: 44px;
  min-width: 44px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-primary:hover {
  background: var(--gold);
  border-color: var(--gold);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-secondary {
  background: transparent;
  color: var(--ink);
  border: 1px solid var(--ink);
  padding: 16px 32px;
  border-radius: 12px;
  text-decoration: none;
  font-weight: 500;
  font-size: 1rem;
  transition: all 0.3s ease;
  min-height: 44px;
  min-width: 44px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-secondary:hover {
  background: var(--ink);
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Responsive Design */
@media (max-width: 768px) {
  .about-hero {
    padding: 80px 0 60px;
  }
  
  .about-content {
    padding: 60px 0;
  }
  
  .about-container {
    padding: 0 1rem;
  }
  
  .about-section {
    margin-bottom: 60px;
  }
  
  .awards-section,
  .philosophy-section,
  .about-cta {
    padding: 40px 20px;
    margin: 40px 0;
  }
  
  .awards-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .cta-buttons {
    flex-direction: column;
    align-items: center;
  }
  
  .btn-primary,
  .btn-secondary {
    width: 100%;
    max-width: 300px;
  }
  
  .story-text,
  .philosophy-text {
    text-align: left;
  }
}

@media (max-width: 480px) {
  .about-title {
    font-size: 2.5rem;
  }
  
  .about-subtitle {
    font-size: 1.1rem;
  }
  
  .section-title {
    font-size: 1.8rem;
  }
  
  .cta-title {
    font-size: 2rem;
  }
}
</style>

<?php include __DIR__ . "/includes/footer.php"; ?>




