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
<form action="edit_staff_details.php" method="POST" onLoad="_top">
<?php
	if(isset($_POST['rpwd']))
	{
		resetpwd();
	}
	else if(!isset($_POST['update']))
	{
		print "<h3 align='center' style='color:blue'><b>Edit Faculty </b></h3><br>";
		$name=$_GET['name'];
		$_SESSION['editsname']=$_GET['name'];
		searchform($name);
	}
	else if($_POST['update'] && $_POST['phone'] && $_POST['name'] && $_POST['email'])
	{
		update();
	}
	else
	{
		$name=$_SESSION['editsname'];
		print "<h3 align='center' style='color:red'>Marked fields are compulsory</h3>";
		searchform($name);
	}
// starting of search form....
function searchform($name)
{
include 'db.php';//database file

	$sql="select * from staff where name='$name'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 1)
	{
		$row=mysql_fetch_array($result);
		echo "<b><table align='center'><tr><td>
		Name of Staff:</td><td><input type='text' value='".$row['name']."' name='name'>
		</input></td><td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
		echo "<tr><td>Staff ID:</td><td>
		<input type='text' value='".$row['id']."' disabled='disabled' name='id'></input></td></tr>";
		echo "<tr><td>Lab in Charge </td><td><input type='text' value='".$row['lab']."' 
		disabled ='disabled' name='lab' style='width:170px;'>";
		echo "<tr><td>Email ID:</td><td>
		<input type='text' value='".$row['email']."' name='email' ></input></td>
		<td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
		echo "<tr><td>Phone:</td><td>
		<input type='text' value='".$row['phone']."'  name='phone'></input></td>
		<td style='color:red;font-size:15pt;'><b>*<b></td></tr>";
		
		echo "<tr><td><input type='submit' name='update' value='Update'></input></td><td><input type='submit'
		name='rpwd' value='Reset Password'></input></td></tr>";
		
	}
	else
	{
			echo "<table border='1' align='center'id='edittab' ><tr><th>Faculty ID</th><th>Name</th>
			<th>Lab in Charge</th><th>Email</th><th>Phone</th><th></th></tr>";
			$v=1;
			while($row = mysql_fetch_array($result))
			{
				if(($v%2)==0)
				{	
					echo "<tr class='alt'><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".
					$row[3]."</td><td>".$row[4]."</td>";
		            echo "<td><a href='edit_staff_det.php?id=".$row['id']."'>Edit</a></td></tr>";
				}
				else
				{
					echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3].
					"</td><td>".$row[4]."</td>";
				    echo "<td><a href='edit_staff_det.php?id=".$row['id']."'>Edit</a></td></tr>";
				}
				$v++;
			}
			print("</table>");
	}
}

function update()
{
	$name=$_SESSION['editsname'];
	$phone=$_POST['phone'];
	$name=$_POST['name'];
	$email=$_POST['email'];
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{	
		$phone = $_POST['phone'];
		if(preg_match('/^\d{10}$/',$phone))
		{
			include 'db.php';
			$sql="select * from staff where name='$name'";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$id=$row['id'];
			$sql1="update staff set name='$name',email='$email',phone='$phone' where id='$id'";
			$result1=mysql_query($sql1);
			if($result1)
			print "<br/><h3 align='center' style='color:red'>Updated Successfully</h3><br>";
			//echo "<br><button type='button' onclick='history.go(-2);'>Back</button>";
			header("Refresh:1;url=edit_staff.php");
		}
		else
		{
			echo "<h4 align='center' style='color:red'>Invalid phone number</h4>";
			searchform($name);
		}
	}
	else
	{
		echo "<h4 align='center' style='color:red'>Invalid Email-ID </h4>";
		searchform($name);
	}

}

function resetpwd()
{
	$name=$_SESSION['editsname'];
	include 'db.php';
	$query="select * from staff where name='$name'";
	$res=mysql_query($query);
	$abc=mysql_fetch_array($res);
	$id=$abc['id'];
	$query1="update login set pass='$id' where uid='$id'";
	$res1=mysql_query($query1);
	echo "<br><center><h4 style='color:red'>Reset Successfully</h4></center><br>";
	header("Refresh:1;url=edit_staff.php");
}
?>
</form>
</body>
</html>