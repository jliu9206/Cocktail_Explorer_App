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
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$userId = $_SESSION['user_id'];
$query = "SELECT * FROM Favorites WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$favorites = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($favorites);

$stmt->close();
$mysqli->close();
?>