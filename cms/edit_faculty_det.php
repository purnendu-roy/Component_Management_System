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
<form action="edit_faculty_det.php" method="POST" onLoad="_top">
<?php
	if(isset($_POST['rpwd']))
	{
		resetpwd();
	}
	else if(isset($_POST['delete']))
	{
		delete();
	}
	else if(!isset($_POST['submit']))
	{
		print "<br/><h3 align='center' style='color:red'>Edit Faculty </h3><br>";
		$id=$_GET['id'];
		$_SESSION['editfid']=$_GET['id'];
     	searchform($id);
	}
	else if($_POST['submit'] && $_POST['phone'])
	{
		update();
	}
	else
	{
		$name=$_SESSION['editfid'];
		print "<br/><h3 align='center' style='color:red'>Marked fields are compulsory</h3><br>";
		searchform($id);
	}

function searchform($id)
{
include 'db.php';
	$sql="SELECT * FROM faculty WHERE id='$id'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
echo "<table align='center'><tr><td>Name of Faculty</td><td><input type='text' value='".$row['name']."' disabled='disabled'></input></td></tr>";
echo "<tr><td>Faculty ID</td><td><input type='text' value='".$row['id']."' disabled='disabled' name='fid'></input></td></tr>";
echo "<tr><td>Lab in Charge </td><td><select name='lab' style='width:173px;'>";
echo "<option></option>";
$con = mysql_connect('localhost', 'root','shanoo');
mysql_select_db('cms', $con);
$sql1 = " SELECT name from labs";
$result1 = mysql_query($sql1);
while($row1 = mysql_fetch_array($result1))
{
	echo "<option >".$row1['name']."</option>";
}
echo "</select></td></tr>";
echo "<tr><td>email</td><td><input type='text' value='".$row['email']."' disabled='disabled'></input></td></tr>";
echo "<tr><td>Phone</td><td><input type='text' value='".$row['phone']."' name='phone'></input></td><td><h3 style='color:red'> * </h3></tr>";
echo "<tr><td><input type='submit' name='submit' value='Update'></input></td><td><input type='submit' name='delete' value='Delete'></input>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='submit' name='rpwd' value='Reset Password'></input></td></tr>";
}

function update()
{
	$name=$_SESSION['editfid'];
	if(isset($_POST['lab']))
		$lab=$_POST['lab'];
	else
		$lab='';
	$phone=$_POST['phone'];
	if(preg_match('/^\d{10}$/',$phone))
	{
		include 'db.php';
		$sql="UPDATE faculty SET lab='$lab', phone='$phone' WHERE name='$name'";
		$result=mysql_query($sql);
		if($result)
		print "<br/><h3 align='center' style='color:red'>Updated Successfully</h3><br>";
		header("Refresh:1;url=edit_faculty.php");
	}
	else
	{
		echo "<h4 align='center' style='color:red'>Invalid phone number</h4>";
		searchform($id);
	}


}

function delete()
{
	$id=$_SESSION['editfid'];
	include 'db.php';
	$sql="SELECT * FROM user_issue_consumable WHERE uid='$id'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
		$sql2="DELETE FROM faculty WHERE id='$id'";
		$result2=mysql_query($sql2);
		$sql3="DELETE FROM login WHERE uid='$id'";
		$result3=mysql_query($sql3);
		$sql4="SELECT * FROM request_issue WHERE uid='$id'";
		$result4=mysql_query($sql4);
		while($row4=mysql_fetch_array($result4))
		{
			$q=$row['quant'];
			$cid=$row['cid'];
			$sql5="SELECT * from component where id='$cid'";
			$result5=mysql_query($sql5);
			$row5=mysql_fetch_array($result5);
			$aq=$row5['quantity'];
			$quant=$q+$aq;
			$sql6="UPDATE component SET quantity='$quant' where 	id='$cid'";
			$result6=mysql_query($sql6);
			$sql7="DELETE FROM request_issue where id='$id'";
			$result7=mysql_query($sql7);
		}
		$sql8="DELETE FROM request_component WHERE uid='$id'";
		$result8=mysql_query($sql8);
		echo "<br><h4 style='color:red'>Deleted Successfully<br>";

	}
	else
	echo "<br><h4 style='color:red'>Error...Cannot delete this faculty ( Dues not cleared )<br>";

	header("Refresh:1;url=edit_faculty.php");
}

function resetpwd()
{
	$id=$_SESSION['editfid'];
	include 'db_connect.php';
	$sql6="UPDATE login SET pass='$id' where uid='$id'";
	$result6=mysql_query($sql6);
	echo "<br><h4 style='color:red'>Done....</h4><br>";
	
	header("Refresh:1;url=edit_faculty.php");
}
?>
</form>
</div>
</body>
</html>