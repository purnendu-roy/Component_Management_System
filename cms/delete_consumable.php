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

<html>
<head><title></title>
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
</head>
<body>
<form action="#" method="POST" onLoad="_top">
<?php
	include 'admin.php';
	$cid=$_GET['cid'];
	include 'db.php';
	$sql="DELETE FROM request_issue WHERE cid='$cid'";
	$result=mysql_query($sql);
	$sql="DELETE FROM user_issue_consumable WHERE cid='$cid'";
	$result=mysql_query($sql);
	$sql="DELETE FROM lab_issue_consumable WHERE cid='$cid'";
	$result=mysql_query($sql);
	$sql="DELETE FROM consumable WHERE id='$cid'";
	$result=mysql_query($sql);
	echo "<br/><h4 style='color:red' align='center'>Deleted successfully</h4><center/>";
	echo "<br/><input type=button value='back' onclick=window.location.href='admin.php' ></input>";
?>
</form>
</body>
</html>