<?php
  require('header.html');
	session_start();
	include("dbConnect.php");
		
	if (isset($_SESSION['user_id'])){
		
		DO_MAIN($dbh);
		
  }
  else
  {
		// not a valid session, make them login in.
		header("location:security-2020.php");
	}

function DO_MAIN($dbh){

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
  
	if($admin == 1)
	{
    
    
    echo "
    <form action='main.php'>
      <button type='submit'>Click here to go back to main</button>
    </form>
    ";
    $sql ="SELECT * FROM security ORDER BY admin";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    
    $num = count($result);
   // echo $num;
    //print_r($result);
    //echo $vid;
    echo "<h3>Work with users</h3>";
    $bgcolor = 'yellow';
    echo "
    <table border=1>
    <tr>
      <th bgcolor =$bgcolor>User ID</th>
      <th bgcolor =$bgcolor>First Name</th>
      <th bgcolor =$bgcolor>Last Name</th>
      <th bgcolor =$bgcolor>Admin</th>
      <th bgcolor =$bgcolor>Email</th>
      <th bgcolor =$bgcolor>Blocked</th>
      <th bgcolor =$bgcolor>Logged In</th>
      <th colspan = '3' bgcolor =$bgcolor>Options</th>

    </tr>";  
    
    foreach($result as $row)
    {
      
      $uid = $row['UserID'];
      $fname = $row['first_name'];
      $lname = $row['last_name'];
      $admin = $row['admin'];
      $email = $row['email'];
      $blocked = $row['blocked'];
      $logged_in = $row['logged_in'];

      if($admin == 0)
      {
        echo '<tr>';
        echo '<td>' .$uid . '</td>';	//vehicle id
        echo '<td>' .$fname . '</td>';		//make
        echo '<td align ="right">' .$lname .'</td>';						//model
        echo '<td align ="right">';
        if($admin == 0)
        {
          echo'No</td>';
        }
        else
        {
          echo'Yes</td>';
        }
        echo '<td align ="right">' .$email .'</td>';			//vehicle color											//date listed
        echo '<td align ="right">' .$blocked.'</td>';	      //price
        echo '<td align="right">'.$logged_in.'</td>';
        if(!$admin)
        {
          echo '
          <td><form action=blocked.php?id='.$uid.'&act=1 method=post><button type=submit>Block User</button></form></td>
          <td><form action=blocked.php?id='.$uid.'&act=2 method=post><button type=submit>Unblock User</button></form></td>
          <td><form action=admin_reset.php?id='.$uid.' method=post><button type=submit>Reset Password</button></form></td>
          ';
        }
      }
      if($admin)
      {
        echo '<tr style="color:red;">';
        echo '<td>' .$uid . '</td>';	//vehicle id
        echo '<td><strong>' .$fname . '</strong></td>';		//make
        echo '<td align ="right"><strong>' .$lname .'</strong></td>';						//model
        echo '<td align ="right">';
        if($admin == 0)
        {
          echo'No</td>';
        }
        else
        {
          echo'Yes</td>';
        }
        echo '<td align ="right">' .$email .'</td>';			//vehicle color											//date listed
        echo '<td align ="right">' .$blocked.'</td>';	      //price
        echo '<td align="right">'.$logged_in.'</td>';
        if($admin == 0)
        {
          echo '
          <td><form action=blocked.php?id='.$uid.'&act=1 method=post><button type=submit>Block User</button></form></td>
          <td><form action=blocked.php?id='.$uid.'&act=2 method=post><button type=submit>Unblock User</button></form></td>
          ';
        }
      }
    }
    
    echo '</tr></table>';
    
  }

  
  //just in case
	if($admin == 0)
	{
    
    header('security-2020.php');

	}



}

function GET_USER_INFO($dbh,$user_id){
	$field_data = array();
		
	$sql ="SELECT * FROM security WHERE UserID = :user_id";
	$sth = $dbh->prepare($sql);
	
	$sth->bindParam(':user_id', $user_id);
	$sth->execute();
	$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		
//echo "sql->$sql<p>";
	foreach($result as $row){	
	// while($get_info = $result->fetch_array(MYSQLI_ASSOC)){
		foreach ($row as $key => $val){
			$field_data[$key]=$val;
		}       
	}
	return $field_data;
}
		
?>