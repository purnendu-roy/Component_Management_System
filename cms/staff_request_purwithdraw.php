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
	<title>staff</title>
</head>
<body>
<form action="#" method="POST" onLoad="_top">

<?php
	include 'staff.php';
	include 'db.php';
	$uid=$_SESSION['user'];
	$sql="SELECT * FROM request_component where uid='$uid'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);
	if($count==0)
	{
		echo "<h3 style='color:red' align='center'>No Purchase Request</h3><br/>";
		echo "<center/><input type=button value='back' onclick=window.location.href='staff.php' ></input>";
	}
	
	else
	{
		echo "<h3 style='color:red' align='center'>Purchase Request</h3>";
		echo "<br/><table border='1' align='center' id='edittab' ><tr><th>Component</th><th>Project</th>
		<th>Faculty in charge</th><th>Description</th><th>Quantity</th><th>Manufacturer</th>
		<th>Part No</th><th>Request Date</th><th>Required By</th><th>Status</th><th></th></tr>";
	
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[4]."</td><td>".$row[3]."</td><td>".$row[6]."</td>
				<td>".$row[7]."</td>";
				echo "<td>".$row[8]."</td><td>".$row[9]."</td><td>".$row[10]."</td><td>".$row[12]."</td>
				<td>".$row[11]."</td><td>";
				
				if($row[13]=='Pending')
					echo "Pending</td>";
				if($row[13]=='Approved')
					echo "Request approved</td>";
				if($row[13]=='Disapproved')
					echo "Request not approved</td>";
				echo "<td><a href='staff_confirm_purwithdraw.php?id=".$row[0]."'>Withdraw</a></td>";
			}
			else
			{
				echo "<tr><td>".$row[4]."</td><td>".$row[3]."</td><td>".$row[6]."</td><td>".$row[7]."</td>";
				echo "<td>".$row[8]."</td><td>".$row[9]."</td><td>".$row[10]."</td><td>".$row[12]."</td>
				<td>".$row[11]."</td><td>";
				
				if($row[13]=='Pending')
					echo "Pending</td>";
				if($row[13]=='Approved')
					echo "Request approved</td>";
				if($row[13]=='Disapproved')
					echo "Request not approved</td>";
				echo "<td><a href='staff_confirm_purwithdraw.php?id=".$row[0]."'>Withdraw</a></td>";
			}
		$v++;
		}
	echo "</table><br/><center/>";
	echo "<center/><input type=button value='back' onclick=window.location.href='staff.php' ></input>";

	}
?>
</body>
</html>