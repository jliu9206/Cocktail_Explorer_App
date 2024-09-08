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
    header("Location: login.php"); // Redirect back to the login page to display the error
    exit();
}

$mysqli->set_charset('utf8');

$username = isset($_POST['username']) ? trim($_POST['username']) : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if (empty($username) || empty($password)) {
    $_SESSION['error_message'] = "Username or password cannot be empty.";
    header("Location: login.php"); // Redirect back to the login page to display the error
    exit();
}

$stmt = $mysqli->prepare("SELECT user_id, password, email FROM Users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if ($password === $user['password']) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $user['email'];
        header("Location: discover.php"); 
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: login.php"); 
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid username or password.";
    header("Location: login.php"); 
    exit();
}

$stmt->close();
$mysqli->close();
?>
