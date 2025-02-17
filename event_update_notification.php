<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader (if you installed PHPMailer via Composer)
require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_docs";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_notification = "SELECT `id`, `organizer`, `email_id`, `eventname`, `ending_date` FROM user WHERE DATE_ADD(ending_date, INTERVAL 15 DAY) = CURDATE() + INTERVAL 2 DAY";
$result_notification = $conn->query($sql_notification);

$mail = new PHPMailer(true);

try {

    



 // Server settings
 $mail->isSMTP();
 $mail->Host = 'smtp.gmail.com';
 $mail->SMTPAuth = true;
 $mail->Username = 'mkceinfocorner@gmail.com'; // Your Gmail email address
 $mail->Password = 'npdllnbipximwvnq'; // Your Gmail password
 $mail->SMTPSecure = 'tls';
 $mail->Port = 587;

 

    if ($result_notification->num_rows > 0) {
        // Loop through the results
        while ($row = $result_notification->fetch_assoc()) {
           
            
           
            //$email = $row['email_id'];
            $eventName = $row['eventname'];
            $deadline = $row['ending_date'];
            $organizer = $row['organizer'];
            $email = "madhumitha.vnc@gmail.com";



           
    // Sender and recipient
    $mail->setFrom('mkceinfocorner@gmail.com', 'MKCE_INFO_CORNER');         // SMTP port (use 465 for SSL, 587 for TLS)
    $mail->addAddress( $email);   // Add recipient's email
    
         
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Reminder: Upcoming Deadline for Event  '.$eventName;
    $mail->Body    = 'Dear '.$organizer.',<br><br>This is a reminder that the event '.$eventName.' deadline '. $deadline.' is approaching.<br><br>Best Regards,<br>Event Management Team';
    $mail->AltBody = 'This is a plain-text version of the email content';
   
    $mail->send();
    //echo 'Message has been sent';
    }

} }
catch (Exception $e) {

    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
     



   

    