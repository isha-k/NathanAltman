<?php
session_start();
global $dbh;
require_once("../connection.php");

// Test if form id has been provided. If not, take user back to the listing page
if (empty($_GET['form_id'])) {
    header('Location: contact_forms.php');
}

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        // Check if a client_id already exists for this form_id
        $checkQuery = "SELECT * FROM `client_contact_us` WHERE `form_id` = :form_id";
        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->execute(['form_id' => $_GET['form_id']]);

        if ($checkStmt->rowCount() > 0) {
            // If a record exists, update the existing client_id
            $query = "UPDATE `client_contact_us` SET `client_id` = :client_id WHERE `form_id` = :form_id";
        } else {
            // If no record exists, insert a new client_id
            $query = "INSERT INTO `client_contact_us` (`client_id`, `form_id`) VALUES (:client_id, :form_id)";
        }


        $stmt = $dbh->prepare($query);

        // Execute the query
        $stmt->execute(['client_id' => $_POST['client_id'],
            'form_id' => $_GET['form_id']
        ]);

        // And send the user back to where we were
        header('Location: contact_forms.php');
    } catch (PDOException $e) {
        displayPDOError($e);
    }
else:
// Otherwise read the record from database with ID and prefill the form
$stmt = $dbh->prepare("SELECT * FROM `contact_us` WHERE `form_id` = :form_id");
$stmt->execute(['form_id' => $_GET['form_id']]);

if ($stmt->rowCount() == 1 && $row = $stmt->fetchObject()): ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form #<?= $row->form_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<?php
//Include navbar
require("navbar_contact.php");
?>

<div class="text-center mt-3 mb-3">
    <div class="fs-3">
        <p>Form ID: <?= $row->form_id ?></p>
    </div>
</div>

<div class="mt-3 mb-3 ms-5">
    <a class="btn btn-primary" href="contact_forms.php" role="button">Back</a>
</div>

<form method="post">
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
            <?php
            $queryForms = "SELECT * FROM `contact_us` WHERE `form_id` = :form_id";

            $stmt = $dbh->prepare($queryForms);
            $stmt->execute([
                'form_id' => $_GET["form_id"]
            ]);
            while ($row = $stmt->fetchObject()): ?>
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
                <?php
                $queryClients = "SELECT C.* FROM `clients` C
                    JOIN `client_contact_us` CO ON C.client_id = CO.client_id
                    WHERE CO.form_id = :form_id";

                $stmtClients = $dbh->prepare($queryClients);
                $stmtClients->execute([
                    'form_id' => $_GET["form_id"]
                ]);
                while ($clientRow = $stmtClients->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <th scope="row"><?= $clientRow['client_id'] ?></th>
                        <td><?= $clientRow['first_name'] ?></td>
                        <td><?= $clientRow['surname'] ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <div>
                <label for="client_id">Client:</label><br>
                <select id="client_id" name="client_id">
                    <option value="">==No Client Selected==</option>
                    <?php
                    $stmtClients1 = $dbh->prepare("SELECT * FROM `clients` ORDER BY `first_name`");
                    $stmtClients1->execute();

                    while ($clientRow = $stmtClients1->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($clientRow['client_id'] == $row->client_id) ? 'selected' : '';
                        echo '<option value="' . $clientRow['client_id'] . '" ' . $selected . '>' . $clientRow['first_name'] . " " . $clientRow['surname'] . '</option>';
                    }
                    ?>
                </select><br><br>
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
        <?php else:
            // If the record is not found (rowcount is not 1), send user back to listing page (invalid ID)
            header('Location: contact_forms.php');
        endif;
        endif; ?>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
