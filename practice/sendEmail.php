<?php 
	if (mail('rajmandir.sidhu1996@gmail.com', 'Hack_Attack--> Security Compromised!', 'Your Accounts security has been compromised!'."\n".'Kindly change your password, if you receive another such e-mail, deactivate your account permanently.',"From:".'security@gmail.com')){
		echo "E-mail sent";
	}
	else{
		echo "Error sending e-mail";
	}
?>