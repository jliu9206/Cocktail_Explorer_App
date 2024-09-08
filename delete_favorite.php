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
header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($_SESSION['user_id'], $data['id'])) {
        echo "Failed to remove favorite: User not logged in or no cocktail specified.";
        exit;
    }

    $userId = $_SESSION['user_id'];
    $cocktailId = $mysqli->real_escape_string($data['id']);

    $stmt = $mysqli->prepare("DELETE FROM Favorites WHERE user_id = ? AND cocktail_id = ?");
    $stmt->bind_param("is", $userId, $cocktailId);
    if ($stmt->execute()) {
        echo "Cocktail removed from favorites!";
    } else {
        echo "Failed to remove cocktail from favorites.";
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "Invalid request method.";
}
?>
