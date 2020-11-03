<?php

  require("dbConnect.php");
  require("header.html");

$action =NULL;



if (isset($_GET['action'])){	$action = $_GET['action'];	}

if ($action == 'submit'){ 
	DO_PASSWORD($dbh);
}else if ($action == 'new'){ 
	NEW_LOGIN($dbh, 'Please create a new account');	
}else if ($action == 'add_user'){ 
	ADD_USER($dbh);	
}else if ($action == 'forgot'){ 
	FORGOT_USER($dbh);
}else if ($action == 'forgot_data'){
	FORGOT_DATA($dbh);
}else {	
	DO_LOGIN($dbh,'Please Login');
}
function DO_PASSWORD($dbh){	
	
	$username = $_POST['username'];	
	$password = $_POST['password'];

	$sql ="SELECT UserID, password, blocked FROM Security WHERE ";
	$sql .= " username = :username";
	$sth = $dbh->prepare($sql);

	$sth->bindParam(':username', $username);
	$test_array['username'] = $username;
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);

	$good_password =0;
	$user_id =NULL;
	$hash_password =NULL;
	foreach($result as $row){
		$user_id = $row['UserID'];
		$hash_password = $row['password'];
		$blocked = $row['blocked'];
	}
	
	if (password_verify($password, $hash_password)){
		$good_password = 1;
	}else{
		echo "<h3> password not valid</h3>";
	}
	
	if ($good_password)
	{ 
	//	if($blocked=0)
	//	{
			if (isset($_SESSION['user_id']))
			{
	//			echo "<h3> i want to DESTROY here";
				session_destroy();
				session_start();
			}else{
				session_start();
			}
			if($blocked == 1){
			//	echo'test';
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=youreblocked.php">';
			}
			if($blocked == 0){
				$_SESSION['user_id'] =$user_id;
				
				$sql ="SELECT logged_in FROM Security WHERE ";
				$sql .= " UserID = :id";
				$sth = $dbh->prepare($sql);
				$sth->bindParam(':id', $user_id);
				$sth->execute();
				$result = $sth->fetchAll(PDO::FETCH_ASSOC);
				foreach($result as $row){
					$logged_in = $row['logged_in'];
				}
				$logged_in++;

				$sql = "UPDATE Security SET logged_in = $logged_in WHERE UserID=$user_id";
				$res = $dbh->query($sql);
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=main.php">';
			}
		
			
	} else{
		DO_LOGIN($dbh, 'Invalid Login, please try again');
	}
}	
function DO_LOGIN($dbh,$message){ 
	//goal: center the login info, make it look much better.
	//do something that will put the table im making in the center of the page.
	//msg will span
	echo"
	<table class='loginForm '>
		<tr><th colspan='10' class='center'>"+$message+"</th></tr>
			<form action ='?action=submit' method='post'>
		<tr>
			<th class='center'>*</th>
			<th colspan='4'>Username</th>
			<th colspan='4'><input type='text' name='username'/></th>
			<th class='center'>*</th>
		</tr>
		<tr>
			<th class='center'>*</th>
			<th colspan='4'>Password</th>
			<th colspan='4'><input type='password' name='password' /></th>
			<th class='center'>*</th>
		</tr>
		<tr>
			<td class='center'>*</td>
			<td colspan='8'><input type ='submit' value ='Submit' /></td>
			<td class='center'>*</td>
		</tr>
	</table>
	";
	echo "<h3>$message</h3>";
	$bgcolor ='yellow';	
	echo "<table border =0>";
	echo "<tr>
	<th bgcolor =$bgcolor>Username</th>
	<th bgcolor =$bgcolor>Password</th>
	</tr>";
	echo '<tr>';
	// echo "<form action ='?action=submit' method='post'>";
	// echo "<td><input type='text' name='username'/></td>";
	// echo "<td><input type='password' name='password' /></td>";	
	// echo "<td><input type ='submit' value ='Submit' /></td>";
	// echo "</form>";
	echo "</tr><tr>";

	echo "<form action ='?action=new' method='post'>";
	echo "<td><input type ='submit' value ='Setup New Account' /></td>";
	echo "</form>";
	echo "</tr><tr>";
	echo "<form action ='?action=forgot' method='post'>";
	echo "<td><input type ='submit' value ='Forgot Password' /></td>";
	echo "</form>";
	echo "</table>";
	echo "<strong>QuietMessenger</strong>";

}
function ADD_USER($dbh)
{	
	
	$username = $_POST['username'];
	$first_name = $_POST['first_name'];	
	$last_name = $_POST['last_name'];	
	$email = $_POST['email'];		
	$password = $_POST['new_password'];
	$password2 = $_POST['new_password2'];

	$sql ="SELECT COUNT(*) AS used FROM Security WHERE ";
	$sql .= " UserID = :username";
	$sth = $dbh->prepare($sql);
	
	$sth->bindParam(':username', $username);
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
	
	$test_array['UserID'] = $username;
	//echo showQuery($sql,$test_array);
	$used =0;
	
	foreach($result as $row){
		$used = $row['used'];	
	}
	if ($used){
		$message ='Username already in use, try a different username';
		NEW_LOGIN($dbh, $message);
	}else if ($password != $password2){
		$message ='Passwords do not match, try again';
		NEW_LOGIN($dbh, $message);
	}else if (strlen($password) < 6 ){
		$message ='Password is too short, passwords need to be at least 6 characters';
		NEW_LOGIN($dbh, $message);	
	}else if((preg_match('/[A-Z]/', $password)) == false){
		$message = 'Password does not contain an uppercase. Please include an uppercase letter';
		NEW_LOGIN($dbh, $message);
	}else if((preg_match('/[A-Z]/', $password)) == false)
	{
		$message = 'Password does not contain a lowercase. Please include a lowercase letter';
		NEW_LOGIN($dbh, $message);
	}else 
	{

		$salted_password = password_hash($password, PASSWORD_DEFAULT);

		$insert_sql ="INSERT INTO Security SET ";
		$insert_sql .= " username = :username";
		$insert_sql .= ", first_name = :first_name";
		$insert_sql .= ", last_name = :last_name";
		$insert_sql .= ", email = :email";
		$insert_sql .= ", password = :salted_password";
		
		$sth = $dbh->prepare($insert_sql);

		$test_array['username'] = $username;
		$test_array['first_name'] = $first_name;
		$test_array['last_name'] = $last_name;
		$test_array['email'] = $email;
		$test_array['salted_password'] = $salted_password;
		
		//echo showQuery($insert_sql,$test_array);
		
		$sth->bindParam(':username', $username);
		$sth->bindParam(':first_name', $first_name);
		$sth->bindParam(':last_name', $last_name);
		$sth->bindParam(':email', $email);
		$sth->bindParam(':salted_password', $salted_password);
		
		$sth->execute();
		

		$user_id = $dbh->lastInsertId();

		if ($user_id > 0)
		{

			session_start();
			$_SESSION['user_id'] =$user_id;
	
			echo "Login Created and user logged in<p>";
			echo "<a href=main.php>Click here to continue</a><p>";
	
		} else {
			$msg = 'Error adding user';
			NEW_LOGIN($dbh,$msg);
		}
	}
}

