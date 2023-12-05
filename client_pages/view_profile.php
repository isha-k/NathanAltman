<?php
global $dbh;
require_once("../authentication.php");

$queryClients = "SELECT * FROM `clients` WHERE `client_id` = :client_id";

$stmt = $dbh->prepare($queryClients);
$stmt->execute([
    'client_id' => $_GET["client_id"]
]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
//Include navbar
require("navbar_clients.html");
?>


<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="index.php" role="button">Back</a>
</div>

<?php while ($row = $stmt->fetchObject()): ?>
<div class="container text-center mb-5">
    <?php
    // Construct the absolute file path and URL
    $absoluteFilePath = APP_FOLDER_PATH . '/client_profiles/' . $row->client_photo_path;
    $fileUrl = APP_URL_PATH . '/client_profiles/' . $row->client_photo_path;

    // Check if the file exists before adding the "View" link
    if (file_exists($absoluteFilePath)) {
        echo '<img src="' . $fileUrl . '" alt="' . $row->first_name . ' ' . $row->surname . '" class="img-fluid rounded-circle" style="width: 140px; height: 140px;">';
    } else {
        echo '<div class="avatar-placeholder rounded-circle">No Photo</div>';
    }
    ?>
</div>
<div class="text-center mt-5">
    <div class="fs-3">
        <p>Client ID: <?= $row->client_id?></p>
    </div>
    <div class="fs-5">
        <p>Client Name: <?= $row->first_name.' '.$row->surname?></p>
        <p>Email: <?= $row->email?></p>
        <p>Address: <?= $row->address?></p>
        <p>Phone number: <?= $row->phone_number?></p>
        <p>Suburb: <?= $row->suburb?></p>
        <p>Recruited from: <?= $row->recruited_from_channel?></p>
    </div>
    <div class="mt-5 mb-5">
        <a class="btn btn-primary" href="update.php?client_id=<?= $row->client_id ?>" class="update-client">Update</a>
    </div>
</div>

<?php endwhile; ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
