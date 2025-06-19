<?php
session_start();
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $eventVenue = $_POST['eventVenue'];
    $eventDescription = $_POST['eventDescription'];
    $googleFormLink = $_POST['googleFormLink'];

    $stmt = $conn->prepare('INSERT INTO clgevents (username, eventName, eventDate, eventTime, eventVenue, eventDescription, googleFormLink) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssss', $username, $eventName, $eventDate, $eventTime, $eventVenue, $eventDescription, $googleFormLink);
    

    if ($stmt->execute()) {
        echo 'Event posted successfully';
    } else {
        echo 'Error: Could not post event';
    }

    $stmt->close();
}

$conn->close();
?>
