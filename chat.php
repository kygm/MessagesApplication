<?php
require('./dbconnect.php');
  require('./header.html');
  echo "<p>Under construction...</p>";
  echo "<p>This page will contain the actual chat</p> 
  <p>application and friends list</p>";
  echo "git test";
  //new test
//Kenny test
//hey
  //newer test
  //bitch

  //can you see me kenny
  //yeah
  //should we use a profile pic?
  
  //msg section
  echo "
  <div class='scrolling window bit'>

  
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
<div class="input-group mb-3">
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
function getFile(){
  //open one of those warning boxes or whatever and style it, upon opening
  // autoclick the file browse button.

}
function fileQuery() {
  
  //after function (or in function?)
  //post msg to chat
  //im assuming youre holding the messages in the database and displaying them all in a scrolling window.
}

  echo '</html>';
?>


