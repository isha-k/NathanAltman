<?php
global $dbh;
require_once("../authentication.php");

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        // Add a new exhibit record to the database
        $query = "INSERT INTO `users` (`username`, `fullname`, `email`, `password`) VALUES (:username, :fullname, :email, SHA2(:password, 0))";
        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute([
            'username' => $_POST['username'],
            'fullname' => $_POST['fullname'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ]);

        // Redirect the user back to where we were
        header('Location: index.php');

    } catch (PDOException $e) {
        displayPDOError($e);
    }
else: ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add User</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    </head>
    <body>

    <?php
    //Include navbar
    require("navbar_users.html");
    ?>


    <div class="text-center fs-3 mt-3 mb-3">
        <p>Add User</p>
    </div>

    <div class="container-fluid">
        <div class="bg-light pt-5 pb-5">
            <div class="ms-5 me-5">
                <form class="row g-3" method="post">
                <form method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="username" name="username" size="40" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="fullname" class="form-label">Full name:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="fullname" name="fullname" size="40" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label><br>
                        <input type="email" class="form-control" id="email" name="email" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password:</label><br>
                        <input type="password" class="form-control" maxlength="255" id="password" name="password" size="40" required><br>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a class="btn btn-primary" class="form-control" href="index.php" role="button">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    </body>
    </html>
<?php endif; ?>