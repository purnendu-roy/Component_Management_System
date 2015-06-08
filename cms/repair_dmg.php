<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Admin')
{
	session_destroy();
	header("Location:index.php");	
}

$q=$_GET["id"];
include 'db.php';

$sql = "SELECT * FROM issue_capital WHERE cid='$q'";
$result = mysql_query($sql);
if(mysql_num_rows($result)==0)
	$status='Available';
else
	$status='Issued';

$sql = "UPDATE capital SET status='$status',remarks='' WHERE id='$q'";
$result = mysql_query($sql);
header("location:damaged_components.php");
?>