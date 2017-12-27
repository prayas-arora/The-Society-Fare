<!DOCTYPE html>
<html>
<head>
	<title>Contact Form</title>
</head>
<body>

	<form action="send_email.php" method="POST"><br><br>
		<input type="text" name="name" placeholder="Your Name"><br><br>
		<input type="tel" name="phone" placeholder="Phone"><br><br>
		<input type="email" name="email" placeholder="Your Email Address"><br><br>

		<textarea name="message" placeholder="Your Message"></textarea><br><br>
		<input type="submit" value="Send Email">
		
	</form>

</body>
</html>