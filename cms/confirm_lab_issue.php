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
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="confirm_lab_issue.php" method="POST" onLoad="_top">
<?php

include 'admin.php';
include 'db.php';

$uid=$_SESSION['issueuserid'];
$idate=date("d/m/Y");

if($_SESSION['issuecmp']=='All')
{
	$sql="SELECT * FROM request_issue where uid='$uid' and status='Approved'";
	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{	
		$id=$row['id'];
		$cid=$row['cid'];
		$quant=$row['quantity'];
		$sql1="Select MAX(id) AS id FROM lab_issue_consumable";
		$result1=mysql_query($sql1);
		while($row1 = mysql_fetch_array($result1))
			$id1=$row1['id'];
		$id1=$id1+1;
		$sql2="INSERT INTO lab_issue_consumable VALUES('$id1','$cid','$uid','$quant','$idate')";
		$result2=mysql_query($sql2);
		$sql3="DELETE FROM request_issue WHERE id='$id'";
		$result3=mysql_query($sql3);
	}	
	print "<br/><h3 style='color:red' align='center'>All components issued successfully</h3><center/>";
	echo "<br/><button type='button' onclick='history.back();'>Back</button>";
}
else
{
	foreach($_SESSION['issuecmp'] as $arr) 
	{
        $sql="SELECT * FROM request_issue where id='$arr'";
		$result=mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
			$sql1="Select MAX(id) AS id FROM lab_issue_consumable";
			$result1=mysql_query($sql1);
			while($row1 = mysql_fetch_array($result1))
				$id1=$row1['id'];
			$id1=$id1+1;
			$cid=$row['cid'];
			$quant=$row['quantity'];
			$sql2="INSERT INTO lab_issue_consumable VALUES('$id1','$cid','$uid','$quant','$idate')";
			$result2=mysql_query($sql2);
			$sql3="DELETE FROM request_issue WHERE id='$arr'";
			$result3=mysql_query($sql3);	
		}
       	unset($_SESSION['issuecmp']);
	}
	echo("<h3 style='color:red' align='center'>Selected components issued successfully</h3>");
	echo "<br/><br/><center/><button type='button' onclick='history.back();'>Back</button>";
}
?>
</form>
</body>
</html>