<?php
require_once __DIR__ . '/../config/database.php';

$error = "";
$name = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($name === '') {
        $error = "Name is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($password) < 8) {
        $error = "Password must contain at least 8 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $name, $email, $hash);
            $stmt->execute();

            header("Location: login.php?registered=1");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <h1>Create Account</h1>

    <?php if ($error !== ""): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Name</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br><br>

        <label>Email</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>

        <label>Password</label><br>
        <input type="password" name="password"><br><br>

        <label>Confirm Password</label><br>
        <input type="password" name="confirm_password"><br><br>

        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</body>
</html>