function FORGOT_USER($dbh)
{

	
	$bgcolor ='yellow';	
	echo "<table border =0>";
	echo '<tr><th colspan=2>Enter information to reset password</th></tr>';
	echo "<tr>
	<th bgcolor =$bgcolor>Username</th>
	<th bgcolor =$bgcolor>Email</th>
	</tr><tr>";
	
	echo "<form action ='?action=forgot_data' method='post'>";
	echo "<td><input type='text' name='forgot_username' /></td>";
	echo "<td><input type='test' name='forgot_email' /></td>";	
	echo "<td><input type ='submit' value ='Submit' /></td>";
	echo "</form>";
	echo "</tr><tr>";

}
function FORGOT_DATA($dbh)
{
	
	$forgot_username = $_POST['forgot_username'];	
	$forgot_email = $_POST['forgot_email'];
	$user_id =NULL;
	
	$sql ="SELECT UserID FROM Security WHERE ";
	$sql .= " username = :forgot_username";
	$sql .= " AND email = :forgot_email";
	
	$sth = $dbh->prepare($sql);
	
	$sth->bindParam(':forgot_username', $forgot_username);
	$sth->bindParam(':forgot_email', $forgot_email);
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
	foreach($result as $row)
	{
	
		$user_id = $row['UserID'];
		if (ISSET($user_id))
		{
			$key = rand();
			$sql_key = "UPDATE Security SET forgot_code = '".$key ."' WHERE UserID = '".$user_id ."'";
			$result1 = $dbh->query($sql_key);	
			echo "<a href='reset.php?key=$key'>Click here to reset password</a>";
			//creating cookie to store user id, will be destroyed
			//when correct forgot_code is entered.
			$name = 'uid';
			setcookie($name, $user_id);
		}else{
			$msg ="Not found in system";
			DO_LOGIN($dbh,$msg);
		}
	}
}	
function NEW_LOGIN($dbh, $message){	
	
	echo "$message";
	$bgcolor ='yellow';	
	echo "<table border =0>";
	echo "<form action ='?action=add_user' method='post'>";
	echo "<tr><th bgcolor =$bgcolor>Username</th>";
	echo "<td><input type='text' name='username' /></td></tr>";
	echo "<tr><th bgcolor =$bgcolor>First Name</th>";
	echo "<td><input type='text' name='first_name' /></td></tr>";
	echo "<tr><th bgcolor =$bgcolor>Last Name</th>";
	echo "<td><input type='text' name='last_name' /></td></tr>";
	echo "<tr><th bgcolor =$bgcolor>Email</th>";
	echo "<td><input type='text' name='email' /></td></tr>";
	echo "<th bgcolor =$bgcolor>Password</th>";
	echo "<td><input type='password' name='new_password' /></td></tr>";	
	echo "<th bgcolor =$bgcolor>Reenter Password</th>";
	echo "<td><input type='password' name='new_password2' /></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><input type ='submit' value ='Add User' /></td>";
	echo "</form>";
} 

function showQuery($query, $params){
  $keys = array();
  $values = array();

  # build a regular expression for each parameter
	foreach ($params as $key => $value) {
		if (is_string($key)) {
      		$keys[] = '/:' . $key . '/';
    	} else {
			$keys[] = '/[?]/';
		}
		if (is_numeric($value)) {
			$values[] = intval($value);
		} else {
			$values[] = '"' . $value . '"';
		}
  }
	$query = preg_replace($keys, $values, $query, 1);
  $show_query = "<h3>".$query."</h3>";
	return $show_query;
}
?>