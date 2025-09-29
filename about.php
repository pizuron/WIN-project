<?php
// about.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | FlavorTown Restaurant</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS -->
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <h1>FlavorTown</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <h2>About Us</h2>
        <p>Where taste meets tradition. Learn our story below!</p>
    </section>

    <!-- About Content -->
    <section class="about-container">
        <div class="about-text">
            <h3>Our Story</h3>
            <p>
                At FlavorTown, we believe food is more than just a meal—it’s an experience. 
                Established in 2010, our restaurant brings authentic flavors, locally sourced 
                ingredients, and a passion for hospitality. 
            </p>
            <p>
                From our chef’s signature dishes to our warm, welcoming ambiance, we aim to create 
                unforgettable dining memories for every guest. Whether you’re here for a casual 
                meal or a special celebration, FlavorTown is the perfect destination. 
            </p>
        </div>

        <!-- Embedded Video -->
        <div class="about-video">
            <video controls>
                <source src="videos/restaurant-promo.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p class="caption">🍽️ A glimpse of FlavorTown</p>
        </div>
    </section>

    <!-- Extra Videos (Optional) -->
    <section class="video-gallery">
        <h3>Behind the Scenes</h3>
        <div class="videos">
            <iframe width="400" height="225" src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                    title="Kitchen Tour" frameborder="0" allowfullscreen></iframe>
            
            <iframe width="400" height="225" src="https://www.youtube.com/embed/jfKfPfyJRdk" 
                    title="Customer Experience" frameborder="0" allowfullscreen></iframe>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> FlavorTown Restaurant. All rights reserved.</p>
    </footer>
</body>
</html>

