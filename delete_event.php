<?php
session_start();
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $data = json_decode(file_get_contents('php://input'), true);
    $eventId = $data['id'];
    $username = $_SESSION['username'];

    $stmt = $conn->prepare('DELETE FROM collegeevents WHERE id = ? AND username = ?');
    $stmt->bind_param('is', $eventId, $username);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'Event deleted successfully';
    } else {
        echo 'Error deleting event';
    }

    $stmt->close();
    $conn->close();
}
?>
