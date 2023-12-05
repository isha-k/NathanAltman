<?php
global $dbh;
require_once("../authentication.php");

// Test if project id has been provided. If not, take user back to the listing page
if (empty($_GET['project_id'])) {
    header('Location: index.php');
}

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
            // Update the project based on the form received
            $query = "UPDATE `projects` SET 
                  `project_name` = :project_name,
                  `semester_and_year` = :semester_and_year,
                  `project_description` = :project_description,
                  `proposal` = :proposal,
                  `what_is_working` = :what_is_working,
                  `what_is_not_working` = :what_is_not_working,
                  `client_id` = :client_id
            WHERE `project_id` = :project_id";
            $stmt = $dbh->prepare($query);

            // Execute the query
            $stmt->execute(['project_name' => $_POST['project_name'],
                'semester_and_year' => $_POST['semester_and_year'],
                'project_description' => $_POST['project_description'],
                'proposal' => $_POST['proposal'],
                'what_is_working' => $_POST['what_is_working'],
                'what_is_not_working' => $_POST['what_is_not_working'],
                'client_id' => $_POST['client_id'],
                'project_id' => $_GET['project_id']
            ]);

        // And send the user back to where we were
        header('Location: index.php');
    } catch (PDOException $e) {
        displayPDOError($e);
    }
else:
    // Otherwise read the record from database with ID and prefill the form
    $stmt = $dbh->prepare("SELECT * FROM `projects` WHERE `project_id` = :project_id");
    $stmt->execute(['project_id' => $_GET['project_id']]);

    if ($stmt->rowCount() == 1 && $row = $stmt->fetchObject()): ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update project #<?= $row->client_id ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        </head>
        <body>

        <?php
        //Include navbar
        require("navbar_projects.html");
        ?>

        <div class="text-center mt-3 mb-3">
            <div class="fs-3">
                <p>Project ID: <?= $row->project_id?></p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="bg-light pt-5 pb-5">
                <div class="ms-5 me-5">
                    <form class="row g-3" method="post">
                        <div class="col-md-6">
                            <label for="project_name" class="form-label">Project name:</label><br>
                            <input type="text" class="form-control" maxlength="100" id="project_name" name="project_name" size="40" value="<?=$row->project_name?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="semester_and_year" class="form-label">Semester and Year:</label><br>
                            <select id="semester_and_year" name="semester_and_year" class="form-control" required>
                                <?php
                                // Get the current year
                                $currentYear = date("Y");

                                // Loop for the past and future years
                                for ($year = $currentYear - 10; $year <= $currentYear + 5; $year++) {
                                    for ($semester = 1; $semester <= 2; $semester++) {
                                        // Create a label for the option
                                        $label = "Semester " . $semester . " " . $year;
                                        // Generate the option value
                                        $value = "Semester " . $semester . " " . $year;
                                        // Check if this option should be selected (based on the current value)
                                        $selected = ($row->semester_and_year === $value) ? 'selected' : '';
                                        // Output the option
                                        echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                                    }
                                }
                                ?>
                            </select><br>
                        </div>

                        <div class="form-group">
                            <label for="project_description" class="form-label">Project Description:</label><br>
                            <textarea class="form-control" id="project_description" name="project_description" rows="4" maxlength="500" required><?=$row->project_description?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="proposal" class="form-label">Proposal:</label><br>
                            <textarea class="form-control" id="proposal" name="proposal" rows="3" maxlength="500" required><?=$row->proposal?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="what_is_working" class="form-label">What is working:</label><br>
                            <textarea class="form-control" id="what_is_working" name="what_is_working" rows="3" maxlength="500" required><?=$row->what_is_working?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="what_is_not_working" class="form-label">What is not working:</label><br>
                            <textarea class="form-control" id="what_is_not_working" name="what_is_not_working" rows="3" maxlength="500" required><?=$row->what_is_not_working?></textarea>
                        </div>
                        <div>
                            <label for="client_id">Client:</label><br>
                            <select id="client_id" name="client_id">
                                <option value="">==No Client Selected==</option>
                                <?php
                                $stmtClients = $dbh->prepare("SELECT * FROM `clients` ORDER BY `first_name`");
                                $stmtClients->execute();

                                while ($clientRow = $stmtClients->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($clientRow['client_id'] == $row->client_id) ? 'selected' : '';
                                    echo '<option value="' . $clientRow['client_id'] . '" ' . $selected . '>' . $clientRow['first_name'] . " " . $clientRow['surname'] . '</option>';
                                }
                                ?>
                            </select><br><br>
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