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

$username = isset($_POST['username']) ? trim($_POST['username']) : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

$stmt = $mysqli->prepare("SELECT * FROM Users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error_message'] = "Username already taken.";
    header("Location: login.php"); 
    exit();
} 
else {
    $stmt = $mysqli->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Email already taken.";
        header("Location: login.php"); 
        exit();
    }
    else{
        $stmt = $mysqli->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            header("Location: discover.php");
        } else {
            $_SESSION['error_message'] = "Error registering the user: " . $stmt->error;
            header("Location: login.php");
        }
    }

    $stmt->close();
    $mysqli->close();
}
    ?>
