<?php
global $dbh;
require_once("../authentication.php");


// Test if exhibit id has been provided. If not, take user back to the listing page
if (empty($_GET['client_id'])) {
    header('Location: index.php');
}

// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        $query = "UPDATE `clients` SET 
              `client_photo_path` = :client_photo_path, 
              `first_name` = :first_name,
              `surname` = :surname,
              `email` = :email,
              `address` = :address,
              `phone_number` = :phone_number,
              `suburb` = :suburb,
              `recruited_from_channel` = :recruited_from_channel
        WHERE `client_id` = :client_id";
        $stmt = $dbh->prepare($query);

        // Use the existing value of client_photo_path if it's empty in the POST data
        $clientPhotoPath = !empty($_POST['client_photo_path']) ? $_POST['client_photo_path'] : $_POST['existing_client_photo_path'];

        // Execute the query
        $stmt->execute([
            'client_photo_path' => $clientPhotoPath,
            'first_name' => $_POST['first_name'],
            'surname' => $_POST['surname'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'suburb' => $_POST['suburb'],
            'recruited_from_channel' => $_POST['recruited_from_channel'],
            'client_id' => $_GET['client_id']
        ]);

        // And send the user back to where we were
        header('Location: index.php');

    } catch (PDOException $e) {
        displayPDOError($e);
    }
else:
    // Otherwise read the record from database with ID and prefill the form
    $stmt = $dbh->prepare("SELECT * FROM `clients` WHERE `client_id` = :client_id");
    $stmt->execute(['client_id' => $_GET['client_id']]);

    if ($stmt->rowCount() == 1 && $row = $stmt->fetchObject()): ?>
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update client #<?= $row->client_id ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>

        <?php
        //Include navbar
        require("navbar_clients.html");
        ?>

        <div class="text-center mt-3 mb-3">
            <div class="fs-3">
                <p>Client ID: <?= $row->client_id?></p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="bg-light pt-5 pb-5">
                <div class="ms-5 me-5">
                    <form class="row g-3" method="post"><label for="client"></label><br>
                        <div class="col-md-6">
                            <label for="client_photo_path" class="form-label">Client photo:</label><br>
                            <input type="file" class="form-control" id="client_photo_path" name="client_photo_path">
                            <?php
                            if (!empty($row->client_photo_path)) {
                                $existingFilePath = APP_FOLDER_PATH . '/client_profiles/' . $row->client_photo_path;
                                $existingFileUrl = APP_URL_PATH . '/client_profiles/' . $row->client_photo_path;
                            }
                            ?>
                            <br>
                            <input type="hidden" name="existing_client_photo_path" value="<?= $row->client_photo_path ?>">
                        </div>
                        <div class="col-md-6">
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First name:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="first_name" name="first_name" size="40" value="<?=$row->first_name?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="surname" class="form-label">Surname:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="surname" name="surname" size="40" value="<?=$row->surname?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email:</label><br>
                            <input type="email" class="form-control" id="email" name="email" value="<?=$row->email?>"required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="address" name="address" size="40" value="<?=$row->address?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone number:</label><br>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?=$row->phone_number?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="suburb" class="form-label">Suburb:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="suburb" name="suburb" size="40" value="<?=$row->suburb?>" required><br>
                        </div>
                        <div class="col-md-6">
                            <label for="recruited_from_channel" class="form-label">Recruited from:</label><br>
                            <input type="text" class="form-control" maxlength="255" id="recruited_from_channel" name="recruited_from_channel" size="40" value="<?=$row->recruited_from_channel?>" required><br>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" onclick="validateAndSubmit()">Update</button>
                            <a class="btn btn-primary" href="index.php" role="button">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function validateAndSubmit() {
                var phoneNumber = document.getElementById("phone_number").value;
                // Regular expression to match the Australian phone number format
                var regex = /^(0\d{1}|\(0\d{1}\))?\s?\d{4}\s?\d{4}$/;

                if (regex.test(phoneNumber)) {
                    // Valid phone number, submit the form
                    document.querySelector('form').submit();
                } else {
                    // Invalid phone number, display an error message
                    alert("Please enter a valid Australian phone number");
                }
            }
        </script>
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