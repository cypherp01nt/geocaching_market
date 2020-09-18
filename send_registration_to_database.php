<?php
session_start();
?>
<html>
<body>

<?php
include_once 'connect_to_database.php';
include_once 'functions.php';
require 'securimage/securimage.php';
$securimage = new Securimage();
$name = $_POST["name"];
$password = $_POST["password"];
$pgp_pub_key = $_POST["pgp_pub_key"];
$users = sql_select_users_names($conn);
$is_already_registred = in_array_mysqli_fetch_all("$name", $users);
if ($securimage->check($_POST['captcha_code']) == true && !$is_already_registred) {
	$sql = "INSERT into users (name, password, pgp_pub_key)
	VALUES ('$name', '$password', '$pgp_pub_key')";
	if (mysqli_query($conn, $sql)) {
		$_SESSION["user"] = $name;
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	require 'index.php';
} else {
	if ($is_already_registred) {
		echo "Benutzername ist schon vergeben";
	} else { 
		echo "Captcha falsch eingegeben.<br>";
		if (5 == rand (0,15)) {
			echo "<br>Sorry aber Ihr wollt auch keine Bullen hier haben, die alles vollspammen, weil se sich nicht anders zu helfen wissen";
		}
	}
	require 'post_register.php';
}


?>
</body>
</html>	
