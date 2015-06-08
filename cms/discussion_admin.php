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
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
	<style>
		#edittab
		{
		font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
		width:50%;
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
	<script>
</script>
</head>
<body>
<form action="discussion_admin.php" method="POST" onLoad="_top" name="myForm" id="myForm">
<?php
	if(!isset($_POST['delete']))
	{
		//echo "<h3 style='color:grey' align='center'>Admin discussion section</h3>";
		form();
	}
	else if($_POST['delete'] && $_POST['query'])
	{
		del();
	}
	else
	{
		//echo "<h3 style='color:red' align='center'>Please Enter Query Number</h3>";
		form();
	}

	function form()
	{
		//list of discussion panel
		echo "<br/><br/><h3 style='color:grey' align='center'>List of Discussion</h3>";
		include "db.php";
		$result=mysql_query("select * from discussion");
		echo "<table  align='center' id='edittab'><tr><th>Query No.</th><th>ID</th>
		<th>Name</th><th>Suggestion</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class='alt'><td>".$row['qno']."</td><td>".$row['id']."</td><td>".$row['name']."</td>
			<td>".$row['suggestion']."</td></tr>";
		}
		echo "</table><br/><br/>";
		
		// delete query section
		//echo "<h3 style='color:grey' align='center'>Delete Query</h3>";
		echo "<br/><table align='center' border='2' id='edittab'>";
		echo "<tr><td>Delete Query Number</td><td><input type='text' name='query' size='50'></td></tr>";
		echo "</table>";
		echo "<br/><center/><input type='submit' name='delete' value='delete'/>";
		echo "<input type='reset' name='reset' value='clear'/>";
	}
?>

<?php
	function del()
	{
		include "db.php";
		$query=$_POST['query'];
		$result=mysql_query("SELECT * FROM discussion WHERE qno='$query'");
		$count=mysql_num_rows($result);
		if($count==1)
		{
			mysql_query("delete from discussion WHERE qno='$query'");
			echo "<script> alert('Query Successfully Deleted')</script>";
			echo "<script>window.location = 'discussion_admin.php';</script>";
		}
		else
		{
			echo "<script> alert('incorrect information')</script>";
			echo "<script>window.location = 'discussion_admin.php';</script>";
			
		}
	}
?>
</form>
</body>
</html>
