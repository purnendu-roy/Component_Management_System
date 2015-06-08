<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	if(!isset($_SESSION['auth']))
		header("Location:index.php");
	if($_SESSION['auth']!='Staff')
	{
		session_destroy();
		header("Location:index.php");	
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
 


function display(str)
 {
 if (str=="")
   {
   document.getElementById("quan").innerHTML="";
   return;
   } 
 if (window.XMLHttpRequest)
   {// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
   }
 else
   {// code for IE6, IE5
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
 xmlhttp.onreadystatechange=function()
   {
   if (xmlhttp.readyState==4 && xmlhttp.status==200)
     {
     document.getElementById("quan").innerHTML=xmlhttp.responseText;
     }
   }
 xmlhttp.open("GET","get_quan.php?q="+str,true);
 xmlhttp.send();
 }
 </script>
 
 <meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>CMS</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<form action="staff_request_purchase.php" method="POST" onLoad="_top">
<?php
include 'staff.php';

if(!isset($_POST['pname']))
{
	print "<h3 align='center' style='color:grey'>Please enter the following details</h3>";
   	form();
}
else if($_POST['pname'] && $_POST['gname'] && $_POST['cname'] && $_POST['des']  && $_POST['ctype'] )
{
	request();
}
else
{
	print "<h3 align='center' style='color:red'>Marked fields are compulsory</h3>";
    form();
}
?>
<?php
function form()
{
	echo "<table align='center' style='color:black'><tr><td>Project Name : </td>";
	echo "<td><input type='text' name='pname'></input>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	//echo "</td><td><h1 style='color:red'>*</h1></td>";
	echo "<tr><td>Faculty-In-Charge : </td><td><select name='gname' style='width:173px'><option></option>";
	
	$uid=$_SESSION['user'];
	include 'db.php';
	
	$sql="SELECT lab FROM staff where id='$uid'";
 	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	$lab=$row['lab'];
	$sql="SELECT name FROM faculty where lab='$lab'";
 	$result=mysql_query($sql);
	while($row = mysql_fetch_array($result))
   	{
   		echo "<option>".$row['name']."</option>";
   	}
	echo "</select>&nbsp;<font color='red' size='4px'/><b/>*</td>";
	echo "</tr><tr><td>Name of Component : </td><td>";
	echo "<input type='text' name='cname'></input>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	echo "<tr><td>Component Type:</td>";
	echo "<td><select name='ctype' onchange='display(this.value)' style='width:173px'>
	<option value='Capital'>Capital</option>
	<option value='Consumable'>Consumable</option>
	</select>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	echo "<tr><td>Description :</td><td><textarea name='des' cols='19' rows='3' style='width:173px'></textarea>
	<font color='red' size='4px'/><b/>*</td></tr>";
	echo "<tr id='quan'>";
	echo "<tr><td>Manufacturer(if known):</td><td><input type='text' name='manu'></input></td>";
	echo "<tr><td>";
	echo "<tr><td>Part Number(if known):</td><td><input type='text' name='part'></input></td>";
	echo "<tr><td>";
	echo "<tr><td>Required By:</td>";
	echo "<td>
		<select name='required' style='width:173px'>
			<option>3 Month</option>
			<option>1-3 Month</option>
			<option>Within 1 Month</option>
		</select>&nbsp;<font color='red' size='4px'/><b/>*</td></tr>";
	echo "<tr><td>";
	echo "<tr><td>";
	echo "<input type='submit' name='add' value='Submit' id='submit'></input></td>";
	echo "<td><input type='reset' name='reset' value='Reset'></input></td><td>";
	echo "<input type=button value='back' onclick=window.location.href='staff.php'></input></td></tr></table>";	
}

	
function request()
{
		include 'db.php';
		$sql="select MAX(id) AS id from request_component";
		$res=mysql_query($sql);
		$row = mysql_fetch_array($res);
		$id=$row['id'];
		$id=$id+1;
		$uid=$_SESSION['user'];
		$utype='Staff';
		$pname=$_POST['pname'];
		$gname=$_POST['gname'];
		$cname=$_POST['cname'];
		$ctype=$_POST['ctype'];
		$des=$_POST['des'];
		
		if(isset($_POST['quant']))
			$quant=$_POST['quant'];
		else
			$quant=1;
			$manu=$_POST['manu'];
			$pno=$_POST['part'];
			$rby=$_POST['required'];
			$rdate = date("d/m/Y");
			$status='Pending';
	
	$sql="INSERT INTO request_component values('$id','$uid','$utype','$pname','$cname','$ctype','$gname',
	'$des','$quant','$manu','$pno','$rby','$rdate','$status','')";
	
	$result=mysql_query($sql);
	if($result)
	{
		//echo "<h4  style='color:red' align='center'>Added Successfully</h4>";
		echo "<h4 align='center' style='color:red'><b>Added Successfully</b>
		<img src='images/added.png' style='position: absolute; top: 217px; left:530px; z-index: -1;'></h4>";
		echo "<br/><center/><input type=button value='back' onclick=window.location.href='staff.php' ></input>";
	}
	else
	{	
		echo "<script>alert('Error!')";
		echo "</script>";
		form();
	}
}
?>
</form>
</body>
</html>