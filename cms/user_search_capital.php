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
<form action="user_search_capital.php" method="POST" onLoad="_top">
<?php
	if($_SESSION['auth']=='Student')
		include 'student.php';
	else if($_SESSION['auth']=='Faculty')
		include 'faculty.php';
	else
		include 'staff.php';
	
	if(!isset($_POST['component']))
	{
		print "<br><h3 align='center'>Search Capital Items</h3><br>";
		addform();
	}
	else if($_POST['component'] )
	{
		searchData();
	}
	else
	{
		print "<br><h3 style='color:red' align='center'>Please enter item name</h3><br>";
		addform();
	}
?>
<?php
	function addform()
	{
		echo "<table align='center'><tr><td>*Item Name</td>";
		echo "<td><input list='main' name='component'>";
		echo "<datalist id='main'>";
		
			include 'db.php';
			$sql= "select distinct name from capital";
			$result=mysql_query($sql);
			while($row=mysql_fetch_array($result))
			{
				echo "<option>".$row['name']."</option>";
			}
		
		echo "</datalist></td></tr>";
		echo "<tr><td><input type='submit' value='search'></input></td></tr>";
	}
	function searchData()
	{
		$name=$_POST['component'];
		include 'db.php';
		$sql="select * from capital where name like '%$name%'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result)== 0)
		{
			echo "<h3 align='center' style='color:red'>No Data Found</h3>";
			addform();
		}
		else
		{
			echo "<h3 align='center' style='color:#F78181'><u>Searched Result</u></h3>";
			echo "<table border='1' align='center' id='edittab'><tr><th>Item Name</th>";
			echo "<th>Category</th><th>Description</th><th>Bill No.</th><th>Unit Price(Rs.)</th>";
			echo "<th>Manufacturer</th><th>Status</th>";
			
			$v=1;
			while($row=mysql_fetch_array($result))
			{
				if(($v%2)==0)
				{
					echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
			echo "<td>".$row[6]."</td><td>".$row[5]."</td><td>".$row[8]."</td><td>".$row[14]."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
			echo "<td>".$row[6]."</td><td>".$row[5]."</td><td>".$row[8]."</td><td>".$row[14]."</td></tr>";
				}
				$v++;
			}
			echo "</table><center>";
			echo "<br>
			<input type=button value='back' onclick=window.location.href='user_search_capital.php' ></input>";
			echo "</center>";
		}
	}
?>
</form>
</body>
</html>