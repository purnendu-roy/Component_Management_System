<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
}
if(!isset($_SESSION['auth']))
	header("Location:index.php");
if($_SESSION['auth']!='Student')
{
	session_destroy();
	header("Location:index.php");	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="student_request_issuestatus.php" method="POST" onLoad="_top">

<?php

	include 'student.php';
	include 'db.php';
	$uid=$_SESSION['user'];
	$sql="SELECT * FROM request_issue where uid='$uid'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count==0)
	{
		echo "<h3 style='color:red' align='center'>No Issue Request</h3><center/>";
		//echo "<br><button type="button" onclick="location.href = 'student.php';">Back</button>";
		echo "<br><input type=button value='back' onclick=window.location.href='student.php' ></input>";
	}
	else
	{
		echo "<h3 style='color:red' align='center'>Component Issue Requests</h3>";
		echo "<table border='1' align='center' id='edittab'><tr><th>No.</th><th>Component</th>
		<th>Category</th><th>Sub Category</th><th>Description</th><th>Quantity</th><th>Project</th>
		<th>Guide</th><th>Request Date</th><th>Status</th></tr>";
		
		$v=1;
		$no=1;
		while($row = mysql_fetch_array($result))
		{
				if(($v%2)==0)
				{
					$id=$row['cid'];
					$sql1="SELECT * FROM consumable where id='$id'";
					$result1=mysql_query($sql1);
					$row1 = mysql_fetch_array($result1);
					echo "<tr class='alt'><td>".$no."</td><td><u>
					<a href='issue_comp_details.php?id=$row1[0]'>".$row1[1]."</a></u></td>
					<td>".$row1[2]."</td><td>".$row1[3]."</td><td>".$row1[4]."</td>";
					
					echo "<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>";
					if($row[8]=='Pending')
						echo "Pending</td>";
					if($row[8]=='Approved')
						echo "Request approved</td>";
					if($row[8]=='Disapproved')
						echo "Request not approved</td></tr>";

				}
				else
				{
					$id=$row['cid'];
					$sql1="SELECT * FROM consumable where id='$id'";
					$result1=mysql_query($sql1);
					$row1 = mysql_fetch_array($result1);
					echo "<tr><td>".$no."</td>
					<td><u><a href='issue_comp_details.php?id=$row1[0]'>".$row1[1]."</a></u></td>
					<td>".$row1[2]."</td><td>".$row1[3]."</td><td>".$row1[4]."</td>";
					echo "<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>";
					if($row[8]=='Pending')
						echo "Pending</td>";
					if($row[8]=='Approved')
						echo "Request approved</td>";
					if($row[8]=='Disapproved')
						echo "Request not approved</td></tr>";
				}
			$v++;
			$no++;
		
		}
		echo "</table><center/>";
	//echo "</table><br><button type="button" onclick="location.href = 'student.php';">Back</button>";
		echo "<br><input type=button value='back' onclick=window.location.href='student.php' ></input>";
	}	
?>
</form>
</body>
</html>