
<?php

	require("header.html");
	//AUTHOR: Kevin Gutierrez
	//Date: 10-19-20
	session_start();

	require("dbConnect.php");
	
	//if the user id cookie is filled, 
	//route user to service
	if (isset($_SESSION['user_id']))
	{
		
		DO_MAIN($dbh);
		
	}
	//if not, send user to login page
	else
	{
		header("location:security-2020.php");
	}

function DO_MAIN($dbh)
{
	$user_id = $_SESSION['user_id'];
	$sql ="SELECT admin FROM security WHERE ";
	$sql .= " UserID = :id";
	$sth = $dbh->prepare($sql);

	$sth->bindParam(':id', $user_id);
	$test_array['UserID'] = $user_id;
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);

	foreach($result as $row)
	{
	
		$admin = $row['admin'];

		
	}

	$user_info = GET_USER_INFO($dbh,$user_id);
		
	echo "<h3>Hello ". $user_info['first_name']."</h3>";
	echo "<p>Please select from the following options:</p>";
	//ADMIN VAR IS NOT A BOOLEAN, PHP TREATS 
	//1'S AS TRUES AND 0'S AS FALSES, 
	//HENCE THE IF ADMIN CONDITIONAL
	if($admin)
	{

	echo 
	"
		
		<form method='post' action='admin_users.php'>
			<button type='submit'class='btn-secondary'>Click here to work with users</button>
		</form>
		<form method='post' action='chat.php'>
			<button type='submit'>Click here to chat</button>
		</form>
		
	";
	}
	else
	{
		echo
		"
		<form method='post' action='chat.php'>
			<button type='submit' class='btn-secondary'>Click here to view inventory</button>
		</form>";
	}
	//echo $user_id;


	//echo $admin;


}
function GET_USER_INFO($dbh,$user_id)
{
	$field_data = array();
		
	$sql ="SELECT * FROM security WHERE UserID = :user_id";
	$sth = $dbh->prepare($sql);
	
	$sth->bindParam(':user_id', $user_id);
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
//echo "sql->$sql<p>";
	foreach($result as $row)
	{	
	// while($get_info = $result->fetch_array(MYSQLI_ASSOC)){
		foreach ($row as $key => $val)
		{
			$field_data[$key]=$val;
		}       
	}
	return $field_data;
}
	

echo 
"
</div>
</body>
</html>";
?>