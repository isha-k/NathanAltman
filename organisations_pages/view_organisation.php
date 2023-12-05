<?php
global $dbh;
require_once("../authentication.php");
$queryOrganisations = "SELECT * FROM `organisations` WHERE `org_id` = :org_id";

$stmt = $dbh->prepare($queryOrganisations);
$stmt->execute([
    'org_id' => $_GET["org_id"]
]);

$queryClients = "SELECT C.* FROM `clients` C
                JOIN `clients_organisations` CO ON C.client_id = CO.client_id
                WHERE CO.org_id = :org_id";

$stmtClients = $dbh->prepare($queryClients);
$stmtClients->execute([
    'org_id' => $_GET["org_id"]
]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Organisation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
//Include navbar
require("navbar_organisations.html");
?>


<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="index.php" role="button">Back</a>
</div>

<div class="ms-5 me-5">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Organisation ID</th>
            <th scope="col">Business Name</th>
            <th scope="col">Current Website</th>
            <th scope="col">Business Description</th>
            <th scope="col">Technology</th>
            <th scope="col">Industry</th>
            <th scope="col">Services</th>
            <th scope="col">Field</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetchObject()): ?>
            <tr>
                <th scope="row"><?= $row->org_id ?></th>
                <td class="business_name"><?= $row->business_name ?></td>
                <td class="current_website"><?= $row->current_website ?></td>
                <td class="business_description"><?= $row->business_description ?></td>
                <td class="technology_currently_used"><?= $row->technology_currently_used ?></td>
                <td class="industry_operated_in"><?= $row->industry_operated_in ?></td>
                <td class="services_offered"><?= $row->services_offered ?></td>
                <td class="field"><?= $row->field ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="mt-5 mb-5">

        <h3>Associated Clients:</h3>
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

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
