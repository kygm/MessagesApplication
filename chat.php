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
  //msg section
  echo "
  <div class='scrolling-window-bit bg-dark'>

  </div>";


  
  $sql ="SELECT DISTINCT RecieveID FROM conversation WHERE ";
  $sql .= " SenderID = :id";
  $sth = $dbh->prepare($sql);

  $sth->bindParam(':id', $user_id);
  $test_array['UserID'] = $user_id;
  $sth->execute();
  $result = $sth->fetchAll(PDO::FETCH_ASSOC);
  
  
  if(empty($result))
  {
    echo "No Conversations";
    ADD_FRIENDS();
  }

  //pulling all conversations 
  //with the corrosponding
  //userID
  foreach($result as $row)
  {
    $friendID = $row['RecieveID'];
    
    





    
  }
  //message object
  echo "
  <div class='msg-body'>
    <div class='username'>
      <div class='icon'></div>
      <div class='name txt-light'></div>
    </div>
    <div class='msg-content txt-light'></div>
  </div>";
  //store each message in the database, storing the datetime, msg, userid and diplaying 
  // them in order of datetime, pulling username+pic from other table.
  // also displaying datetime including time to minute, unless previous msg posted
  // by same user within 2 minutes, then only give 1 datetime/username/etc.
  // give option to rightclick? to delete/edit a users own msg, unless admin can delete any
  // post img files showing the img?
  // autodelete msgs at 6mo age unless msg is pinned or something?

  //input section
  echo '
<div class="input-group mb-3 align-bottom">
  <div class="custom-file">
  <button type="button" class="btn btn-secondary"action="getFile">+</button>
  <!--//instead of using a file input diectly on the message thing, lets use a butoon
  //that onPress, it opens up a little window like in discord, and the file input is in
  //that window, which upon opening, it automatically clicks-->
  </div>
  <div class="chatInput">
    <input type="text"class="form-control text-light bg-secondary" placeholder="message ">
  </div>
  <div class="chatSend">
    <button type="button" class="btn btn-danger" action="file?">Send</button>
  </div>
</div>
<input type="file" class=" btn-secondary" id="inputGroupFile01" >
    <label for="inputGroupFile01">++</label>';//chat input
//function deterniming if its a file, add msg after file popup like discord?

  echo '</html>';
}

function getFile(){
  //open one of those warning boxes or whatever and style it, upon opening
  // autoclick the file browse button.

}
function fileQuery() {
  
  //after function (or in function?)
  //post msg to chat
  //im assuming youre holding the messages in the database and displaying them all in a scrolling window.
}
function ADD_FRIENDS()
{
  //here, we will let the user search for usernames
  //to add friends, or by first and last name.
  //this will be treated as a COMPONENT and will be
  //added to the top of the website OR as a dialog box.
// im thinking of using a navbar that slides out toward the right with a list of friends and settings at the bottom. - KR
//searchbar to add friends at top of navbar, settings at bottom - KR
  echo
  "
  <div class='container'>
  <p>Please search for a friend. Enter username or</p>
  <p>first and last name seperated with a space</p>

  <form name='frmAddFrineds' method='post' action='AddFriends.php'>
    <input name='nameSearch' type='text' placeholder='First Last'></input>
    <button name='nameBtn' type='submit'>Search</button><br/>
    <input name='usernameSearch' type='text' placeholder='username'></input>
    <button name='usernameBtn' type='submit'>Search</button>
  </form>
  </div>
  ";
}
?>


