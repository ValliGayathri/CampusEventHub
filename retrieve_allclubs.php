<?php
require 'db_config.php';

$result = $conn->query('SELECT * FROM clubevents');
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);

$conn->close();
?>
