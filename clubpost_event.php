<?php
session_start();
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username']; // Get username from session
    $club = $_SESSION['club']; // Get club from session
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $eventVenue = $_POST['eventVenue'];
    $eventDescription = $_POST['eventDescription'];
    $googleFormLink = $_POST['googleFormLink'];

    $stmt = $conn->prepare('INSERT INTO clubevents (username, club, eventName, eventDate, eventTime, eventVenue, eventDescription, googleFormLink) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssssss', $username, $club, $eventName, $eventDate, $eventTime, $eventVenue, $eventDescription, $googleFormLink);
    $stmt->execute();
    echo 'Event posted successfully';
    $stmt->close();
    $conn->close();
}
?>
