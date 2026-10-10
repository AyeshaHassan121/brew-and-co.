<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $conn->prepare("SELECT created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$since = $row ? date("j F Y", strtotime($row['created_at'])) : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brew and Co. - Welcome</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500&family=Karla:wght@400;500&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/home.css">
</head>
<body>

  <header class="site-header">
    <div class="container nav-container">

      <a href="index.html">
        <img src="images/logo.png" alt="Brew and Co. logo" class="logo-img">
      </a>
      <nav class="site-nav" id="site-nav" aria-label="Main navigation">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="menu.html">Menu</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>

      <button class="cart-btn" id="cart-btn" aria-label="View cart">
        🛒
        <span class="cart-count" id="cart-count">0</span>
      </button>

      <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
      </button>

    </div>
  </header>

  <main>
    <section class="welcome">
      <div class="container welcome-box">
        <p class="welcome-tag">You are logged in</p>
        <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <p>Signed in as <strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong></p>
        <?php if ($since !== ""): ?>
          <p>Member since <?php echo htmlspecialchars($since); ?></p>
        <?php endif; ?>
        <div class="welcome-actions">
          <a class="welcome-btn" href="menu.html">Browse the menu</a>
          <a class="welcome-btn welcome-btn-outline" href="logout.php">Logout</a>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
  <div class="container footer-container">
    <p>&copy; 2026 Brew and Co. &middot; Lahore &middot; All rights reserved</p>
    <p>Crafted with <span aria-hidden="true">&hearts;</span> in Lahore</p>
  </div>
</footer>
  <script src="js/script.js"></script>
</body>
</html>
