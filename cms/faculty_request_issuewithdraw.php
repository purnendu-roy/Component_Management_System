<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Faculty')
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
			width:70%;
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
<title>Faculty</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="faculty_request_issuewithdraw.php" method="POST" onLoad="_top">
<?php
	include 'faculty.php';
	include 'db.php';
	$uid=$_SESSION['user'];
	$sql="SELECT * FROM request_issue where uid='$uid'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count==0)
	{
		echo "<h2 style='color:red' align='center'>No Issue Request</h2>";
	echo "<br/><center/><input type=button value='back' onclick=window.location.href='faculty.php'></input>";
	}
	else
	{
		echo "<h3 style='color:red' align='center'>Issue Requests</h3>";
		echo "<br/><table border='1' align='center' id='edittab' ><tr><th>Component</th><th>Category</th>
		<th>Sub Category</th><th>Description</th><th>Quantity</th><th>Project</th><th>Request Date</th>
		<th></th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{
				$id=$row['cid'];
				$sql1="SELECT * FROM consumable where id='$id'";
				$result1=mysql_query($sql1);
				$row1 = mysql_fetch_array($result1);
				echo "<tr class='alt'><td><u><a href='issue_comp_details.php?id=".$row1[0]."'>
				".$row1[1]."</a></u></td><td>".$row1[2]."</td><td>".$row1[3]."</td><td>".$row1[4]."</td>";
				echo "<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[7]."</td>";
				echo "<td><a href='faculty_confirm_issuewithdraw.php?id=".$row[0]."'>Withdraw</a></td>";
			}
			else
			{
				$id=$row['cid'];
				$sql1="SELECT * FROM consumable where id='$id'";
				$result1=mysql_query($sql1);
				$row1 = mysql_fetch_array($result1);
				echo "<tr><td><u><a href='issue_comp_details.php?id=".$row1[0]."'>
				".$row1[1]."</a></u></td><td>".$row1[2]."</td><td>".$row1[3]."</td><td>".$row1[4]."</td>";
				echo "<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[7]."</td>";
				echo "<td><a href='faculty_confirm_issuewithdraw.php?id=".$row[0]."'>Withdraw</a></td>";
			}
		$v++;
		}
	echo "</table>";
    echo "<br/><center/><input type=button value='back' onclick=window.location.href='faculty.php'></input>";

	}
?>
</form>
</body>
</html>