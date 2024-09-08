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

    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit();
    }

    $userId = $_SESSION['user_id'];
    $cocktailId = $mysqli->real_escape_string($data['id']);
    $cocktailName = $mysqli->real_escape_string($data['name']);
    $imgUrl = $mysqli->real_escape_string($data['image']);

    // Check if already in favorites
    $stmt = $mysqli->prepare("SELECT 1 FROM Favorites WHERE user_id = ? AND cocktail_id = ?");
    $stmt->bind_param("is", $userId, $cocktailId);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Cocktail already in favorites.";
        exit();
    }

    // Insert new favorite
    $insertStmt = $mysqli->prepare("INSERT INTO Favorites (user_id, cocktail_id, cocktail_name, img_URL) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("isss", $userId, $cocktailId, $cocktailName, $imgUrl);
    if ($insertStmt->execute()) {
        echo "Added to favorites successfully.";
    } else {
        echo "Failed to add to favorites.";
    }
    $insertStmt->close();
} else {
    echo "Invalid request method.";
}

$mysqli->close();
?>