<?php
global $dbh;
include("connection.php");
session_start();

$queryUsers = "SELECT * FROM `users`";

$stmt = $dbh->prepare($queryUsers);
$stmt->execute();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        table, tr, th, td {
            border: 1px black solid;
        }
    </style>
</head>
<body>

<?php

//Include navbar
require("navbar_main.php");


if (isset($_SESSION['user_id'])) {
    ?>
    <div class="text-center mt-5">
        <div class="fs-1">
            <?php $row = $stmt->fetchObject()?>
            <p>Welcome, <?= $row->fullname?></p>
        </div>
    </div>
<?php } ?>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="carousel1.avif" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="carousel2.avif" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="carousel3.avif" alt="Third slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>