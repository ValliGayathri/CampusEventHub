<?php
session_start();
require 'db_config.php';

$username = $_SESSION['username'];

$stmt = $conn->prepare('SELECT id, eventName, eventDate, eventTime, eventVenue, eventDescription, googleFormLink FROM clubevents WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);

$stmt->close();
$conn->close();
?>
