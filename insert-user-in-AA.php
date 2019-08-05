<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);

include (  "account.php"     ) ;
include ( "myfunctions.php" ) ;
$db = mysqli_connect($hostname,$username, $password ,$project);
if (mysqli_connect_errno())
  {	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
  }
print "<br>Successfully connected to MySQL.<br>";
mysqli_select_db( $db, $project ); 

echo "Hello <br><br>" ;

$UCID = $_GET [ "UCID"  ] ; echo "UCID is: $UCID <br> " ;
$pass = $_GET [ "pass"  ] ;   echo "pass is: $pass <br> " ;
$pass_again = $_GET [ "pass_again" ] ; echo "pass is: $pass_again<br>";
$name = $_GET [ "name"  ] ; echo "name is: $name <br> " ;
$mail = $_GET [ "mail" ] ; echo "mail is: $mail <br> " ;
$initial = $_GET [ "initial" ] ; echo "initial is: $initial <br> " ;





date_default_timezone_set ("America/New_York"); $date = "<i>recent</i> is initialized to: " . date ("l jS \of F Y h:i:s A") . "<br>" ;
echo $date ;



insert ($UCID, $pass, $name, $mail, $initial, $db);





?>