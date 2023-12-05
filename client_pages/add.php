<?php
global $dbh;
require_once("../authentication.php");

// Allowed file types
$allowed_types = [
    'image/jpeg',
    'image/png'
];


// If the user has completed the form:
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    try {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            if (in_array($_FILES['file']['type'], $allowed_types)) {
                // Define the target directory where the file will be saved
                $targetDirectory = APP_FOLDER_PATH . '/client_profiles/';

                // Define the full path to the target file
                $targetFilePath = $targetDirectory . $_FILES['file']['name'];

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                    // Add a new client record to the database
                    $query = "INSERT INTO `clients` (`client_photo_path`, `first_name`, `surname`, `email`, `address`, `phone_number`, `suburb`,
                           `recruited_from_channel`) VALUES (:client_photo_path, :first_name, :surname, :email, :address, :phone_number, :suburb, 
                                                     :recruited_from_channel)";
                    $stmt = $dbh->prepare($query);

                    // Execute the query
                    $stmt->execute([
                        'client_photo_path' => $_FILES['file']['name'],
                        'first_name' => $_POST['first_name'],
                        'surname' => $_POST['surname'],
                        'email' => $_POST['email'],
                        'address' => $_POST['address'],
                        'phone_number' => $_POST['phone_number'],
                        'suburb' => $_POST['suburb'],
                        'recruited_from_channel' => $_POST['recruited_from_channel'],
                    ]);

                    // Redirect the user back to where we were
                    header('Location: index.php');
                } else {
                    echo "Error uploading the file.";
                }
            } else {
                echo "<script>alert('File type not allowed. Please provide a valid file type.');</script>";
            }
        } else {
            echo "<script>alert('No file uploaded');</script>";
        }
    } catch (PDOException $e) {
        displayPDOError($e);
    }
else: ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Client</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    </head>
    <body>

    <?php
    //Include navbar
    require("navbar_clients.html");
    ?>

    <div class="text-center fs-3 mt-3 mb-3">
        <p>Add Client</p>
    </div>

    <div class="container-fluid">
        <div class="bg-light pt-5 pb-5">
            <div class="ms-5 me-5">
                <form class="row g-3" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="client_photo_path" class="form-label">File:</label><br>
                        <input type="file" class="form-control" id="client_photo_path" name="file" required></input><br>
                    </div>
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First name:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="first_name" name="first_name"
                               size="40" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="surname" class="form-label">Surname:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="surname" name="surname" size="40"
                               required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label><br>
                        <input type="email" class="form-control" id="email" name="email" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="address" name="address" size="40"
                               required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">Phone number:</label><br>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="suburb" class="form-label">Suburb:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="suburb" name="suburb" size="40"
                               required><br>
                    </div>
                    <div class="col-md-6">
                        <label for="recruited_from_channel" class="form-label">Recruited from:</label><br>
                        <input type="text" class="form-control" maxlength="255" id="recruited_from_channel"
                               name="recruited_from_channel" size="40" required><br>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" onclick="validateAndSubmit()">Add</button>
                        <a class="btn btn-primary" href="index.php" role="button">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Allowed file types
        const allowedFiletypes = [
            'image/jpeg',
            'image/png'
        ];
        document.getElementById('client_photo_path').onchange = (event) => {
            // Check if JS is allowed to do file manipulation
            if (typeof FileReader !== "undefined") {
                // Check if a file has been selected
                if (event.target.files.length === 1) {
                    // Get file type
                    let fileType = event.target.files[0].type;

                    if (allowedFiletypes.indexOf(fileType) === -1) {
                        // Display an alert for incorrect file type
                        alert("File type not allowed. Please provide a valid file type.");
                        event.target.value = ""; // Clear the file input
                    }
                } else {
                    alert("A file must be provided");
                }
            }
        }
    </script>


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
<?php endif; ?>