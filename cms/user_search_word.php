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
<form action="user_search_word.php" method="POST" onLoad="_top">
<?php
	if($_SESSION['auth']=='Student')
		include 'student.php';
	else if($_SESSION['auth']=='Faculty')
		include 'faculty.php';
	else
		include 'staff.php';
	
	if(!isset($_POST['submit']))
	{
		echo "<h4 align='center' ><u>Search</u></h4>";
		form();
	}
	else if($_POST['submit'] && $_POST['search'])
	{
		search();
	}
	else
	{
		echo "<h4 align='center' style='color:red'>Please Enter Some Text</h4>";
		form();
	}
	
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
		$sql="SELECT * FROM consumable WHERE type LIKE '%$s%' OR category LIKE '%$s%' OR
		subcat LIKE '%$s%' OR description LIKE '%$s%'";
	$result=mysql_query($sql);
	//echo $result;
	//echo "asdfjlksdjf";
	if(mysql_num_rows($result) > 0)
	{
		$f=1;
		print "<br/><h3 style='color:red' align='center'>Consumable Items</h5>";
		echo "<table border='1' align='center' id='edittab' ><tr><th>Component</th>
		<th>Category</th><th>Sub Category</th><th>Description</th>";
		echo "</th><th>Quantity</th><th>Manufacturer</th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'>
				<td>".$row[1]."</td>
				<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
				echo "<td>".$row[5]."</td><td>".$row[11]."</td></tr>";
			}
			else
			{
				echo "<tr><td>".$row[1]."</td>
				<td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
				echo "<td>".$row[5]."</td><td>".$row[11]."</td></tr>";
			}
			$v++;
		}
		echo "</table><br/>";
	//echo "<br><input type=button value='back' onclick=window.location.href='user_search_word.php'></input>";
	}
	
	$sql="SELECT * FROM capital WHERE name LIKE '%$s%' OR category LIKE '%$s%' OR description LIKE '%$s%'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) > 0)
	{
		$f=1;
		echo "<h3 align='center' style='color:red'><u>Capital Items</u></h3>";
		echo "<table border='1' align='center' id='edittab'><tr><th>Item Name</th>";
		echo "<th>Category</th><th>Description</th><th>Quantity</th><th>Bill No.</th><th>Manufacturer</th>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
				{
					echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
					echo "<td>".$row[12]."</td><td>".$row[6]."</td><td>".$row[8]."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>";
					echo "<td>".$row[12]."</td><td>".$row[6]."</td><td>".$row[8]."</td></tr>";
				}
				$v++;
		}
		echo "</table>";	
	//echo "<br><input type=button value='back' onclick=window.location.href='user_search_word.php'></input>";
	}
	
	if($f==0)
	{
		echo "<script>alert('No Data Found!')";
			echo "</script>";
		//echo "<h4 style='color:red' align='center'>No Data Found</h4><br><center/>";
		//<button type="button" onclick="history.back();">Back</button>
//echo "<br><input type=button value='back' onclick=window.location.href='user_search_word.php'></input>";
	}
	echo "<center/>";
	echo "<br><input type=button value='back to Search' onclick=window.location.href='user_search_word.php'>
	</input>";
}
?>
</form>
</body>
</html>
