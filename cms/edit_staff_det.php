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
	<style type="text/css">
	#customers
	{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	width:104%;
	border-collapse:collapse;
	}
	#customers td, #customers th 
	{
	font-size:1em;
	border:1px solid #98bf21;
	padding:3px 7px 2px 7px;
	}
	#customers th 
	{
	font-size:1.1em;
	text-align:left;
	padding-top:5px;
	padding-bottom:4px;
	background-color:#4E9CE9;
	color:#ffffff;
	}
	#customers tr.alt td 
	{
	color:#000000;
	background-color:#EAF2D3;
	}
	</style>
	
</head>
<body>
<div id="center_addtext"><br>
<form action="edit_staff_det.php" method="POST" onLoad="_top">
<?php
	
	if(!isset($_POST['submit']))
	{
		print "<br/><h3 align='center' style='color:red'>Edit Staff </h3><br>";
		$id=$_GET['id'];
		$_SESSION['editsid']=$_GET['id'];
     	searchform($id);
	}
	else if($_POST['submit'] && $_POST['phone'] && $_POST['name'])
	{
		update();
	}
	else
	{
		$name=$_SESSION['editsid'];
		print "<br/><h3 align='center' style='color:red'>Marked fields are compulsory...</h3><br>";
		searchform($id);
	}

function searchform($id)
{
	include 'db.php';
	$sql="select * from staff where id='$id'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
	echo "<table align='center'><tr><td>Name of Staff</td>
	<td><input type='text' value='".$row['name']."' name='name'></input></td>
	<td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
	
	echo "<tr><td>Staff ID</td><td><input type='text' value='".$row['id']."' disabled='disabled' 
	name='sid'></input></td></tr>";

	echo "<tr><td>Lab in Charge </td><td>
	<input type='text' value='".$row['lab']."' style='width:170px;'disabled='disabled'></input></td></tr>";
	
	echo "<tr><td>email</td><td><input type='text' value='".$row['email']."'
	disabled='disabled'></input></td></tr>";
	
	echo "<tr><td>Phone</td><td><input type='text' value='".$row['phone']."' name='phone'></input></td>
	<td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
	
	echo "<tr><td><input type='submit' name='submit' value='Update'></input></td></tr>";

}

function update()
{
	$id=$_SESSION['editsid'];
	$name=$_POST['name'];
	$phone=$_POST['phone'];
	include 'db.php';
	$sql="update staff set name='$name', phone='$phone' where id='$id'";
	$result=mysql_query($sql);
	if($result)
		print "<br/><h3 align='center' style='color:red'>Updated Successfully</h3><br>";
	header("Refresh:1;url=edit_staff.php");
}

?>
</form>
</div>
</body>
</html>