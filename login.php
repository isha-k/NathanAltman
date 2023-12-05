<?php
session_start();

include("connection.php");

// Activate the session
global $dbh;

// Test if the user already logged in. If yes, send the user back to dashboard
if (isset($_SESSION['user_id']))
    header("Location: index.php");
?>
<html lang="en_AU">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body class="authentication">

<?php
//Include navbar
require("navbar_main.php");
?>

<div class="text-center">
    <p class="fs-1">Login</p>
    <p class="fs-4">Please login with your credentials:</p>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        //Run some SQL query here to find that user
        $stmt = $dbh->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
        if ($stmt->execute([
                $_POST['username'],
                hash('sha256', $_POST['password'])
            ]) && $stmt->rowCount() > 0) {
            $row = $stmt->fetchObject();
            $_SESSION['user_id'] = $row->id;
            //Successfully logged in, redirect user to dashboard
            header("Location: index.php");
        } else {
            echo "<h3>Either username or password is incorrect!</h3>";
        }
    }
}
?>
<div class="bg-light pt-5 pb-5">
    <div class="container text-centre">
        <form method="post">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control"required/>
            <br>
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required/>
            <br>
            <br>
            <div>
                <button type="submit" class="btn btn-primary" value="Login">Login</button>
            </div>
        </form>
    </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
