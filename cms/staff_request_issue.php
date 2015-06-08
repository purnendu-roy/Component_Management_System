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
<html>
<head> 
	<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
	<link rel="stylesheet" type="text/css" media = "all" href="css/styles.css"/>
	<style type="text/css">
		#edittab
		{
			font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
			width:70%;
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
		<script>
function getSearch(str)
 {
 if (str=="")
   {
	document.getElementById("sub").hidden=true;

   document.getElementById("searchform").innerHTML="";
   return;
   } 

if (str=="Resistor")
   {
   document.getElementById("sub").hidden=true;
   }
if (str=="Capacitor")
   {
   document.getElementById("sub").hidden=true;
   }
if (str=="Inductor")
   {
   document.getElementById("sub").hidden=true;
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
     document.getElementById("searchform").innerHTML=xmlhttp.responseText;
     }
   }
 xmlhttp.open("GET","get_user_search.php?q="+str,true);
 xmlhttp.send();
 }
 </script>
<script>
function getSubcat(str)
 {
var cat=document.myForm.type.value;
 if (str=="")
   {
   document.getElementById("sub").innerHTML="";
   return;
   } 
if (cat=="Semi Conductor")
   {
   document.getElementById("sub").hidden=false;
   }
else
{
	   document.getElementById("sub").hidden=false;
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
document.getElementById("sub").innerHTML=xmlhttp.responseText;
     }
   }
 xmlhttp.open("GET","get_user_subsearch.php?q="+str,true);
 xmlhttp.send();
 }
 </script>
</head>
<body>
<form action="staff_request_issue.php" method="POST" onLoad="_top" name="myForm" id="myForm">
<?php
include 'staff.php';
if(!isset($_POST['component']))
{
	print "<h3 align='center' style='color:grey'><b><u/>Issue Consumable Items</b> </h3>";
    addform();
}
else if($_POST['component'] )
{
	searchData();
}
else
{
	print "<h3 align='center' style='color:red'><b>Issue Consumable Items</b> </h3>";
   	addform();
}
?>
<?php
//adding a form 

function addform()
{
		echo "<b><table align='center'><tr><td>Component :</td>";
		echo "<td><select name='component' id='type' onchange='getSearch(this.value)'><option></option>";
		include 'db.php';
		$sql="select category from major_cat order by id";
		$res=mysql_query($sql);
		while($row = mysql_fetch_array($res))
		{
			echo "<option>".$row['category']."</option>";
		}
		echo "<select></td></tr></table><br>";
		echo "<table align='center' id='searchform'>
		<table align='center' id='sub'></table></table>";
}

