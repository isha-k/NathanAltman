<?php
// Activate the session
session_start();

include("connection.php");
global $dbh;
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
            header("location: index.php");
            session_destroy();

    } else {
        echo "<h1>Please Login or Register first!</h1>";
        echo "<a href='login.php'>Click here to login</a>";
    }

?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

