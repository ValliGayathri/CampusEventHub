<?php
require 'db_config.php';

$result = $conn->query('SELECT * FROM clgevents ORDER BY eventDate DESC');
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>
