<?php
global $dbh;
require_once("../authentication.php");

$queryProjects = "SELECT * FROM `projects` WHERE `client_id` = :client_id";

$stmt = $dbh->prepare($queryProjects);
$stmt->execute([
    'client_id' => $_GET["client_id"]
]);

// Check if there are no projects found
if ($stmt->rowCount() == 0) {
    $noProjectsMessage = "No projects found for this client";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Projects</title>
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
    <?php if (isset($noProjectsMessage)): ?>
        <div class="alert alert-info" role="alert">
            <?= $noProjectsMessage ?>
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Project ID</th>
                <th scope="col">Project Name</th>
                <th scope="col">Semester and Year</th>
                <th scope="col">Project Description</th>
                <th scope="col">Proposal</th>
                <th scope="col">What is working</th>
                <th scope="col">What is not working</th>
            </tr>
            </thead>
            <tbody>

            <?php while ($row = $stmt->fetchObject()): ?>
                <tr>
                    <th scope="row"><?= $row->project_id ?></th>
                    <td class="project_name"><?= $row->project_name ?></td>
                    <td class="semester_and_year"><?= $row->semester_and_year ?></td>
                    <td class="project_description"><?= $row->project_description ?></td>
                    <td class="proposal"><?= $row->proposal ?></td>
                    <td class="what_is_working"><?= $row->what_is_working ?></td>
                    <td class="what_is_not_working"><?= $row->what_is_not_working ?></td>
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
