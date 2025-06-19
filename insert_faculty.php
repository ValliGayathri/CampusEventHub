<?php
require 'db_config.php';

$faculties = [
    ['username' => 'faculty1', 'password' => 'pass111'],
    ['username' => 'faculty2', 'password' => 'pass222'],
    ['username' => 'faculty3', 'password' => 'pass333'],
    ['username' => 'faculty4', 'password' => 'pass444'],
];

$stmt = $conn->prepare('INSERT INTO faculty (username, password) VALUES (?, ?)');

foreach ($faculties as $faculty) {
    $username = $faculty['username'];
    $hashedPassword = password_hash($faculty['password'], PASSWORD_BCRYPT);

    $stmt->bind_param('ss', $username, $hashedPassword);
    $stmt->execute();
}

echo 'Faculty inserted successfully';
?>
