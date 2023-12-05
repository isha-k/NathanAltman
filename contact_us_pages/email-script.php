<?php
global $dbh;
require_once("../connection.php");

if (isset($_POST['sendMailBtn'])) {
    $fromEmail = $_POST['email'];
    $name = $_POST['name'];
    $toEmail = $_POST['email'];
    $subjectName = $_POST['phone_number'];
    $message = $_POST['message'];

    $query = "INSERT INTO `contact_us` (`name`, `email`, `phone_number`, `message`) VALUES 
          (:name, :toEmail, :phone_number, :message)";
    $stmt = $dbh->prepare($query);
    $stmt->execute([
        'name' => $name,
        'toEmail' => $toEmail,
        'phone_number' => $subjectName,
        'message' => $message
    ]);


    $to = $toEmail;
    $subject = $subjectName;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: '.$fromEmail.'<'.$fromEmail.'>' . "\r\n".'Reply-To: '.$fromEmail."\r\n" . 'X-Mailer: PHP/' . phpversion();
    $message = '<!doctype html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport"
					  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
				<meta http-equiv="X-UA-Compatible" content="ie=edge">
				<title>Email</title>
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
			</head>
			<body>
			<span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">'.$message.'</span>
				<div class="container">
                 '.$message.'<br/>
                    Regards<br/>
                  '.$fromEmail.'
				</div>
			</body>
			</html>';
    $result = @mail($to, $subject, $message, $headers);

    echo '<script>alert("Email sent successfully !")</script>';
    header("location: ../index.php");
}