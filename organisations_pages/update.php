<?php
global $dbh;
require_once("../authentication.php");

// Test if organisation id has been provided. If not, take user back to the listing page
if (empty($_GET['org_id'])) {
    header('Location: index.php');
}

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        // Update the record based on the form received
        $query = "UPDATE `organisations` SET 
              `business_name` = :business_name, 
              `current_website` = :current_website,
              `business_description` = :business_description,
              `technology_currently_used` = :technology_currently_used,
              `industry_operated_in` = :industry_operated_in,
              `services_offered` = :services_offered,
              `field` = :field
        WHERE `org_id` = :org_id";
        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute(['business_name' => $_POST['business_name'],
            'current_website' => $_POST['current_website'],
            'business_description' => $_POST['business_description'],
            'technology_currently_used' => $_POST['technology_currently_used'],
            'industry_operated_in' => $_POST['industry_operated_in'],
            'services_offered' => $_POST['services_offered'],
            'field' => $_POST['field'],
            'org_id' => $_GET['org_id']
        ]);

        // Update associated clients
        $org_id = $_GET['org_id'];
        $selected_clients = isset($_POST['clients']) ? $_POST['clients'] : [];

        // Delete existing associations for this organization
        $delete_query = "DELETE FROM `clients_organisations` WHERE `org_id` = :org_id";
        $delete_stmt = $dbh->prepare($delete_query);
        $delete_stmt->execute(['org_id' => $org_id]);

        // Insert new associations
        foreach ($selected_clients as $client_id) {
            $insert_query = "INSERT INTO `clients_organisations` (`org_id`, `client_id`) VALUES (:org_id, :client_id)";
            $insert_stmt = $dbh->prepare($insert_query);
            $insert_stmt->execute(['org_id' => $org_id, 'client_id' => $client_id]);
        }

        // And send the user back to where we were
        header('Location: index.php');

    } catch (PDOException $e) {
        displayPDOError($e);
    }
else:
    // Otherwise read the record from database with ID and prefill the form
    $stmt = $dbh->prepare("SELECT * FROM `organisations` WHERE `org_id` = :org_id");
    $stmt->execute(['org_id' => $_GET['org_id']]);

    if ($stmt->rowCount() == 1 && $row = $stmt->fetchObject()): ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update organisation #<?= $row->org_id ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        </head>
        <body>

        <?php
        //Include navbar
        require("navbar_organisations.html");
        ?>

        <div class="text-center mt-3 mb-3">
            <div class="fs-3">
                <p>Organisation ID: <?= $row->org_id?></p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="bg-light pt-5 pb-5">
                <div class="ms-5 me-5">
                    <form class="row g-3" method="post">
                        <div class="col-md-6">
                            <label for="business_name" class="form-label">Business name:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="business_name" name="business_name" size="40" value="<?=$row->business_name?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="current_website" class="form-label">Current website:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="current_website" name="current_website" size="40" value="<?=$row->current_website?>" required><br>
                        </div>
                        <div class="form-group">
                            <label for="business_description" class="form-label">Business Description:</label><br>
                            <textarea class="form-control" id="business_description" name="business_description" rows="4" maxlength="500" required><?=$row->business_description?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="technology_currently_used" class="form-label">Technology currently used:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="technology_currently_used" name="technology_currently_used" size="40" value="<?=$row->technology_currently_used?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="industry_operated_in" class="form-label">Industry operated in:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="industry_operated_in" name="industry_operated_in" size="40" value="<?=$row->industry_operated_in?>" required><br>
                        </div>
                        <div class="form-group">
                            <label for="services_offered" class="form-label">Services offered:</label><br>
                            <textarea class="form-control" id="services_offered" name="services_offered" rows="2" maxlength="500" required><?=$row->services_offered?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="field" class="form-label">Field:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="field" name="field" size="40" value="<?=$row->field?>" required><br>
                        </div>
                        <div>
                            <label>Update client(s):</label><br>
                            <?php
                            // Fetch the list of clients associated with the organization
                            $stmt_clients = $dbh->prepare("SELECT * FROM `clients` ORDER BY `first_name`");
                            $stmt_clients->execute();

                            // Fetch the list of associated client IDs for the organization being updated
                            $stmt_associated_clients = $dbh->prepare("SELECT `client_id` FROM `clients_organisations` WHERE `org_id` = :org_id");
                            $stmt_associated_clients->execute(['org_id' => $_GET['org_id']]);
                            $associated_clients = $stmt_associated_clients->fetchAll(PDO::FETCH_COLUMN);

                            while ($client_row = $stmt_clients->fetch(PDO::FETCH_ASSOC)) {
                                $isChecked = in_array($client_row['client_id'], $associated_clients) ? 'checked' : '';
                                echo '<input type="checkbox" name="clients[]" value="' . $client_row['client_id'] . '" ' . $isChecked . '> ' . $client_row['first_name'] . '<br>';
                            }
                            ?><br>
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