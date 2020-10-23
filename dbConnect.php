
<?php
//this is the PDO db connection script (for git)
/*
if (!defined('PDO::ATTR_DRIVER_NAME')) {
	echo 'PDO is unavailable<br/>';
	}
	elseif (defined('PDO::ATTR_DRIVER_NAME')) {
	echo 'PDO is available<br/>';
	}
*/

 try {
		 $dsn = 'mysql:host=localhost;dbname=message_application';
		 $username = 'root';
		 $password = '';

		 $dbh = new PDO($dsn, $username, $password);
		 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 } catch(PDOException $e) {
		 echo "Could not connect to DB; error: " . $e->getMessage();
	 }
?>