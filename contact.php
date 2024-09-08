<?php
session_start();

$host = "303.itpwebdev.com";
$user = "jliu9206_db_user";
$pass = "Justin@@@20040502";
$db = "jliu9206_Cocktail_DB";

// Establish connection
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    $_SESSION['error_message'] = "Failed to connect to MySQL: " . $mysqli->connect_error;
    header("Location: login.php");
    exit();
}

$mysqli->set_charset('utf8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';
    $user = $_SESSION['user_id'];

    // Insert form data into your database
    $stmt = $mysqli->prepare("INSERT INTO User_Messages (user_id, message, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $user, $message);
    $stmt->execute();
    $stmt->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Cocktail Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Cocktail Explorer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="discover.php">Discover</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favorites.php">Favorites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact.php">Contact</a>
                    </li>
                </ul>
                <?php if (isset($_SESSION['username'])): ?>
                    <p class="navbar-text-light" id="loggedin">
                      Logged in as <?= htmlspecialchars($_SESSION['username']); ?>
                  </p>
                  <button onclick="location.href='logout.php'" class="btn" type="button">Logout</button>
              <?php else: ?>
                <a href="login.php" class="btn btn-outline-success">Login</a>
            <?php endif; ?>  
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1>Contact Us</h1>
    <p>Please fill out this form to send us your feedback or any queries.</p>
    <p>If you need to reach out directly:</p>
    <ul>
        <li>Name: Justin Liu</li>
        <li>Email: jliu9206@usc.edu</li>
    </ul>
    <form action="https://formspree.io/f/xdoqpjqg"  method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
        </div>
        <div class="mb-3" style="display: none;">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Type your message here"></textarea>
        </div>
        <input type="hidden" name="_subject" value="New submission!">
        <button type="submit" class="btn btn-custom">Send Message</button>
    </form>
</div>

<footer class="text-white text-center p-3 mt-5">
    <p>© 2024 Cocktail Explorer. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
