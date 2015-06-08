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
<head> 
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
	<style type="text/css">
		#edittab
		{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:90%;
			font-size:14px;
			border-collapse:collapse;
		}
		#edittab td, #edittab th 
		{
			font-size:1em;
			border:1px solid #98bf21;
			padding:3px 7px 2px 7px;
		}
		#edittab th 
		{
			font-size:1.1em;
			text-align:left;
			padding-top:5px;
			padding-bottom:4px;
			background-color:#4E9CE9;
			color:#ffffff;
			background-image: -webkit-gradient
			(
				linear,
				left top,
				left bottom,
				color-stop(0.19, #5AC5E0),
				color-stop(1, #4481EB)
			);
			background-image: -o-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -moz-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -webkit-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: -ms-linear-gradient(bottom, #5AC5E0 19%, #4481EB 100%);
			background-image: linear-gradient(to bottom, #5AC5E0 19%, #4481EB 100%);
		}
		#edittab tr.alt td 
		{
			color:#000000;
			background-color:#EAF2D3;
		}
	</style>
</head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="purchase_requests.php" method="POST" onLoad="_top">
<?php
include 'admin.php';
include 'db.php';

$sql="SELECT * FROM request_component where status='Approved'";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($count==0)
	echo "<br/><h3 style='color:red' align='center'>No Purchase Request</h3>";
else
{
	echo "<br/><h3 style='color:red' align='center'>Component Purchase Requests</h3>";
	
	echo "<br/><br/><table border='1' align='center' id='edittab'><tr><th>Component</th><th>Component Type</th>
	<th>Description</th><th>Quantity</th><th>Manufacturer</th><th>Part No.</th><th>User Name</th>
	<th>User Type</th><th>Project Name/Class Work</th><th>Approved By</th><th>Request Date</th>
	<th>Required By</th><th></th></tr>";
	
	$v=1;
	
	while($row = mysql_fetch_array($result))
	{
		$utype=$row['utype'];
		$uid=$row['uid'];
		if($utype=='Student')
		{
			$sql1="SELECT * FROM student where roll='$uid'";
			$result1=mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
			$uname=$row1['name'];
		}
		if($utype=='Staff')
		{
			$sql1="SELECT * FROM staff where id='$uid'";
			$result1=mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
			$uname=$row1['name'];
		}
		if($utype=='Faculty')
		{
			$sql1="SELECT * FROM faculty where id='$uid'";
			$result1=mysql_query($sql1);
			$row1 = mysql_fetch_array($result1);
			$uname=$row1['name'];
		}
		if(($v%2)==0)
		{	
			echo "<tr class='alt'><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[7]."</td>
			<td>".$row[8]."</td><td>".$row[9]."</td>";
			echo "<td>".$row[10]."</td><td>".$uname."</td><td>".$row[2]."</td><td>".$row[3]."</td>
			<td>".$row[6]."</td><td>".$row[12]."</td><td>".$row[11]."</td>
			<td><a href='purchase_requests_item.php?id=".$row['id']."'>Add to stock</a></td>";
		}
		else
		{
			echo "<tr><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[7]."</td><td>".$row[8]."</td>
			<td>".$row[9]."</td>";
			echo "<td>".$row[10]."</td><td>".$uname."</td><td>".$row[2]."</td><td>".$row[3]."</td>
			<td>".$row[6]."</td><td>".$row[12]."</td><td>".$row[11]."</td>
			<td><a href='purchase_requests_item.php?id=".$row['id']."'>Add to stock</a></td>";

		}
	$v++;
	}
}
?>
</form>
</body>
</html>