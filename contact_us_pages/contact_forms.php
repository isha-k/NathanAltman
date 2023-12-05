<?php
session_start();
global $dbh;
require_once("../connection.php");

$queryContactUs = "SELECT * FROM `contact_us`";

$stmt = $dbh->prepare($queryContactUs);
$stmt->execute();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Contact Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<?php
//Include navbar
require("navbar_contact.php");
?>

<div class="ms-5 me-5">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Form ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Associated Client</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <tr>
                <th scope="row"><?= $row->form_id ?></th>
                <td class="name"><?= $row->name ?></td>
                <td class="email"><?= $row->email ?></td>
                <td class="client_name">
                    <?php
                    // Fetch the associated client name using a JOIN
                    $clientQuery = "SELECT C.first_name, C.surname
                    FROM CLIENTS C
                    JOIN CLIENT_CONTACT_US CCU ON C.client_id = CCU.client_id
                    WHERE CCU.form_id = :form_id";

                    $clientStmt = $dbh->prepare($clientQuery);
                    $clientStmt->bindParam(':form_id', $row->form_id, PDO::PARAM_INT);
                    $clientStmt->execute();
                    $clientData = $clientStmt->fetch(PDO::FETCH_ASSOC);

                    // Display the client name if found, otherwise, display "No linked client"
                    if ($clientData) {
                        echo $clientData['first_name'] . ' ' . $clientData['surname'];
                    } else {
                        echo "No linked client";
                    }
                    ?>
                </td>

                <td>
                    <a href="view.php?form_id=<?= $row->form_id ?>">View form</a><br>
                    <a href="update.php?form_id=<?= $row->form_id ?>">Update client</a><br>
                    <a href="delete.php?form_id=<?= $row->form_id ?>" class="delete-form">Delete</a><br>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <script>
        // Add a confirmation box to all delete buttons
        Array.from(document.getElementsByClassName('delete-form')).forEach((element) => {
            element.addEventListener('click', (event) => {
                // Get clients from the table row
                let buttonParent = event.target.parentNode.parentNode;
                // Render the dialog box
                if (!confirm('Are you sure you want to delete the contact form from ' + buttonParent.querySelector('.name').textContent + '"?'))
                    event.preventDefault();  // If the user cancel the dialog box, do nothing
            })
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
