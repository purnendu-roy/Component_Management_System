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
<form action="edit_student_details.php" method="POST" onLoad="_top">
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
		print "<h3 align='center' style='color:blue'><b>Edit Student </b></h3><br>";
		$roll_no=$_GET['roll'];
		$_SESSION['editsroll']=$_GET['roll'];
		//$_SESSION['phone']=$_GET['phone'];
		searchform($roll_no);
	}
	else if($_POST['update'] && $_POST['phone'])
	{
		$_SESSION['phone']=$_POST['phone'];
		update();
	}
	else
	{
		$roll_no=$_SESSION['editsroll'];
		print "<br/><h3 align='center' style='color:red'>Marked fields are compulsory</h3><br>";
		searchform($roll_no);
	}

function searchform($roll_no)
{
include 'db.php';
	$sql="select * from student where roll='$roll_no'";
	$result=mysql_query($sql);
	
	$row=mysql_fetch_array($result);
	echo "<b><table align='center'><tr><td>
	Name of Student:</td><td><input type='text' value='".$row['name']."'disabled='disabled'></input></td></tr>";
	echo "<tr><td>Roll No.:</td><td>
	<input type='text' value='".$row['roll']."' disabled='disabled' ></input></td></tr>";
	echo "<tr><td>Course</td><td><input type='text' value='".$row['course']."' disabled='disabled'>
	</input></td></tr>";
	echo "<tr><td>email</td><td><input type='text' value='".$row['email']."'  disabled='disabled'>
	</input></td></tr>";
	echo "<tr><td>Phone:</td><td>
	<input type='text' value='".$row['phone']."' name='phone'></input>
	</td><td style='color:red ;font-size:15pt;'><b>*<b></td></tr>";
	echo "<option></option>";

	echo "<tr><td><input type='submit' name='update' value='Update'></input></td>
	<td><input type='submit' name='delete' value='Delete'></input>
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type='submit' name='rpwd' value='Reset Password'></input></td></tr>";
}
	
function update()
{
	$roll_no=$_SESSION['editsroll'];
	$phone=$_SESSION['phone'];
	
	if(preg_match('/^\d{10}$/',$phone))
	{
		include 'db.php';
		$sql="update student set phone='$phone' where roll='$roll_no'";
		$result=mysql_query($sql);
		if($result)
		print "<br/><h3 align='center' style='color:red'>Updated Successfully</h3><br>";
		//echo "<br><button type='button' onclick='history.go(-2);'>Back</button>";
		header("Refresh:1;url=edit_student.php");
	}
	else
	{
		echo "<h4 align='center' style='color:red'>Invalid phone number</h4>";
		searchform($roll_no);
	}
}

function delete()
{
	$roll_no=$_SESSION['editsroll'];
	include 'db.php';
	$sql="SELECT * FROM user_issue_consumable WHERE uid='$roll_no'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
		$sql4="SELECT * FROM request_issue WHERE uid='$roll_no'";
		$result4=mysql_query($sql4);
		
		while($row4=mysql_fetch_array($result4))
		{
			$q=$row4['quant'];
			$cid=$row4['cid'];
			$id=$row4['id'];
			$sql5="SELECT * from component where id='$cid'";
			$result5=mysql_query($sql5);
			$row5=mysql_fetch_array($result5);
			$aq=$row5['quantity'];
			$quant=$q+$aq;
			$sql6="UPDATE component SET quantity='$quant' where id='$cid'";
			$result6=mysql_query($sql6);
			$sql7="DELETE FROM request_issue where id='$id'";
			$result7=mysql_query($sql7);
		}
		$sql8="DELETE FROM request_component WHERE uid='$roll_no'";
		$result8=mysql_query($sql8);
		$sql2="DELETE FROM student WHERE roll='$roll_no'";
		$result2=mysql_query($sql2);
		$sql3="DELETE FROM login WHERE uid='$roll_no'";
		$result3=mysql_query($sql3);
		echo "<br><h4 style='color:red'>Deleted Successfully<br>";
		
		//echo "<br><button type='button' onclick='history.back();'>Back</button>";
		header("Refresh:1;url=edit_student.php");
	}
	else
	{
		echo "<br><h4 style='color:red'>Error...Cannot delete this Student ( Dues not cleared )<br>";
		header("Refresh:2;url=edit_student.php");
	}
	
	//echo "<br><button type='button' onclick='history.back();'>Back</button>";

}

function resetpwd()
{
	$roll_no=$_SESSION['editsroll'];
	include 'db.php';
	$s="select * from student where roll='$roll_no'";
	$r=mysql_query($s);
	$row=mysql_fetch_array($r);
	$sql6="update login set pass='$roll_no' where uid='$roll_no'";
	$result6=mysql_query($sql6);
	echo "<br><h4 style='color:red'><center>".$row['name']."'s passowrd has reset</center></h4><br>";
	header("Refresh:1;url=edit_student.php");
}
?>
</form>
</body>
</html>