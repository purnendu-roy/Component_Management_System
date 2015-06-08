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
</head>
<body>
<div id="center_addtext"><br>
<form action="add_new_category.php" method="POST" onLoad="_top">
<?php
		if(!isset($_POST['newcat']))
		{
			print "<br><br><h4 align='center' style='color:#4682B4'><b>Enter The Following Details</b></h4>";
			addform();
		}
		else if($_POST['newcat'] && $_POST['type'])
		{
			addData();
		}
		else
		{
			print "<br><br><h4 align='center' style='color:red'><b>Please Enter The Following Details</b></h4>";
			addform();
		}

	function addform()
	{
		echo "<b> <table align='center'>";
		echo "<tr><td>Select Component:</td>
		<td><select name='type' onchange='getCategory(this.value)' style='width:173px;'><option></option>";
		include 'db.php';
		$sql="select category from major_cat order by id";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result))
		{
			$val=$row['category'];
			echo "<option value='$val'>";
			echo $val;
			echo "</option>";
		}
		echo "</select></td></tr>";	
		echo "<tr><td>Enter New Category:</td><td><input type=text name='newcat'></td></tr>";
		echo "<tr><td><br><input type='submit' name='add' value='Add' id='submit'></input></td>
				<td><br><input type='reset' name='reset' value='Reset'></input></td></tr>";

		echo "</table>";
	}
?>
<?php
function addData()
{
include 'db.php';

	$cat=$_POST['newcat'];
	$type=$_POST['type'];
	
	$sql="select id from main_cat";
	$res=mysql_query($sql);
	$id=mysql_num_rows($res);
	$id=$id+1;
	
	$sql="select id from major_cat where category='$type'";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$refno=$row['id'];
	
	$sql="insert into main_cat values('$id','$refno','$cat')"; // insert in to main category
	$res=mysql_query($sql);
	if($type=='Semi Conductor' || $type=='Others') // if both are equal to the type category sc and others.
	{
		header("location:add_sc_spec.php?category=$cat"); // it will open add semiconductor specification page
	}

	echo "<br/><h3 align='center' style='color:red;'>Added Successfully</h3>";
	//header("Refresh:1;url=add_consumable_item.php"); // it will open add consumable item page
	echo "<script>window.location = 'add_consumable_item.php';</script>";
}
?>
</form>
</div>
</body>
</html>