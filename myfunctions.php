<?php


//-------------------------------------------------------------Authentication Function--------------------------------------------------------
function authenticate ($UCID, $pass, $db )
{
	global $t;

    $s = "select * from AA where UCID= '$UCID' AND pass= '$pass' ";
    echo "<br>SQL select is: $s <br>" ;
	($t  = mysqli_query ($db , $s)) or die (mysqli_error($db) );
    $num = mysqli_num_rows ($t ) ;
    if ($num == 0){return false;} else {return true;};
  
}
//------------------------------------------------------------GET Function--------------------------------------------------------

function GET($fieldname, &$flag){

	global $db ;
	$v = $_GET [$fieldname];
	$v = trim ( $v );
	if ($v == "") 
	  { $flag = true ; echo "<br><br>$fieldname is empty." ; return  ;} ;
	$v = mysqli_real_escape_string ($db, $v );
  echo "<br>$fieldname is $v."  ;
	return $v; 
 
  
}

//------------------------------------------------------------Display Function--------------------------------------------------------

function display ($UCID, $number, &$output, $db)
{
	global $t;
	
	$s = "select * from AA where UCID = '$UCID'";
	$output = "<br>SQL statement is: $s<br>";
	($t  = mysqli_query ($db , $s)) or die (mysqli_error($db) );

print "<table  border=2>";
print"<tr>";
    echo"<th>UCID</th>";
		echo"<th>pass</th>";
		echo"<th>name</th>";
		echo"<th>mail</th>";
		echo"<th>initial</th>";
    echo"<th>current</th>";
    echo"<th>recent</th>";
    echo"<th>plaintext</th>";
print"</tr>";
	while ($r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) {
		$UCID = $r["UCID"];
    $pass = $r["pass"];
    $name = $r["name"];
    $mail = $r["mail"];
    $initial = $r["initial"];
    $current = $r["current"];
    $recent = $r["recent"];
    $plaintext = $r["plaintext"];
    
print"<tr>";
	echo "<td>$UCID</td>" ;
	echo "<td>$pass</td>";
	echo "<td>$name</td>";
	echo "<td>$mail</td>";
  echo "<td>$initial</td>";
  echo "<td>$current</td>";
  echo "<td>$recent</td>";
  echo "<td>$plaintext</td>";
	print"</tr>";
		
    $output .= "<br>Initial balance was: $initial<br>";
		$output .= "<br>Current balance is: $current<br>";
		
	}
	
	$s = "select * from TT where UCID = '$UCID' order by date desc LIMIT $number" ;
	$output .= "<br>Account activity: $s<br>";
	($t  = mysqli_query ($db , $s)) or die (mysqli_error($db) );
print "<table  border=2>";
print"<tr>";
		echo"<th>type</th>";
		echo"<th>amount</th>";
		echo"<th>date</th>";
		echo"<th>mail</th";
print"</tr>";
	while ($r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) {
		$UCID = $r["UCID"];
		$amount = $r["amount"];
		$type = $r["type"];
		$date = $r["date"];
   
print"<tr>";
	echo "<td>$type</td>" ;
	echo "<td>$amount</td>";
	echo "<td>$date</td>";
	echo "<td>$mail</td>";
	print"</tr>";
		
		$output .= "<br>Amount: $amount<br>";
		$output .= "Transaction type: $type<br>";
		$output .= "Date: $date<br>";
    $output .="Mail: $mail<br>";
		
	}
	echo $output;
	
}
//------------------------------------------------------------Mail function------------------------------------------------------------


function mailer ($UCID, &$output){
	global $db;
	
	$s = "Select * from AA where UCID = '$UCID' " ;
	($t  = mysqli_query ($db , $s)) or die (mysqli_error($db) );
	while ($r = mysqli_fetch_array($t,MYSQLI_ASSOC))
	{ $email = $r[ "mail"];}
$to = "$email";
$subject = "Account Statement for UCID: $UCID";
$message = $output ;
mail($to, $subject, $message);
echo "<br>Email was sent <br>";

}







//------------------------------------------------------------Enough Function-----------------------------------------------------------

function enough($UCID, $amount, $db ) {
	global $t ;

	$s = "select * from AA where UCID = '$UCID' and current >= '$amount' " ;
	echo "<br>SQL select statement is: $s <br>" ;
	($t = mysqli_query ($db, $s) ) or die ( mysqli_error($db) ) ;

	$num = mysqli_num_rows ( $t ) ;
	if ( $num == 0 ) 
		{return false;}   
	else { return true;};		
}
	
//------------------------------------------------------------Withdraw Function--------------------------------------------------------


function withdraw($UCID, $type, $amount,$mail, $db){
	if (enough($UCID, $amount, $db)) {
		
		global $db;
		$s = "insert into TT values ('$UCID' , '$type' , '$amount' , NOW(), '$mail' ) " ;
		echo "<br>SQL insert statement is : $s <br> ";
		print "<br>SQL insert TT statement was transmitted for execution.<br>";
		($t = mysqli_query ( $db , $s )) or die (mysqli_error($db)) ;

		$s2= "update AA set recent=NOW(), current = current - '$amount' where UCID = '$UCID' ";
		echo "<br> SQL update statement is: $s2 <br> " ;
		($t = mysqli_query ( $db , $s2)) or die (mysqli_error($db)) ;
		print "<br>SQL statement was transmitted for execution.<br>";
	

		
		}
	else {echo "cannot withdraw"; };
}

//-------------------------------------------------------------Deposit Function--------------------------------------------------------

function deposit($UCID,$type,$amount,$mail){
	global $db;
	$s = "insert into TT values ('$UCID' , '$type' , '$amount' , NOW(), '$mail' ) " ;
	echo "<br> The SQL insert to TT is : $s <br> ";
	print "<br>SQL insert TT statement was transmitted for execution.<br>";
	($t = mysqli_query ( $db , $s )) or die (mysqli_error($db)) ;

	$s1= "update AA set recent=NOW(), current = current + '$amount'  where UCID = '$UCID' ";
	echo "<br> SQL update to AA: $s1 <br> " ;
	($t = mysqli_query ( $db , $s1 )) or die (mysqli_error($db)) ;
	print "<br>SQL statement was transmitted for execution.<br>";
 



}
	
//--------------------------------------------------------Insert Function--------------------------------------------------------


function insert ($UCID, $pass, $name, $mail, $initial, $db)
  {
  $s = " insert into AA values('$UCID' , '$pass' , '$name' , '$mail' , '$initial' , '$initial' , NOW() , '$pass'    ) " ;
  echo "The SQL is $s <br><br>" ;

  echo "Bye ";
  echo " Interaction completed." ;
  ($t=mysqli_query ($db, $s) ) or die(mysqli_error($db));
	}














?>