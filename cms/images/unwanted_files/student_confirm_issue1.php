<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['auth']))
		header("Location:index.php");
	if($_SESSION['auth']!='Student')
	{
		session_destroy();
		header("Location:index.php");	
	}
?>
<html>
<head> 
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
	<style type="text/css"/>
</head>
<body>
<form action="student_confirm_issue.php" method="POST" onLoad="_top">
<?php
	include 'student.php';
	include 'db.php';
	if(!isset($_POST['quantity']))
	{	
		print "<br><h3 align='center' style='color:grey'>Please Enter Required Quantity</h3><br>";
		
		if(isset($_GET["id"]))
		{
			$_SESSION['issuecid']=$_GET["id"];
			$_SESSION['issuequant']=$_GET["quantity"];
		}
		
		form($_SESSION['issuecid'],$_SESSION['issuequant']);
	}
	else if($_POST['quantity'] && $_POST['pname']  && $_POST['gname'])
	{
		issue();
	}
	else
	{
		print "<h3 style='color:red' align='center'>Please enter the quantity</h3>";
		form($_SESSION['issuecid'],$_SESSION['issuequant']);
	}
?>
<?php
function form($cid,$quant)
{
	echo "<table align='center'><tr>
	<td>Enter Quantity:</td><td><input type='text' name='quantity'></input></td>
	<td style='color:red'>(".$quant." Available)</tr>";
	echo "<tr><td>Project Name:</td><td><input type='text' name='pname'></input></td></tr>";
	echo "<tr><td>Guide Name:</td><td><select name='gname' style='width:174px'><option></option>";
	
	include 'db.php';
	$sql="SELECT name FROM faculty";
 	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
   	{
		echo "<option>".$row['name']."</option>";
   	}
	echo "</select>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	echo "<tr><td><input type='submit' value='Submit'></input></td>";
	echo "<td><input type='reset' value='Clear'></input></td></tr></table>";
}

function issue()
{
	$quant=$_POST['quantity'];
	$pname=$_POST['pname'];
	$gname=$_POST['gname'];
	$cid=$_SESSION['issuecid'];
	$aquant=$_SESSION['issuequant'];

	if($quant>$aquant)
	{
		echo "<br><h3 style='color:red'>Error!. Only ".$aquant." Quantities are avilable</h3><br>";
		echo "<br><button type='button' onclick='history.go(-1);'>Back</button>";
	}
	else
	{
		include 'db.php';
		
		$sql="select MAX(id) AS id from request_issue";
		$res=mysql_query($sql);
		$row = mysql_fetch_array($res);
		$id=$row['id'];
		$id=$id+1;
		
		$uid=$_SESSION['user'];
		$utype=$_SESSION['auth'];
		$rd = date("d/m/Y");
		$status='Pending';
		$sql="INSERT INTO request_issue values('$id','$uid','$utype','$cid','$quant','$pname','$gname','$rd','
		$status')";
		
		$result=mysql_query($sql);
		if($result)
		{
			echo "<h3 style='color:red' align='center'>Issue Request Successful</h3>";
			$q=$aquant-$quant;
			$sql="UPDATE consumable SET quantity='$q' WHERE id='$cid'";
			$result=mysql_query($sql);
		}
		//echo "<br><button type="button" onclick="location.href = 'student.php';">Back</button>";
		echo "<br><input type=button value='back' onclick=window.location.href='student.php' ></input>";
	}
}
?>
</form>
</body>
</html>