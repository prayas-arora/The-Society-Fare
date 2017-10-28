//This method doesn't actually update the div, just changes the way it is shown to the user.The contents of div remain unaltered.
<br>//This is simply including a file using AJAX without refreshing a page.<br>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		function load(div_id,file_name) {
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			}
			else{
				xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			xmlhttp.onreadystatechange = function(){
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById(div_id).innerHTML = xmlhttp.responseText;
				}	
			}
			xmlhttp.open('GET',file_name,true);
			xmlhttp.send();
		}

	</script>
</head>
<body>

	<input type="submit" name="include_a_file" onclick="load('adiv','test.php');">
	<div id="adiv"></div>

</body>
</html>