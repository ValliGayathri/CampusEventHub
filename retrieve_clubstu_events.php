<?php
require 'db_config.php';

$club = $_GET['club'];

$sql = "SELECT * FROM clubevents WHERE club = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $club);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while($row = $result->fetch_assoc()) {
    $events[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($events);
?>
