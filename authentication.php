<?php
// Activate the session
global $dbh;
session_start();


// Connect to the database (you might want to include this here if not included elsewhere)
include("connection.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $dbh->prepare("SELECT * FROM `users` WHERE `id` = ?");
    if ($stmt->execute([$user_id]) && $stmt->rowCount() == 1) {
        $user = $stmt->fetchObject();
    }
    // The user is valid, and you can access their data using $user
} else {
    // The user is not valid, log them out
    session_destroy();
    header("Location: http://localhost/fit2104_assignment_3/login.php");
    exit;
}

