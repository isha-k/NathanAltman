<?php
global $dbh;
require_once("../authentication.php");

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        // Add a new project record to the database
        $query = "INSERT INTO `organisations` (`business_name`, `current_website`, `business_description`, `technology_currently_used`,
                        `industry_operated_in`, `services_offered`, `field`) VALUES (:business_name, :current_website,
                        :business_description, :technology_currently_used, :industry_operated_in, :services_offered, :field)";
        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute([
            'business_name' => $_POST['business_name'],
            'current_website' => $_POST['current_website'],
            'business_description' => $_POST['business_description'],
            'technology_currently_used' => $_POST['technology_currently_used'],
            'industry_operated_in' => $_POST['industry_operated_in'],
            'services_offered' => $_POST['services_offered'],
            'field' => $_POST['field'],
        ]);

        // Get the ID of the newly added organization
        $newlyAddedOrgID = $dbh->lastInsertId();

        // Retrieve the selected client IDs
        $selectedClientIDs = isset($_POST['clients']) ? $_POST['clients'] : [];

        // Insert records into CLIENTS_ORGANISATIONS table to associate clients with the organisation
        foreach ($selectedClientIDs as $clientID) {
           // Insert into CLIENTS_ORGANISATIONS table with the organisation ID and client ID
            $insertClientOrgQuery = "INSERT INTO CLIENTS_ORGANISATIONS (client_id, org_id) VALUES (:client_id, :org_id)";
            $stmt = $dbh->prepare($insertClientOrgQuery);
            $stmt->execute([
                'client_id' => $clientID,
                'org_id' => $newlyAddedOrgID,
            ]);
        }

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
        <title>Add Organisation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>

    <?php
    //Include navbar
    require("navbar_organisations.html");
    ?>

    <div class="text-center fs-3 mt-3 mb-3">
        <p>Add Organisation</p>
    </div>

    <div class="container-fluid">
        <div class="bg-light pt-5 pb-5">
            <div class="ms-5 me-5">
                <form class="row g-3" method="post">
                    <div class="col-md-6">
                        <label for="business_name" class="form-label">Business name:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="business_name" name="business_name" size="40" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="current_website" class="form-label">Current website:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="current_website" name="current_website" size="40" required><br>
                    </div>
                    <div class="form-group">
                        <label for="business_description" class="form-label">Business Description:</label><br>
                        <textarea class="form-control" id="business_description" name="business_description" rows="4" maxlength="500" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="technology_currently_used" class="form-label">Technology currently used:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="technology_currently_used" name="technology_currently_used" size="40" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="industry_operated_in" class="form-label">Industry operated in:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="industry_operated_in" name="industry_operated_in" size="40" required><br>
                    </div>
                    <div class="form-group">
                        <label for="services_offered" class="form-label">Services offered:</label><br>
                        <textarea class="form-control" id="services_offered" name="services_offered" rows="2" maxlength="500" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="field" class="form-label">Field:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="field" name="field" size="40" required><br>
                    </div>
                    <div>
                        <label>Add client(s):</label><br>
                        <?php
                        $stmt_clients = $dbh->prepare("SELECT * FROM `clients` ORDER BY `first_name`");
                        $stmt_clients->execute();

                        while ($client_row = $stmt_clients->fetch(PDO::FETCH_ASSOC)) {
                            echo '<input type="checkbox" name="clients[]" value="' . $client_row['client_id'] . '"> ' . $client_row['first_name'] . '<br>';
                        }
                        ?><br>
                    </div>
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