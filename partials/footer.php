<?php
// partials/footer.php
$year = date("Y");
?>
    </main>
    <footer class="site-footer">
      <div class="container footer-inner">
        <p>&copy; <?php echo $year; ?> <?php echo htmlspecialchars($SITE_NAME); ?>. First-stage prototype (no database yet).</p>
      </div>
    </footer>
  </body>
</html>
