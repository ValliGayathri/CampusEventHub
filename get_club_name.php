<?php
require 'db_config.php';

$query = '
    SELECT *
    FROM coordinators
';
$result = $conn->query($query);
$events = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($events);

$conn->close();
?>
