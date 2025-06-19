<?php
session_start();
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $club = $_POST['clubName'];

    if (empty($username) || empty($password) || empty($club)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM coordinators WHERE username = ? AND club = ?");
    if (!$stmt) {
        error_log("SQL error: " . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Database error. Please try again later.']);
        exit;
    }

    $stmt->bind_param("ss", $username, $club);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        $_SESSION['username'] = $username;
        $_SESSION['club'] = $club;
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: login.html');
    exit;
}
?>
