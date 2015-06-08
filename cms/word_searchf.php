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
			font-size:14px;
			width:90%;
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
<form action="word_searchf.php" method="POST" onLoad="_top">
<?php
	include 'faculty.php';
	if(!isset($_POST['submit']))
	{
		echo "<h4 align='center' style='color:blue'><b>Search</b></h4></center>";
		form();
	}
	else if($_POST['submit'] && $_POST['search'])
	{
		search();
	}
	else
	{
		echo "<h3 align='center' style='color:red'><b>Please Enter The Field</b></h3></center>";
		form();
	}
?>
<?php
function form()
{
	echo "<table align='center'><tr><td><input type='text' name='search'/></td><td>
	<input type='submit' value='Search' name='submit'/></td></tr></table>";
}

function search()
{
	$f=0;
	$s=$_POST['search'];
	include 'db.php';
	//consumable item 
	$sql="SELECT * FROM consumable WHERE type LIKE '%$s%' OR category LIKE '%$s%' OR 
	subcat LIKE '%$s%' OR description LIKE '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) > 0)
	{
		$f=1;
		print "<h3 style='color:red' align='center'>Consumable Items</h3>";
		echo "<table border='1' align='center' id='edittab' ><tr><th>Component</th>
		<th>Category</th><th>Sub Category</th><th>Description</th>";
		echo "<th>Quantity</th><th>Consumed Quantity</th><th>Price</th><th>Purchase Date</th>
		<th>Manufacturer</th><th>Reference No.</th></tr>";
		
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'>
				<td><u><a href='issue_comp_details.php?id=".$row[0]."'>".$row[1]."</a></u></td>
				<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
				echo "<td>".$row[5]."</td><td>".$row[15]."</td><td>".$row[6]."</td><td>".$row[7]."</td>
				<td>".$row[11]."</td><td>".$row[12]."</td></tr>";
			}
			else
			{
				echo "<tr><td><u><a href='issue_comp_details.php?id=".$row[0]."'>".$row[1]."</a></u></td>
				<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
				echo "<td>".$row[5]."</td><td>".$row[15]."</td><td>".$row[6]."</td><td>".$row[7]."</td>
				<td>".$row[11]."</td><td>".$row[12]."</td></tr>";
			}
		$v++;
		}
	echo "</table><br/><br/>";
	}
	//capital items
	$sql="SELECT * FROM capital WHERE name LIKE '%$s%' OR category LIKE '%$s%' OR description LIKE '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) > 0)
	{
		$f=1;
		print "<h3 style='color:red' align='center'>Capital Items</h5>";
		echo "<table border='1' align='center' id='edittab' ><tr><th>Item Name</th>
		<th>Category</th><th>Description</th><th>Supplier</th>";
		echo "</th><th>Bill No.</th><th>Unit Price</th><th>Purchase Date</th><th>Warranty</th>
		<th>Manufacturer</th><th>Reference No.</th><th>Status</th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>
				<td>".$row[4]."</td>";
				echo "<td>".$row[6]."</td><td>".$row[5]."</td><td>".$row[10]."</td><td>".$row[9]."</td>
				<td>".$row[8]."</td><td>".$row[7]."</td><td>".$row[14]."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>
				<td>".$row[4]."</td>";
				echo "<td>".$row[6]."</td><td>".$row[5]."</td><td>".$row[10]."</td><td>".$row[9]."</td>
				<td>".$row[8]."</td><td>".$row[7]."</td><td>".$row[14]."</td></tr>";
			}
		$v++;
		}
	echo "</table><br/><br/>";	
	}
	//student
	$sql="SELECT * FROM student WHERE name LIKE '%$s%' OR roll LIKE '%$s%' OR course LIKE '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) > 0)
	{
		$f=1;
		print "<h3 style='color:red' align='center'>Student</h5>";
		echo "<table border='1' align='center'id='edittab' ><tr><th>Roll No.</th><th>Name</th>
		<th>Course</th><th>Email</th><th>Phone</th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td>
				<td>".$row[3]."</td><td>".$row[4]."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
				echo "<td>".$row[4]."</td></tr>";
			}
		$v++;
		}
		echo "</table><br/><br/>";
	}
	
	//faculty
	$sql="SELECT * FROM faculty WHERE name LIKE '%$s%' OR id LIKE '%$s%' OR lab LIKE '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) > 0)
	{
		$f=1;
		print "<h3 style='color:red' align='center'>Faculty</h5>";
		echo "<table border='1' align='center' id='edittab' ><tr><th>ID</th><th>Name</th>
		<th>Lab in charge</th><th>Email</th><th>Phone</th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td>
				<td>".$row[3]."</td><td>".$row[4]."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
				echo "<td>".$row[4]."</td></tr>";
			}
		$v++;
		}
		echo "</table><br/><br/>";
	}
	
	//staff
	$sql="SELECT * FROM staff WHERE name LIKE '%$s%' OR id LIKE '%$s%' OR lab LIKE '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) > 0)
	{
		$f=1;
		print "<h3 style='color:red' align='center'>Staff</h5>";
		echo "<table border='1' align='center' id='edittab' ><tr><th>ID</th><th>Name</th>
		<th>Lab in charge</th><th>Email</th><th>Phone</th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{
				echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td>
				<td>".$row[3]."</td><td>".$row[4]."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
				echo "<td>".$row[4]."</td></tr>";
			}
		$v++;
		}
		echo "</table>";
	}
	if($f==0)
	{
		//print "<br/><h3 style='color:red' align='center'>No data found</h5>";
		//<br><button type="button" onclick="history.back();">Back</button>		
		echo "<script>alert('No Data Found!')";
			echo "</script>";
	}
	echo "<br><center>
		<input type=button value='Back to search' onclick=window.location.href='word_searchf.php' ></input>";
		echo "</center>";
}
?>

</form>
</body>
</html>