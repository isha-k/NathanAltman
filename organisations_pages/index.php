<?php
global $dbh;
require_once("../authentication.php");

$queryOrganisations = "SELECT * FROM `organisations`";

$stmt = $dbh->prepare($queryOrganisations);
$stmt->execute();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Organisations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<?php
//Include navbar
require("navbar_organisations.html");
?>

<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="add.php" role="button">Add new organisation</a>
</div>

<div class="ms-5 me-5">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Organisation ID</th>
            <th scope="col">Business Name</th>
            <th scope="col">Current Website</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <tr>
                <th scope="row"><?= $row->org_id ?></th>
                <td class="business_name"><?= $row->business_name ?></td>
                <td class="current_website"><?= $row->current_website ?></td>
                <td>
                    <a href="view_organisation.php?org_id=<?= $row->org_id ?>">View</a>
                    <a href="update.php?org_id=<?= $row->org_id ?>">Update</a>
                    <a href="delete.php?org_id=<?= $row->org_id ?>" class="delete-organisation" data-org-id="<?= $row->org_id ?>" onclick="return confirmDelete(event)">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <script>
        // Function to confirm the deletion
        function confirmDelete(event) {
            // Get the business name from the table row
            let buttonParent = event.target.parentNode.parentNode;
            let businessName = buttonParent.querySelector('.business_name').textContent;

            // Check if there are associated records in clients_organisations
            let orgID = event.target.getAttribute('data-org-id');

            // Display a confirmation dialog with a warning message
            if (confirm('WARNING: Deleting this organization will also delete associated client records\n\nAre you sure you want to delete the organization named "' + businessName + '"?')) {
                // Redirect to the PHP script responsible for handling the deletion
                window.location.href = 'delete_with_associations.php?org_id=' + orgID;
            } else {
                event.preventDefault(); // If the user cancels the dialog box, prevent the link from being followed
            }
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
