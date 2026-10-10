<?php
require_once __DIR__ . '/../includes/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <h1>Home</h1>

    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
    <p>Your email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
