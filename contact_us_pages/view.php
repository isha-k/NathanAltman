<?php
session_start();
global $dbh;
require_once("../connection.php");
$queryForms = "SELECT * FROM `contact_us` WHERE `form_id` = :form_id";

$stmt = $dbh->prepare($queryForms);
$stmt->execute([
    'form_id' => $_GET["form_id"]
]);

$queryClients = "SELECT C.* FROM `clients` C
                JOIN `client_contact_us` CO ON C.client_id = CO.client_id
                WHERE CO.form_id = :form_id";

$stmtClients = $dbh->prepare($queryClients);
$stmtClients->execute([
    'form_id' => $_GET["form_id"]
]);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact Us Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<?php
//Include navbar
require("navbar_contact.php");
?>

<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="contact_forms.php" role="button">Back</a>
</div>

<div class="ms-5 me-5">
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
    <div class="mt-5 mb-5">

    <h3>Associated Client:</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Client ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($clientRow = $stmtClients->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <th scope="row"><?= $clientRow['client_id'] ?></th>
                <td><?= $clientRow['first_name'] ?></td>
                <td><?= $clientRow['surname'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
