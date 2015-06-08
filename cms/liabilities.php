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
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
	<style type="text/css">
		#edittab
		{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:70%;
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
<form action="liabilities.php" method="POST" onLoad="_top">
<?php
	if($_SESSION['auth']=='Student')
		include 'student.php';
	else if($_SESSION['auth']=='Faculty')
		include 'faculty.php';
	else
		include 'staff.php';
	
	include 'db.php';
	$uid=$_SESSION['user'];
	
	if($_SESSION['auth']=='Staff')
	{
		//taking from lab issue consumable items from DB
		$sql="SELECT * FROM lab_issue_consumable WHERE uid='$uid'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result) == 0)
		{
			$flag=0;
		}
		else
		{
			$flag=1;
			
			print "<br/><h3 style='color:grey' align='center'>Consumable Items</h3>";
			echo "<br/><table border='1' align='center' id='edittab'><tr><th>No</th><th>Component</th>
			<th>Category</th><th>SubCategory</th><th>Description</th><th>Quantity</th>
			<th>Issue Date</th></tr>";
			
			$v=1;
			$no=1;
			
			while($row = mysql_fetch_array($result))
			{
				$cid=$row['cid'];
				$sql1="SELECT * FROM consumable WHERE id='$cid'"; 
				$res=mysql_query($sql1);
				$row1 = mysql_fetch_array($res);
				
				if(($v%2)==0)
				{
					echo "<tr class='alt'><td>".$no."</td>
					<td><a href='issue_comp_details.php?id=$cid'>".$row1[1]."</a></td>
					<td>".	$row1[2]."</td><td>".$row1[3]."</td><td>".$row1[4]."</td>	
					<td>".$row[3]."</td><td>".$row[4]."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$no."</td>
					<td><a href='issue_comp_details.php?id=$cid'>".$row1[1]."</a></td>
					<td>".$row1[2]."</td><td>".	$row1[3]."</td><td>".$row1[4]."</td>
					<td>".$row[3]."</td>	<td>".$row[4]."</td></tr>";
				}
				$v++;
			}
			echo "</table>";
		}
		if($flag==0)
			echo "<br/><br/><h3 style='color:red' align='center'>You have no Consumable Items Liabilities</h3>";
		
		$sql5="SELECT * FROM issue_capital where staffid='$uid'";//taking from issue capital items from DB
		$result5=mysql_query($sql5);
		if(mysql_num_rows($result5) == 0)
		{
			$flag=0;
		}
		else
		{
			$flag=1;
			print "</table><br>";
			echo "<br/><h3 style='color:red' align='center'>Capital Items</h3>";
			echo "<br/><table border='1' align='left' id='edittab'><tr><th>No</th>
			<th>Item Name</th><th>Category</th><th>Description</th><th>Serial No</th>
			<th>Manufacturer</th><th>Issue Date</th>";
			
			$v=1;
			$no=1;
			while($row5 = mysql_fetch_array($result5))
			{
				$id=$row5['staffid'];
				$cid=$row5['cid'];
				$sql1="SELECT * FROM staff WHERE id='$id'";
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				
				$sql2="SELECT * FROM capital WHERE id='$cid'";
				$result2=mysql_query($sql2);
				$row2=mysql_fetch_array($result2);
				$cname=$row2['name'];
				$cat=$row2['category'];
				$sno=$row2['sno'];
				$des=$row2['description'];
				
				if(($v%2)==0)
				{	
					echo "<tr class='alt'><td>".$no."</td><td>".$cname."</td>
					<td>".$cat."</td><td>".$des."</td><td>".$sno."</td><td>".$row2['manu']."</td>
					<td>".$row5['idate']."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$no."</td><td>".$cname."</td><td>".$cat."</td>
					<td>".$des."</td><td>".$sno."</td><td>".$row2['manu']."</td>
					<td>".$row5['idate']."</td></tr>";
				}
				$v++;
				$no++;
			}
			echo "</table>";
		}
		if($flag==0)
			echo "<br/><br/><h3 style='color:red' align='center'>You have no Capital Items Liabilities</h3>";
	}
	
	else
	{
		$sql="SELECT * FROM user_issue_consumable WHERE uid='$uid'";
		$result=mysql_query($sql);

		if(mysql_num_rows($result) == 0)
		{
			echo "<br/><br/><h3 style='color:red' align='center'>You have no liabilities</h3>";
		}
		else
		{
			echo "<h3 style='color:red' align='center'>Liabilities</h3>";
			echo "<br/><table border='1' align='center' id='edittab' ><tr><th>Component</th>
			<th>Category</th><th>Sub Category</th><th>Description</th><th>Quantity</th>
			<th>Issue Date</th><th>Return Date</th></tr>";
			
			$v=1;
			while($row = mysql_fetch_array($result))
			{
				$cid=$row['cid'];
				$sql1="SELECT * FROM consumable WHERE id='$cid'"; 
				$res=mysql_query($sql1);
				$row1 = mysql_fetch_array($res);
				if(($v%2)==0)
				{
					echo "<tr class='alt'><td><a href='issue_comp_details.php?id=$cid'>".$row1[1]."</a></td>
					<td>".	$row1[2]."</td><td>".$row1[3]."</td><td>".$row1[4]."</td>	
					<td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td></tr>";
				}
				else
				{
					echo "<tr><td><a href='issue_comp_details.php?id=$cid'>".$row1[1]."</a></td>
					<td>".$row1[2]."</td><td>".	$row1[3]."</td><td>".$row1[4]."</td><td>".$row[4]."</td>
					<td>".$row[5]."</td><td>".$row[6]."</td></tr>";
				}
				$v++;
			}
		}
	}
?>
</form>
</body>
</html>