// search data for staff
function searchData()
{
	$type = $_POST['component'];
	$maincat = $_POST['maincat'];
	
	if(isset($_POST['subcat']))
		$subcat = $_POST['subcat'];
	else
		$subcat='';
	
	if(isset($_POST['f1']))
		$f1 = $_POST['f1'];
	else
		$f1='';
	if(isset($_POST['f2']))
		$f2 = $_POST['f2'];
	else
		$f2='';
	if(isset($_POST['f3']))
		$f3 = $_POST['f3'];
	else
		$f3='';
	if(isset($_POST['f4']))
		$f4 = $_POST['f4'];
	else
		$f4='';
	if(isset($_POST['f5']))
		$f5 = $_POST['f5'];
	else
		$f5='';
	if(isset($_POST['f6']))
		$f6 = $_POST['f6'];
	else
		$f6='';
	if(isset($_POST['f7']))
		$f7 = $_POST['f7'];
	else
		$f7='';
	if(isset($_POST['f8']))
		$f8 = $_POST['f8'];
	else
		$f8='';
	if(isset($_POST['f9']))
		$f9 = $_POST['f9'];
	else
		$f9='';
	if(isset($_POST['f10']))
		$f10 = $_POST['f10'];
	else
		$f10='';
	
	$manu = $_POST['manu'];
	
	include 'db.php';
	
	$sql="SELECT * FROM consumable WHERE type LIKE '%$type%' AND category LIKE '%$maincat%' AND 
	subcat LIKE '%$subcat%' AND f1 LIKE '%$f1%' AND f2 LIKE '%$f2%' AND f3 LIKE '%$f3%' AND 
	f4 LIKE '%$f4%' AND f5 LIKE '%$f5%' AND f6 LIKE '%$f6%' AND manufacturer LIKE '%$manu%' AND 
	f7 LIKE '%$f7%' AND f8 LIKE '%$f8%' AND f9 LIKE '%$f9%' AND f10 LIKE '%$f10%'";
	
	$result=mysql_query($sql);
	if(mysql_num_rows($result) == 0)
	{
			print "<br/><h3 style='color:red' align='center'>No Data Found</h5>";
			addform();
	}
	else
	{
		print "<br/><h3 style='color:red' align='center'>Search Results</h3>";

		$row=mysql_fetch_array($result);
		$specid=$row['specid'];
		$sql1="SELECT * FROM specification where id='$specid'";
		$result1=mysql_query($sql1);
		$row1=mysql_fetch_array($result1);
		echo "<table border='1' align='center' id='edittab' ><tr><th>Component</th><th>Category</th>
		<th>Sub Category</th><th>Description</th>";
		
		if(!empty($row1['f1']))
			echo "<th>".$row1['f1']."</th>";
		if(!empty($row1['f2']))
			echo "<th>".$row1['f2']."</th>";
		if(!empty($row1['f3']))
			echo "<th>".$row1['f3']."</th>";
		if(!empty($row1['f4']))
			echo "<th>".$row1['f4']."</th>";
		if(!empty($row1['f5']))
			echo "<th>".$row1['f5']."</th>";
		if(!empty($row1['f6']))
			echo "<th>".$row1['f6']."</th>";
		if(!empty($row1['f7']))
			echo "<th>".$row1['f7']."</th>";
		if(!empty($row1['f8']))
			echo "<th>".$row1['f8']."</th>";
		if(!empty($row1['f9']))
			echo "<th>".$row1['f9']."</th>";
		if(!empty($row1['f10']))
			echo "<th>".$row1['f10']."</th>";
		
		echo "</th><th>Quantity</th><th>Manufacturer</th><th></th></tr>";
		
		$v=1;
		
		$sql="SELECT * FROM consumable WHERE type LIKE '%$type%' AND category LIKE '%$maincat%' AND 
		subcat LIKE '%$subcat%' AND f1 LIKE '%$f1%' AND f2 LIKE '%$f2%' AND f3 LIKE '%$f3%' AND 
		f4 LIKE '%$f4%' AND f5 LIKE '%$f5%' AND f6 LIKE '%$f6%' AND manufacturer LIKE '%$manu%' AND 
		f7 LIKE '%$f7%' AND f8 LIKE '%$f8%' AND f9 LIKE '%$f9%' AND f10 LIKE '%$f10%'";
		
		$result=mysql_query($sql);
		
		while($row = mysql_fetch_array($result))
		{
			if(($v%2)==0)
			{	
				echo "<tr class='alt'><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td>
				<td>".$row[4]."</td>";
				
				if(!empty($row1['f1']))
					echo "<td>".$row['f1']."</td>";
				if(!empty($row1['f2']))
					echo "<td>".$row['f2']."</td>";
				if(!empty($row1['f3']))
					echo "<td>".$row['f3']."</td>";
				if(!empty($row1['f4']))
					echo "<td>".$row['f4']."</td>";
				if(!empty($row1['f5']))
					echo "<td>".$row['f5']."</td>";
				if(!empty($row1['f6']))
					echo "<td>".$row['f6']."</td>";
				if(!empty($row1['f7']))
					echo "<td>".$row['f7']."</td>";
				if(!empty($row1['f8']))
					echo "<td>".$row['f8']."</td>";
				if(!empty($row1['f9']))
					echo "<td>".$row['f9']."</td>";
				if(!empty($row1['f10']))
					echo "<td>".$row['f10']."</td>";
				
				echo "<td>".$row[5]."</td><td>".$row[11]."</td>
				<td><a href='staff_confirm_issue.php?id=".$row[0]."&quantity=".$row[5]."'>Issue</a></td></tr>";
			}
			else
			{
				echo "<tr><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td>";
				
				if(!empty($row1['f1']))
					echo "<td>".$row['f1']."</td>";
				if(!empty($row1['f2']))
					echo "<td>".$row['f2']."</td>";
				if(!empty($row1['f3']))
					echo "<td>".$row['f3']."</td>";
				if(!empty($row1['f4']))
					echo "<td>".$row['f4']."</td>";
				if(!empty($row1['f5']))
					echo "<td>".$row['f5']."</td>";
				if(!empty($row1['f6']))
					echo "<td>".$row['f6']."</td>";
				if(!empty($row1['f7']))
					echo "<td>".$row['f7']."</td>";
				if(!empty($row1['f8']))
					echo "<td>".$row['f8']."</td>";
				if(!empty($row1['f9']))
					echo "<td>".$row['f9']."</td>";
				if(!empty($row1['f10']))
					echo "<td>".$row['f10']."</td>";
				
				echo "<td>".$row[5]."</td><td>".$row[11]."</td>
				<td><a href='staff_confirm_issue.php?id=".$row[0]."&quantity=".$row[5]."'>Issue</a></td></tr>";
			}
		$v++;
		}
	echo "</table>";
	}
}
?>
</form>
</body>
</html>
	