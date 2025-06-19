<?php
session_start();
include 'db_confib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Check if the new password and confirm new password match
    if ($newPassword !== $confirmNewPassword) {
        echo "New passwords do not match.";
        exit;
    }

    // Fetch the current password hash from the database
    $stmt = $conn->prepare("SELECT password FROM faculty WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    // Verify the current password
    if (password_verify($currentPassword, $hashedPassword)) {
        // Hash the new password
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE faculty SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $newHashedPassword, $username);
        if ($stmt->execute()) {
            echo "Password changed successfully.";
        } else {
            echo "Error changing password.";
        }
    } else {
        echo "Current password is incorrect.";
    }

    $stmt->close();
    $conn->close();
}
?>
##change_password.php