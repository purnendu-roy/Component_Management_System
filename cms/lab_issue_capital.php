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
<form action="lab_issue_capital.php" method="POST" onLoad="_top">
<?php
include 'admin.php';

if(!isset($_POST['rno']))
{
	echo "<br/><table align='center'><tr><td>Select Lab : </td><td>";
	echo "<select name='rno'>";
	include 'db.php';
	$sql = "SELECT  name from labs";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<option>".$row['name']."</option>";
	}
  	echo "</select></td></tr></table>";
	echo "<table align='center'><tr><td><input type='submit' name='submit' value='Submit'></input>
	</td></tr></table>";
}
else if($_POST['rno'])
{
	include 'db.php';
	
	$rno=$_POST['rno'];
	$sql1 = "SELECT  * from staff where lab='$rno'";
	$result1 = mysql_query($sql1);
	$row1 = mysql_fetch_array($result1);
	$uid=$row1['id'];
	$_SESSION['issueuserid']=$row1['id'];
	$sql2="SELECT * FROM request_component WHERE uid='$uid' and status='Purchased'";
	$result2=mysql_query($sql2);
	
	if(mysql_num_rows($result2) == 0)
	{
	print "<br/><h3 style='color:red' align='center'>No Purchase Requests or Requested item not purchased</h3>";
	echo "<br/><center/><button type='button' onclick='history.back();'>Back</button>";
	}
	else
		header("location:lab_issue_capital_details.php?id=$uid");
}
else
{
	echo "<h4 align='center' style='color:red' >Select Lab: </h4>";
	echo "<select name='rno'>";
	
	include 'db.php';
	$sql = "SELECT  name from labs";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{
		echo "<option>".$row['name']."</option>";
	}
	echo "</select></td></tr>";	
	echo "<tr><td><input type='submit' name='submit' value='Submit'></input></td></tr>";
}
?>
</form>
</body>
</html>