<?php
global $dbh;
require_once("../authentication.php");

$queryClients = "SELECT * FROM `clients`";

$stmt = $dbh->prepare($queryClients);
$stmt->execute();
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
        <a class="btn btn-primary" href="add.php" role="button">Add new client</a>
    </div>

    <div class="ms-5 me-5">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Client ID</th>
                <th scope="col">Client Photo</th>
                <th scope="col">First Name</th>
                <th scope="col">Surname</th>
                <th scope="col">View Projects</th>
                <th scope="col">View Organisations</th>
                <th scope="col">View Contact Forms</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            <?php while ($row = $stmt->fetchObject()): ?>
                <tr>
                    <th scope="row"><?= $row->client_id ?></th>
                    <td>
                        <?php
                        // Construct the absolute file path and URL
                        $absoluteFilePath = APP_FOLDER_PATH . '/client_profiles/' . $row->client_photo_path;
                        $fileUrl = APP_URL_PATH . '/client_profiles/' . $row->client_photo_path;

                        // Check if the file exists before adding the "View" link
                        if (file_exists($absoluteFilePath)) {
                            echo '<img src="' . $fileUrl . '" alt="' . $row->first_name . ' ' . $row->surname . '" class="img-fluid rounded-circle" style="width: 50px; height: 50px;">';
                        } else {
                            echo '<div class="avatar-placeholder rounded-circle">No Photo</div>';
                        }
                        ?>
                    </td>
                    <td class="first_name"><?= $row->first_name ?></td>
                    <td class="surname"><?= $row->surname ?></td>
                    <td><a href="view_projects.php?client_id=<?= $row->client_id?>">Projects</a></td>
                    <td><a href="view_organisations.php?client_id=<?= $row->client_id?>">Organisations</a></td>
                    <td><a href="view_forms.php?client_id=<?= $row->client_id?>">View Contact forms</a></td>
                    <td>
                        <a href="view_profile.php?client_id=<?= $row->client_id ?>">View Profile</a><br>
                        <a href="update.php?client_id=<?= $row->client_id ?>">Update</a><br>
                        <a href="delete.php?client_id=<?= $row->client_id ?>" class="delete-client">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<script>
    // Add a confirmation box to all delete buttons
    Array.from(document.getElementsByClassName('delete-client')).forEach((element) => {
        element.addEventListener('click', (event) => {
            // Get clients from the table row
            let buttonParent = event.target.parentNode.parentNode;

            // Construct the confirmation message
            let clientName = buttonParent.querySelector('.first_name').textContent;
            let confirmationMessage = 'Are you sure you want to delete the client named "' + clientName + '"?\n\n' +
                'This action will also delete the corresponding projects, ' +
                'contact forms, and organizations.';

            // Render the dialog box
            if (!confirm(confirmationMessage))
                event.preventDefault();  // If the user cancels the dialog box, do nothing
        })
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
