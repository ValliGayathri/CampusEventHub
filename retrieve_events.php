<?php
session_start();
require 'db_config.php';

$username = $_SESSION['username'];

$stmt = $conn->prepare('SELECT id, eventName, eventDate, eventDescription, googleFormLink FROM clgevents WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

header('Content-Type: application/json');
echo json_encode($events);

$stmt->close();
$conn->close();
?>
