<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../config/database.php';

// If already logged in, go to home page
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}

$error = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare(
        "SELECT id, name, email, password_hash FROM users WHERE email = ?"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($_GET['registered'])): ?>
        <p style="color:green;">Account created! Please login.</p>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"><br><br>

        <label>Password</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Login</button>
    </form>

    <p>No account? <a href="signup.php">Sign up</a></p>
</body>
</html>
