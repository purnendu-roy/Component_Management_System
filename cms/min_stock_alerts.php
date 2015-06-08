<?php
include 'admin.php';
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}	
	if(!isset($_SESSION['auth']))
	{
		header("Location:index.php");
	}
	if($_SESSION['auth']!='Admin')
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
		width:60%;
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
		}
		#edittab tr.alt td 
		{
		color:#000000;
		background-color:#EAF2D3;
		}
	</style>
</head>
<body>
<form action="min_stock_alerts.php" method=POST onLoad="_top">

<?php
include 'db.php';
	$sql="select * from consumable";
	$result=mysql_query($sql);
	$flag=0;
	$v=1;
	$no=1;
	while($row = mysql_fetch_array($result))
	{
		$quant=$row['quantity'];
		$alert=$row['alert'];
		
		if($quant<=$alert)
		{
			if($flag==0)
			{
			echo "<br/><h3 style='color:red' align='center'>Minimum Stock Alerts</h3>";
			echo "<table border='1' align='center' id='edittab' ><tr><th>No</th><th>Type</th><th>Category</th>
				<th>Sub Category</th><th>Description</th><th>Available Quantity</th><th></th></tr>";
			$flag=1;
			}
			if(($v%2)==0)
			{
		echo "<tr class='alt'><td>".$no."</td><td><u><a href='issue_comp_details.php?id=".$row[0]."'>
		".$row[1]."</a></u></td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>
		<td>".$row[5]."</td><td><u><a href='edit_consumable_item.php?id=".$row[0]."' style='color:red'>Add</a>
		</u></td>";
			}
			else
			{
				echo "<tr><td>".$no."</td><td><u><a href='issue_comp_details.php?id=".$row[0]."'>".$row[1]."</a></u></td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td><u><a href='edit_consumable_item.php?id=".$row[0]."' style='color:red'>Add</a></u></td>";
			}
			$no++;	
		}
		$v++;
		
	}echo "</table>";
	if($flag==0)
	{
		print "<br/><h3 style='color:red' align='center'>No data found</h5>";
	}
	echo "<br><center><button type='button'><a href='admin.php'>Back</a></button></center></br>";
//echo "<br><center><button type='button' onclick='location.href='admin.php''>Back</button></center></br>";
?>
</form>
</body>
</html>