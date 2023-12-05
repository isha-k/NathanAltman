<?php
global $dbh;
require_once("../authentication.php");
$id = $_GET['client_id'];

$queryOrganisations = "SELECT DISTINCT CU.form_id AS Form_ID, CU.*
    FROM CLIENTS C 
    JOIN CLIENT_CONTACT_US CO ON C.client_id = CO.client_id
    JOIN CONTACT_US CU ON CO.form_id = CU.form_id
    WHERE C.client_id = :client_id";

$stmt = $dbh->prepare($queryOrganisations);
$stmt->bindParam(':client_id', $id, PDO::PARAM_INT);
$stmt->execute();


// Check if there are no organisations found
if ($stmt->rowCount() == 0) {
    $noFormsMessage = "No Contact forms associated with this client";
}
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
require("navbar_clients.html");
?>


<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="index.php" role="button">Back</a>
</div>

<div class="ms-5 me-5">
    <?php if (isset($noFormsMessage)): ?>
        <div class="alert alert-info" role="alert">
            <?= $noFormsMessage ?>
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Form ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Message</th>
                <th scope="col">Replied</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetchObject()): ?>
                <tr>
                    <th scope="row"><?= $row->form_id ?></th>
                    <td class="name"><?= $row->name ?></td>
                    <td class="email"><?= $row->email ?></td>
                    <td class="phone_number"><?= $row->phone_number ?></td>
                    <td class="message"><?= $row->message ?></td>
                    <td class="replied">
                        <?php if ($row->replied == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        } ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
