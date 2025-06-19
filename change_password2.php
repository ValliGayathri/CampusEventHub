<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    echo "You must be logged in to change your password.";
    exit;
}

$username = $_SESSION['username'];
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

if ($newPassword !== $confirmPassword) {
    echo "New passwords do not match.";
    exit;
}

$stmt = $conn->prepare("SELECT password FROM coordinators WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashedPassword);
$stmt->fetch();

if ($stmt->num_rows > 0 && password_verify($currentPassword, $hashedPassword)) {
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateStmt = $conn->prepare("UPDATE coordinators SET password = ? WHERE username = ?");
    $updateStmt->bind_param("ss", $newHashedPassword, $username);
    $updateStmt->execute();
    echo "Password changed successfully.";
} else {
    echo "Current password is incorrect.";
}

$stmt->close();
$conn->close();
?>
