<?php
//---------------------------------------------------------------DB-------------------------------------------------------------------
print "Hello<br>" ;
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
ini_set('display_errors' , 1);

include (  "account.php"     ) ;
include (  "myfunctions.php"     ) ;
$db = mysqli_connect($hostname,$username, $password ,$project);
if (mysqli_connect_errno())
  {	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
  }
print "<br>Successfully connected to MySQL.<br>";
mysqli_select_db( $db, $project ); 
//----------------------------------------------------------  Data   --------------------------------------------------------------------

$flag = false;
$UCID   = GET("UCID",  $flag); 	
$pass  = GET("pass", $flag);    
$number = GET("number", $flag); 

$mailChoice = $_GET [ "mailChoice"  ] ;
 

if ($flag) {exit("<br>Failed: empty input field.");};	





if ( ! authenticate( $UCID, $pass,  $db)) { exit ( "bad cred")  ;} ;
display ( $UCID, $number, $output, $db);

//if ($mailChoice == 'Y'){
//mailer($UCID, $output); 
//}
  






print "<br>bye";
mysqli_free_result($t) ;
mysqli_close($db) ;
exit ( "<br>Interaction completed.<br><br>" ) ;
?>