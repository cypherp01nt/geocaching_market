
<?php
include 'functions.php';
include 'connect_to_database.php';
for ($id = 1; $id < 5; $id++) {
	print_time_until_autorelease($id, $conn);
}
?>
