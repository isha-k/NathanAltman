<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script type="text/javascript"
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <title>Contact Form</title>
</head>
<body>

<?php
//Include navbar
require("navbar_contact.php");
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Contact Us</h5>
                    <form action="email-script.php" method="post" class="form-signin">
                        <div class="form-label-group">
                            <label for="inputName">Name <span style="color: #FF0000">*</span></label>
                            <input type="text" name="name" id="inputName" class="form-control" placeholder="Your name"
                                   required autofocus>
                        </div>
                        <br>
                        <div class="form-label-group">
                            <label for="inputEmail">Email <span style="color: #FF0000">*</span></label>
                            <input type="email" name="email" id="inputEmail" class="form-control"
                                   placeholder="Your email address" required>
                        </div>
                        <br>
                        <div class="form-label-group">
                            <label for="inputPhoneNumber">Phone Number</label>
                            <input type="text" name="phone_number" id="inputPhoneNumber" class="form-control"
                                   placeholder="Your phone number" required>
                        </div>
                        <br>
                        <div class="form-label-group">
                            <label for="inputMessage">Message <span style="color: #FF0000">*</span></label>
                            <textarea id="inputMessage" name="message" class="form-control" placeholder="Your message"
                                      required></textarea>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" name="sendMailBtn"
                                    class="btn btn-lg btn-primary btn-block text-uppercase" onclick="validateAndSubmit()">Send Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
</body>
</html>