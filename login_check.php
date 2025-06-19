<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'faculty') {
        $stmt = $conn->prepare("SELECT password FROM faculty WHERE username = ?");
    } elseif ($role == 'coordinator') {
        $stmt = $conn->prepare("SELECT password FROM coordinators WHERE username = ?");
    } else {
        $stmt = $conn->prepare("SELECT password FROM student WHERE username = ?");
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        $_SESSION['username'] = $username;
        if ($role == 'faculty') {
            header('Location: facultyview.php');
        } elseif ($role == 'coordinator') {
            header('Location: clubSelection.html');
        } else {
            header('Location: cluborcollege.html');
        }
        exit;
    } else {
        header('Location: login.html?error=1');
        exit;
    }

    $stmt->close();
    $conn->close();
}