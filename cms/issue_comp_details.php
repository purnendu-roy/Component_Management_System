<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['auth']))
		header("Location:index.php");
?>
<html>
<head> 
	
	<style type="text/css">
		#edittab
		{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:80%;
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
<body>
<form action="#">
<?php
	if($_SESSION['auth']=='Student')
		include 'student.php';
	else if($_SESSION['auth']=='Faculty')
		include 'faculty.php';
	else if($_SESSION['auth']=='Staff')
		include 'staff.php';
	else
		include 'admin.php';
	
	$id=$_GET["id"];
	include 'db.php';
	$sql = "SELECT * FROM consumable WHERE id='$id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$specid=$row['specid'];
	
	$sql1="SELECT * FROM specification where id='$specid'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	echo "<br/><table border='1' align='center' id='edittab'><tr><th>Component</th>
	<th>Category</th><th>Sub Category</th><th>Description</th>";
	if(!empty($row1['f1']))
		echo "<th>".$row1['f1']."</th>";
	if(!empty($row1['f2']))
		echo "<th>".$row1['f2']."</th>";
	if(!empty($row1['f3']))
		echo "<th>".$row1['f3']."</th>";
	if(!empty($row1['f4']))
		echo "<th>".$row1['f4']."</th>";
	if(!empty($row1['f5']))
		echo "<th>".$row1['f5']."</th>";
	if(!empty($row1['f6']))
		echo "<th>".$row1['f6']."</th>";
	if(!empty($row1['f7']))
		echo "<th>".$row1['f7']."</th>";
	if(!empty($row1['f8']))
		echo "<th>".$row1['f8']."</th>";
	if(!empty($row1['f9']))
		echo "<th>".$row1['f9']."</th>";
	if(!empty($row1['f10']))
		echo "<th>".$row1['f10']."</th>";

	if($_SESSION['auth']=='Admin')
	{
		echo "</th><th>Quantity</th><th>Price</th><th>Purchase Date</th><th>Manufacturer</th>
		<th>Reference No.</th></tr>";
	echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
	
		if(!empty($row1['f1']))
			echo "<td>".$row['f1']."</td>";
		if(!empty($row1['f2']))
			echo "<td>".$row['f2']."</td>";
		if(!empty($row1['f3']))
			echo "<td>".$row['f3']."</td>";
		if(!empty($row1['f4']))
			echo "<td>".$row['f4']."</td>";
		if(!empty($row1['f5']))
			echo "<td>".$row['f5']."</td>";
		if(!empty($row1['f6']))
			echo "<td>".$row['f6']."</td>";
		if(!empty($row1['f7']))
			echo "<td>".$row['f7']."</td>";
		if(!empty($row1['f8']))
			echo "<td>".$row['f8']."</td>";
		if(!empty($row1['f9']))
			echo "<td>".$row['f9']."</td>";
		if(!empty($row1['f10']))
			echo "<td>".$row['f10']."</td>";
	echo "<td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[11]."</td>
	<td>".$row[12]."</td></tr>";
	echo "</table>";
	}
	
	else
	{
		echo "</th><th>Manufacturer</th></tr>";
	echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
	
		if($row['f1']!='NIL')
		if(!empty($row1['f1']))
			echo "<td>".$row['f1']."</td>";
		if(!empty($row1['f2']))
			echo "<td>".$row['f2']."</td>";
		if(!empty($row1['f3']))
			echo "<td>".$row['f3']."</td>";
		if(!empty($row1['f4']))
			echo "<td>".$row['f4']."</td>";
		if(!empty($row1['f5']))
			echo "<td>".$row['f5']."</td>";
		if(!empty($row1['f6']))
			echo "<td>".$row['f6']."</td>";
		if(!empty($row1['f7']))
			echo "<td>".$row['f7']."</td>";
		if(!empty($row1['f8']))
			echo "<td>".$row['f8']."</td>";
		if(!empty($row1['f9']))
			echo "<td>".$row['f9']."</td>";
		if(!empty($row1['f10']))
			echo "<td>".$row['f10']."</td>";

		echo "<td>".$row[11]."</td></tr>";
		echo "</table>";


	}
	//echo "<center><br><button type='button'><a href='admin.php'>Back</a></button></center>";
	echo "<BR/><center/><button type='button' onclick='history.back();'>Back</button>";
?>
</form>
</body>
</html>