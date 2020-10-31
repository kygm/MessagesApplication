<?php
  require('./dbconnect.php');
  require('./header.html');
  session_start();

  if (isset($_SESSION['user_id'])){
		
		DO_MAIN($dbh);
  }
  else
  {
		// not a valid session, make them login in.
		header("location:security-2020.php");
  }
  
function DO_MAIN($dbh)
{

  echo "
  <div class='scrolling-window-bit bg-dark'>

  </div>
  <form action='chat.php'><button type='submit'>GOTO Chat</button></form>
  ";
  

  if(!empty($_POST['nameSearch']))
  {
    $name = $_POST['nameSearch'];
    //echo "name: " . $name;
    //create f(x) to handle query
    //using name
    NAME_LOOKUP($name, $dbh);
  }
  if(!empty($_POST['usernameSearch']))
  {
    $username = $_POST['usernameSearch'];
    //echo "username: " . $username;
    //create f(x) to handle query 
    //using username
    USERNAME_LOOKUP($username, $dbh);
  }
  if(empty($_POST))
  {
    header('chat.php');
  }


}

function NAME_LOOKUP($name, $dbh)
{
  //here we will use the name to search for
  //a user with a matching name.


  $sql ="SELECT UserID, first_name, last_name FROM security WHERE ";
  $sql .= " CONCAT(first_name, ' ', last_name) = :name";
  $sth = $dbh->prepare($sql);

  $sth->bindParam(':name', $name);
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  
  if(empty($result))
  {
    echo $name . " was not found. Check spelling.";
  }

  foreach ($result as $row)
  {
    $uid = $row['UserID'];
    echo $uid;
  }
  
}
function USERNAME_LOOKUP($username, $dbh)
{
  //here we will use the username to search
  //for a user by using the username.
  $sql ="SELECT UserID, first_name, last_name FROM security WHERE ";
  $sql .= " username = :username";
  $sth = $dbh->prepare($sql);

  $sth->bindParam(':username', $username);
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  
  if(empty($result))
  {
    echo $name . " was not found. Check spelling.";
  }

  foreach ($result as $row)
  {
    $name = $row['first_name'] . " " . $row['last_name'];
    $uid = $row['UserID'];
    echo 'Username: ' . $username . '<br/>';
    echo 'UserID: ' . $uid .'<br/>' . 'name: ' . $name;
  }
}




?>


