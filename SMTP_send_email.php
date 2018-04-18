<?php
/**
 * This example shows how to send via Google's Gmail servers using XOAUTH2 authentication.
 */

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require 'connect.inc.php';
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;

// Alias the League Google OAuth2 provider class
use League\OAuth2\Client\Provider\Google;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

//Load dependencies from composer
//If this causes an error, run 'composer install'
//Load composer's autoloader
require 'vendor/phpmailer/phpmailer/vendor/autoload.php';

$name = $_POST['contact_name'];
$id = $_POST['contact_coordinator_id'];
$SenderEmail = $_POST['sender_email'];
$message = $_POST['contact_message'];
global $coordinator_name;   
global $to_email;

if($id == 'Select'){
    echo '
      <script>
        alert("Please select a society coordinator to whom you want to contact.");
        setTimeout(`window.location="index.php"`,1);
      </script>
    ';
 }

    $query = "select `firstname`,`lastname`, `email_address` from `users` where id = $id";
    
    if($query_run = mysqli_query($conn,$query)){   
        while ($fetched_row = mysqli_fetch_assoc($query_run)) {
            $coordinator_name = "".$fetched_row['firstname']." ".$fetched_row['lastname']."";
            $to_email = $fetched_row['email_address'];
        }
    }else{
        header('Location: index.php');
        exit;
    } 


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    //Tell PHPMailer to use SMTP
	$mail->isSMTP();

	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;

	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';

	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;

	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';

	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;

	//Set AuthType to use XOAUTH2
	$mail->AuthType = 'XOAUTH2';
	
	$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

	//Fill in authentication details here
	//Either the gmail account owner, or the user that gave consent
	$email = 'societyfair@thapar.edu';
	$clientId = '676765708477-a8b9eqcob8diih56kjaec7tti8dgt1sa.apps.googleusercontent.com';
	$clientSecret = 'FKNtxpoPwV_MmaFC48Hpug4T';

	//Obtained by configuring and running get_oauth_token.php
	//after setting up an app in Google Developer Console.
	$refreshToken = '1/6TSK4FKuJc13fyFR18dRQNw_mnyk19KfTyDIT_wtZ5M';

	//Create a new OAuth2 provider instance
	$provider = new Google(
		[
			'clientId' => $clientId,
			'clientSecret' => $clientSecret,
		]
	);

	//Pass the OAuth provider instance to PHPMailer
	$mail->setOAuth(
		new OAuth(
			[
				'provider' => $provider,
				'clientId' => $clientId,
				'clientSecret' => $clientSecret,
				'refreshToken' => $refreshToken,
				'userName' => $email,
			]
		)
	);

    //Sender
    $mail->setFrom('societyfair@thapar.edu', 'Bot');
    
    //Recipients
    $mail->addAddress($to_email, $name);     // Add a recipient

    //body
    $body = "<p><strong>Hello $coordinator_name</strong>, <br>you have recieved an enquiry from ".$name. ". The message is: <i>".$message.". </i><br>You can contact ".$name." on ".$SenderEmail.".</p>";

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = '"The Society Fare" enquiry from ' . $name;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);
	

    echo '
    <script>
        showLoader();
    </script>
    ';

    if($mail->send()){
        echo '
      <script>
        alert("Message sent via E-mail");
        setTimeout(`window.location="index.php"`,1);
      </script>
    ';
    }
    
} catch (Exception $e) {
    echo '
            <script>
              alert("There was error in sending your message. Please try again later.\n Mailer Error: "' .$mail->ErrorInfo. ');
              setTimeout(`window.location="index.php"`,1);
            </script>
          ';
}


?>