<?php
global $dbh;
require_once("../authentication.php");

$queryUsers = "SELECT * FROM `users`";

$stmt = $dbh->prepare($queryUsers);
$stmt->execute();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<?php
//Include navbar
require("navbar_users.html");
?>

<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="add.php" role="button">Add new user</a>
</div>

<div class="ms-5 me-5">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">User ID</th>
            <th scope="col">Username</th>
            <th scope="col">Full name</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <tr>
                <th scope="row"><?= $row->id?></th>
                <td class="username"><?= $row->username ?></td>
                <td class="fullname"><?= $row->fullname ?></td>
                <td class="email"><?= $row->email ?></td>
                <td class="password"><?= $row->password ?></td>
                <td>
                    <a href="update.php?id=<?= $row->id ?>">Update</a>
                    <a href="delete.php?id=<?= $row->id ?>" class="delete-user">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<script>
    // Add a confirmation box to all delete buttons
    Array.from(document.getElementsByClassName('delete-user')).forEach((element) => {
        element.addEventListener('click', (event) => {
            // Get clients from the table row
            let buttonParent = event.target.parentNode.parentNode;
            // Render the dialog box
            if (!confirm('Are you sure you wish to delete the user named "' + buttonParent.querySelector('.fullname').textContent + '"?'))
                event.preventDefault();  // If the user cancel the dialog box, do nothing
        })
    });
</script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
