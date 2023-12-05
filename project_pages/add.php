<?php
global $dbh;
require_once("../authentication.php");

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
//
//        //Combine semester and year inputs to insert into database
//        $semester_and_year = $_POST['semester'] . ' ' . $_POST['year'];

        // Add a new project record to the database
        $query = "INSERT INTO `projects` (`project_name`, `semester_and_year`, `project_description`, `proposal`,
                        `what_is_working`, `what_is_not_working`, `client_id`) VALUES (:project_name, :semester_and_year,
                        :project_description, :proposal, :what_is_working, :what_is_not_working, :client_id)";
        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute([
            'project_name' => $_POST['project_name'],
            'semester_and_year' => $_POST['semester_and_year'],
            'project_description' => $_POST['project_description'],
            'proposal' => $_POST['proposal'],
            'what_is_working' => $_POST['what_is_working'],
            'what_is_not_working' => $_POST['what_is_not_working'],
            'client_id' => $_POST['client_id'],
        ]);

        // Redirect the user back to where we were
        header('Location: index.php');
    } catch (PDOException $e) {
        displayPDOError($e);
    }
else: ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Project</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    </head>
    <body>

    <?php
    //Include navbar
    require("navbar_projects.html");
    ?>

    <div class="text-center fs-3 mt-3 mb-3">
        <p>Add Project</p>
    </div>

    <div class="container-fluid">
        <div class="bg-light pt-5 pb-5">
            <div class="ms-5 me-5">
                <form class="row g-3" method="post">
                    <div class="col-md-6">
                        <label for="project_name" class="form-label">Project name:</label><br>
                        <input type="text" class="form-control" maxlength="100" id="project_name" name="project_name" size="40" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="semester_and_year" class="form-label">Semester and Year:</label><br>
                        <select class="form-select" id="semester_and_year" name="semester_and_year" required>
                            <?php
                            $startYear = 2010;
                            $endYear = date("Y"); // Current year

                            for ($year = $startYear; $year <= $endYear; $year++) {
                                echo '<option value="Semester 1 ' . $year . '">Semester 1 ' . $year . '</option>';
                                echo '<option value="Semester 2 ' . $year . '">Semester 2 ' . $year . '</option>';
                            }
                            ?>
                        </select><br>
                    </div>

                    <div class="form-group">
                        <label for="project_description">Project Description:</label>
                        <textarea class="form-control" id="project_description" rows="3" name="project_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="proposal">Proposal:</label>
                        <textarea class="form-control" id="proposal" rows="2" name="proposal" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="what_is_working">What is working:</label>
                        <textarea class="form-control" id="what_is_working" rows="3" name="what_is_working" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="what_is_not_working">What is not working:</label>
                        <textarea class="form-control" id="what_is_not_working" rows="3" name="what_is_not_working" required></textarea>
                    </div>
                    <div>
                        <label for="client_id">Client:</label><br>
                        <select id="client_id" name="client_id" required>
                            <option value="">==No Client Selected==</option>
                            <?php
                            $stmtClients = $dbh->prepare("SELECT * FROM `clients` ORDER BY `first_name`");
                            $stmtClients->execute();

                            while ($row = $stmtClients->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="' . $row['client_id'] . '">' . $row['first_name'] . " " . $row['surname'] . '</option>';
                            }
                            ?>
                        </select><br><br>
                    <div>
                        <button type="submit" class="btn btn-primary">Add</button>
                        <a class="btn btn-primary" href="index.php" role="button">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
<?php endif; ?>