<?php

include "settings.php";

if(isset($_POST['pass'])) {
    $pass = $_POST['pass']; 
  } else {
    $pass = '';
  }

if($pass == $utilsPassword)
  {
          include("phpbb_list.php");
  }
else 
  {
    if(isset($_POST))
    {
?> 

            <form method="POST" action="utils.php">
            Password  <input type="password" name="pass"></input><br/>
            <input type="submit" name="submit" value="Go"></input>
            </form>
<?php

    }

  }

?>