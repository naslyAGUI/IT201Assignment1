<?php
//---------------------------------------------------------------DB---------------------------------------
print "Hello<br>" ;
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


$flag = false; 						
$UCID   = GET("UCID",  $flag); 	
$pass = GET("pass", $flag); 
$amount   = GET("amount", $flag);
$type = GET("type", $flag);  
$mail = GET("mail", $flag);  
if ($flag) {exit("<br>Failed: empty input field.");};	
  
  if (! authenticate($UCID,$pass, $db) ) { exit ("bad cred try again"); } ;
  print "Welcome $UCID"; 
  
	if ($type == 'D')
	{ deposit($UCID,$type,$amount,$mail);
     echo "<br>Deposit done</br>";
	}

	if ($type == 'W' )
	{	withdraw($UCID, $type,$amount,$mail, $db);
	  echo "<br>Withdraw done</br>";
	}
	


 
print "<br>bye" ;
print "<br>Interaction completed.<br><br>" ;

mysqli_free_result($t);
mysqli_close($db);
exit ( ) ;

?>