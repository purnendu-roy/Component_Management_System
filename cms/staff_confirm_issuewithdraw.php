<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Staff')
{
	session_destroy();
	header("Location:index.php");	
}
?>
<html>
<head> 
	<title>staff</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
</head>
<body>
<?php
	include 'staff.php';
	$id=$_GET["id"];
	
	include 'db.php';
	$sql="SELECT * from request_issue where id='$id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
	if($row['status']=='Disapproved')
	{
		$sql="DELETE FROM request_issue where id='$id'";
		$result=mysql_query($sql);
		echo "<h3 style='color:red' align='center'>Request withdrawn successfully </h3><br/><center/>";
		echo "<input type=button value='back' onclick=window.location.href='staff.php' ></input>";
	}
	
	else
	{
		$q=$row['quantity'];
		$cid=$row['cid'];
		
		$sql="SELECT * from consumable where id='$cid'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		$aq=$row['quantity'];
		$quant=$q+$aq;
		
		$sql="UPDATE consumable SET quantity='$quant' where id='$cid'";
		$result=mysql_query($sql);
		$sql="DELETE FROM request_issue where id='$id'";
		$result=mysql_query($sql);
		
		if($result)
			echo "<h3 style='color:red' align='center'>Request withdrawn successfully </h3>";

		echo "<br/><center/><input type=button value='back' onclick=window.location.href='staff.php' ></input>";

	}
?>
</body>
</html>