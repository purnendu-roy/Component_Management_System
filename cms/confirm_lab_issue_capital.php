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
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title></title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="confirm_lab_issue_capital.php" method="POST" onLoad="_top">
<?php

include 'admin.php';
include 'db.php';

$uid=$_SESSION['issueuserid'];
$sql="Select * FROM staff WHERE id='$uid'";
$result=mysql_query($sql);
$row = mysql_fetch_array($result);
$lab=$row['lab'];
$idate=date("d/m/Y");

foreach($_SESSION['issuecmp'] as $arr) 
{
	$sql5="SELECT * FROM capital where id='$arr'";
	$result5=mysql_query($sql5);
	$row5 = mysql_fetch_array($result5);
	$refno=$row5['refno'];
	
	$sql="UPDATE capital SET status='Issued' where id='$arr'";
	$result=mysql_query($sql);
	
	$sql1="Select MAX(id) AS id FROM issue_capital";
	$result1=mysql_query($sql1);
	$row1 = mysql_fetch_array($result1);
		$id1=$row1['id'];
	$id1=$id1+1;
	
	$sql2="INSERT INTO issue_capital VALUES('$id1','$arr','$uid','$lab','$idate')";
	$result2=mysql_query($sql2);
	
	$sql3="DELETE FROM request_component WHERE refno='$refno'";
	$result3=mysql_query($sql3);	
     	unset($_SESSION['issuecmp']);
}

echo "<h3 style='color:red' align='center'>Selected components issued successfully</h3>";
header("refresh:2;admin.php");
?>
</form>
</body>
</html>