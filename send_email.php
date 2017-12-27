<?php
require 'connect.inc.php';
$name = $_POST['contact_name'];
$id = $_POST['contact_coordinator_id'];
$SenderEmail = $_POST['sender_email'];
$message = $_POST['contact_message'];
global $coordinator_name;   
global $email;

if($id == 'Select'){
    echo '
      <script>
        alert("Please select a society coordinator to whom you want to contact.");
        setTimeout(`window.location="homePage.php"`,1);
      </script>
    ';
 }

    $query = "select `firstname`,`lastname`, `email_address` from `users` where id = $id";
    
    if($query_run = mysqli_query($conn,$query)){   
        while ($fetched_row = mysqli_fetch_assoc($query_run)) {
            $coordinator_name = "".$fetched_row['firstname']." ".$fetched_row['lastname']."";
            $email = $fetched_row['email_address'];
        }
    }else{
        header('Location: homePage.php');
        exit;
    } 

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
   /* $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

*/
    //Sender
    $mail->setFrom('arora.prayas@gmail.com', 'Prayas Arora');
    
    //Recipients
    $mail->addAddress($email, $name);     // Add a recipient

    //body
    $body = "<p><strong>Hello $coordinator_name</strong>, <br>you have recieved an enquiry from ".$name. ". The message is: <i>".$message.". </i><br>You can contact ".$name." on ".$SenderEmail.".</p>";

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = '"The Society Fare" enquiry from ' . $name;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
    echo '
      <script>
        alert("Message sent via E-mail");
        setTimeout(`window.location="homePage.php"`,1);
      </script>
    ';
} catch (Exception $e) {
    echo '
            <script>
              alert("There was error in sending your message. Please try again later.\n Mailer Error: "' .$mail->ErrorInfo. ');
              setTimeout(`window.location="homePage.php"`,1);
            </script>
          ';
}


?>