<?php
global $dbh;
require_once("../authentication.php");

$queryClients = "SELECT * FROM `projects` ORDER BY `project_name` ASC";

$stmt = $dbh->prepare($queryClients);
$stmt->execute();
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
require("navbar_projects.html");
?>

<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="add.php" role="button">Add new project</a>
</div>

<div class="ms-5 me-5">
    <div class="mb-3">
        <label for="search" class="form-label">Search by Project Name:</label>
        <input type="text" class="form-control" id="search" placeholder="Enter project name"><br>
        <button type="button" class="btn btn-primary" id="searchButton">Search</button>
    </div>

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
            <th scope="col">Client ID</th>
            <th scope="col">Actions</th>
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
                <td class="client_id"><?= $row->client_id ?></td>
                <td>
                    <a href="update.php?project_id=<?= $row->project_id ?>">Update</a>
                    <a href="delete.php?project_id=<?= $row->project_id ?>" class="delete-project">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<script>
    // Add a confirmation box to all delete buttons
    Array.from(document.getElementsByClassName('delete-project')).forEach((element) => {
        element.addEventListener('click', (event) => {
            // Get clients from the table row
            let buttonParent = event.target.parentNode.parentNode;
            // Render the dialog box
            if (!confirm('Are you sure to delete the project named "' + buttonParent.querySelector('.project_name').textContent + '"?'))
                event.preventDefault();  // If the user cancel the dialog box, do nothing
        })
    });
</script>

    <script>
        // Get all rows of the table
        const rows = document.querySelectorAll('tbody tr');

        // Add an event listener to the search button
        document.getElementById('searchButton').addEventListener('click', () => {
            // Get the search input value
            const searchQuery = document.getElementById('search').value.toLowerCase();

            // Loop through each row and hide/show based on the search query
            rows.forEach(row => {
                const projectName = row.querySelector('.project_name').textContent.toLowerCase();
                if (projectName.includes(searchQuery)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
