<?php
// about.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>About  | Briscola Italian Restaurant</title>
<style>
  body { 
      font-family: Arial, sans-serif; 
      max-width: 600px; 
      margin: 30px auto; 
      background-color: #fff;
      color: #333;
  }
  h1, h2 { color: green; text-align: center; }
  h2 { margin-top: 1rem; }
  p, li { font-size: 16px; line-height: 1.5; }
  ul { list-style-type: none; padding-left: 0; }
  nav { text-align: center; margin-bottom: 20px; }
  nav a { margin: 0 10px; text-decoration: none; color: #f4a261; font-weight: bold; }
  nav a.active { color: green; }
  .confirmation-box { 
      border: 1px solid #ddd; 
      padding: 20px; 
      border-radius: 10px; 
      margin-bottom: 20px; 
  }
  .row-end { 
      display: flex; 
      justify-content: flex-end; 
      margin-top: 10px; 
  }
  .btn-secondary { 
      background: #f4a261; 
      color: #fff; 
      padding: 8px 16px; 
      text-decoration: none; 
      border-radius: 6px; 
      font-weight: bold; 
  }
  footer { 
      text-align: center; 
      margin-top: 30px; 
      color: #777; 
      font-size: 14px; 
  }
</style>
</head>
<body>

<nav>
  <a href="index.php">Home</a> |
  <a href="about.php" class="active">About</a>
</nav>

<h1>About Us</h1>

<div class="confirmation-box">
    <p>
        Welcome to <strong>Briscola Italian Restaurant</strong> — where taste meets tradition. 
        Briscola has established itself on the Canberra food scene by offering an
        unpretentious yet stylish approach to an authentic Italian dining experience. At the forefront
        it’s about the food: simple, wholesome and traditional without being old fashioned.
        What sets us apart is how we transport you to Italy. Start with an aperitivo to open the
        palate, enjoy a local or Italian wine varietal and finish with a fragrant & herbal digestive.
        Briscola seems to suit anyone… corporate luncheons, young couples, families and
        group functions.
        Since 2010 the restaurant has been family owned by Italians. It has won a number of ACT
        Savour Awards including Canberra’s Best Pizzeria in 2014, Canberra’s Best Italian
        Restaurant 2015 and in 2016 gained accreditation from Accademia Della Cucina Italiana by
        the Italian Ambassador..
    </p>

    <p>
        Our chefs bring together classic recipes and modern twists, creating meals that leave 
        a lasting impression. Whether you’re dining in, ordering takeaway, or celebrating a 
        special moment with us, we aim to make every experience truly flavorful.
    </p>

    <p>
        Thank you for being a part of our journey. We look forward to serving you soon and making 
        your day a little more delicious!
    </p>

    <div class="row-end">
        <a href="menu.php" class="btn-secondary">Explore Our Menu</a>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> FlavorTown Restaurant. All rights reserved.</p>
</footer>

</body>
</html>




