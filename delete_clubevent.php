<?php
session_start();
require 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $eventId = $data['id'] ?? '';

    if (!empty($eventId)) {
        $stmt = $conn->prepare('DELETE FROM clubevents WHERE id = ?');
        $stmt->bind_param('i', $eventId);

        if ($stmt->execute()) {
            echo 'Event deleted successfully';
        } else {
            echo 'Error: Could not delete event';
        }

        $stmt->close();
    } else {
        echo 'Error: Event ID not provided';
    }
} else {
    echo 'Error: Invalid request method';
}

$conn->close();
?>
