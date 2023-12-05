<?php
global $dbh;
require_once("../authentication.php");

// Test if exhibit id has been provided. If not, take user back to the listing page
if (empty($_GET['id'])) {
    header('Location: index.php');
}

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        // Update the record based on the form received
        $query = "UPDATE `users` SET 
                  `username` = :username, 
                  `fullname` = :fullname,
                  `email` = :email,
                  `password` = SHA2(:password, 0)
            WHERE `id` = :id";
        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute([  'username' => $_POST['username'],
            'fullname' => $_POST['fullname'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'id' => $_GET['id']
        ]);

        // And send the user back to where we were
        header('Location: index.php');
    } catch (PDOException $e) {
        displayPDOError($e);
    }
else:
    // Otherwise read the record from database with ID and prefill the form
    $stmt = $dbh->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $_GET['id']]);

    if ($stmt->rowCount() == 1 && $row = $stmt->fetchObject()): ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update User #<?= $row->id ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        </head>
        <body>

        <?php
        //Include navbar
        require("navbar_users.html");
        ?>

        <div class="text-center mt-3 mb-3">
            <div class="fs-3">
                <p>User ID: <?= $row->id?></p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="bg-light pt-5 pb-5">
                <div class="ms-5 me-5">
                    <form class="row g-3" method="post"><label for="user"></label><br>
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="username" name="username" size="40" value="<?=$row->username?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="fullname" class="form-label">Full Name:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="fullname" name="fullname" size="40" value="<?=$row->fullname?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email:</label><br>
                            <input type="email" class="form-control" id="email" name="email" value="<?=$row->email?>"required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password:</label><br>
                            <input type="password" class="form-control" maxlength="255" id="password" name="password" size="40" value="<?=$row->password?>" required><br>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-primary" href="index.php" role="button">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
    <?php else:
        // If the record is not found (rowcount is not 1), send user back to listing page (invalid ID)
        header('Location: index.php');
    endif;
endif; ?>