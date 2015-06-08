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
	}
	#edittab tr.alt td 
	{
	color:#000000;
	background-color:#EAF2D3;
	}
	</style>
</head>
<body>
<br>
<form action="edit_faculty_details.php" method="POST" onLoad="_top">
<?php
	if(isset($_POST['rpwd']))
	{
		resetpwd();
	}
	else if(isset($_POST['delete']))
	{
		delete();
	}
	else if(!isset($_POST['update']))
	{
		print "<h3 align='center' style='color:grey'><b>Edit Faculty </b></h3><br>";
		$name=$_GET['name'];
		$_SESSION['editfname']=$_GET['name'];
		searchform($name);
	}
	else if($_POST['update'] && $_POST['phone'])
	{
		update();
	}
	else
	{
		$name=$_SESSION['editfname'];
		print "<br/><h3 align='center' style='color:red'>Marked fields are compulsory</h3><br>";
		searchform($name);
	}

function searchform($name)
{
include 'db.php';
	$sql="SELECT * FROM faculty WHERE name='$name'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 1)
	{
	$row=mysql_fetch_array($result);
	echo "<b><table align='center'><tr><td>
	Name of Faculty:</td><td><input type='text' value='".$row['name']."'disabled='disabled'></input></td></tr>";
	echo "<tr><td>Faculty ID:</td><td>
	<input type='text' value='".$row['id']."' disabled='disabled' name='id'></input></td></tr>";
	echo "<tr><td>Lab in Charge </td><td><select name='lab' style='width:173px;'>";
	echo "<option></option>";
	
	$con = mysql_connect('localhost', 'root' , 'shanoo');//database connection
	mysql_select_db('test123', $con);
	$sql1 = " SELECT name from labs";
	$result1 = mysql_query($sql1);
	while($row1 = mysql_fetch_array($result1))
	{
		echo "<option >".$row1['name']."</option>";
	}
	//echo "</select></td>";
	echo "<tr><td>email:</td><td>
	<input type='text' value='".$row['email']."' disabled='disabled'></input></td></tr>";
	echo "<tr><td>Phone:</td><td>
	<input type='text' value='".$row['phone']."' name='phone'></input></td><td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
	echo "<tr><td><input type='submit' name='update' value='Update'></input></td>
	<td><input type='submit' name='delete' value='Delete'></input>
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='submit' name='rpwd' value='Reset Password'></input></td></tr>";
	}
	
	else
	{
echo "<table border='1' align='center'id='edittab' ><tr><th>Faculty ID</th><th>Name</th><th>Lab in Charge</th><th>Email</th><th>Phone</th><th></th></tr>";
		$v=1;
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
		echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
		echo "<td><a href='edit_faculty_det.php?id=".$row['id']."'>Edit</a></td></tr>";
			}
			
			else
			{
				echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
				echo "<td><a href='edit_faculty_det.php?id=".$row['id']."'>Edit</a></td></tr>";
			}
			$v++;
		}
		print("</table>");
	}
}

function update()
{
	$name=$_SESSION['editfname'];
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
		//echo "<br><button type='button' onclick='history.go(-2);'>Back</button>";
		header("Refresh:1;url=edit_faculty.php");
	}
	else
	{
		//echo "<h4 align='center' style='color:red'>Invalid phone number</h4>";
		echo "<script>alert('Error! Invalid Phone Number')</script>";
		searchform($name);
	}


}

function delete()
{
	$name=$_SESSION['editfname'];
	include 'db.php';
	$sql1="SELECT * FROM faculty WHERE name='$name'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	$id=$row1['id'];
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
			$q=$row4['quant'];
			$cid=$row4['cid'];
			$rid=$row4['id'];
			$sql5="SELECT * from consumable where id='$cid'";
			$result5=mysql_query($sql5);
			$row5=mysql_fetch_array($result5);
			$aq=$row5['quantity'];
			$quant=$q+$aq;
			$sql6="UPDATE consumable SET quantity='$quant' where id='$cid'";
			$result6=mysql_query($sql6);
			$sql7="DELETE FROM request_issue where id='$rid'";
			$result7=mysql_query($sql7);
		}
		$sql8="DELETE FROM request_component WHERE uid='$id'";
		$result8=mysql_query($sql8);
		echo "<br/><h3 style='color:red' align='center'>Deleted Successfully</h3>";
echo "<br/><center/><input type=button value='back' onclick=window.location.href='edit_faculty.php'></input>";

	}
	else
	{
		echo "<script>alert('Error! You can\'t delete this this faculty\(dues not cleared\)')</script>";
		header("Refresh:1;url=edit_faculty.php");
	}
	//echo "<br/><center/><h3 style='color:red'>Error...Cannot delete this faculty ( Dues not cleared )</h3>";
 //echo "<br/><center/><input type=button value='back' onclick=window.location.href='edit_faculty.php'></input>";
	//header("Refresh:1;url=edit_faculty.php");
	//echo "<br><button type='button' onclick='history.back();'>Back</button>";
}

function resetpwd()
{
	$name=$_SESSION['editfname'];
	include 'db.php';
	$sql1="SELECT * FROM faculty WHERE name='$name'";
	$result1=mysql_query($sql1);
	$row1=mysql_fetch_array($result1);
	$id=$row1['id'];
	$sql6="UPDATE login SET pass='$id' where uid='$id'";
	$result6=mysql_query($sql6);
	echo "<br><center><h4 style='color:red' align='center'>Reset Successfully</h4></center><br>";
	header("Refresh:2;url=edit_faculty.php");
}
?>
</form>
</body>
</html>