<?php
require 'db_config.php';

$coordinators = [
    ['username' => 'coordinator1', 'password' => 'password111', 'club' => 'happy club'],
    ['username' => 'coordinator2', 'password' => 'password222', 'club' => 'echarts club'],
    ['username' => 'coordinator3', 'password' => 'password333', 'club' => 'photography club'],
    ['username' => 'coordinator4', 'password' => 'password444', 'club' => 'dance club'],
    
];

$stmt = $conn->prepare('INSERT INTO coordinators (username, password, club) VALUES (?, ?, ?)');

foreach ($coordinators as $coordinator) {
    $username = $coordinator['username'];
    $hashedPassword = password_hash($coordinator['password'], PASSWORD_BCRYPT);
    $club = $coordinator['club'];
    $stmt->bind_param('sss', $username, $hashedPassword, $club);
    $stmt->execute();
}

echo 'Coordinators inserted successfully';
?>
