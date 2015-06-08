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
	<script>
		function getSubcat(str)
		 {
			 if (str=="")
			 {
				   document.getElementById("sub").innerHTML="";
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
					document.getElementById("sub").innerHTML=xmlhttp.responseText;
			   }
			 }
			 xmlhttp.open("GET","get_cat.php?q="+str,true);
			 xmlhttp.send();
		 }
    </script>
</head>
<body>
<div id="center_addtext"><br>
<form action="add_new_subcategory.php" method="POST" name="addsubcat" onLoad="_top">
<?php

		if(!isset($_POST['subcat']))
		{
			print "<br><br><h4 align='center' style='color:#4682B4'><b>Enter The Following Details</b></h4>";
			addform();
		}
		else if($_POST['maincat']  && $_POST['subcat'] && $_POST['category'])
		{
			add();
		}
		else
		{
			print "<br><br><h4 align='center' style='color:red'><b>Please Enter The Following Details</b></h4>";
			addform();
		}

	function addform()
	{
		echo "<b> <table align='center'>";
		echo "<tr><td>Category:</td>
		<td><select name='maincat' onchange='getSubcat(this.value)' style='width:173px;'>
		<option></option>";
		include 'db.php';
		
		$sql="select category from major_cat order by id";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result))
		{
			echo "<option>";
			echo $row['category'];
			echo "</option>";
		}
		echo "</select></td></tr>";	//end of the select category from major category
		
		echo "<tr><td>Select Category:</td>
		<td><select name='category'  id='sub' style='width:173px;'></select></td></tr>";
		echo "<tr><td>Enter Sub Category:</td><td><input type=text name='subcat'></input></td></tr>";
	
		echo "<tr></tr>";
		echo "<tr><td><br><input type='submit' name='add' value='Add' id='submit'></input></td>
				<td><br><input type='reset' name='reset' value='Reset'></input></td></tr>";
		echo "</table>";
	}
?>
<?php
function add()
{
include 'db.php';
	$refno_maj='';
	$refno_mn='';
	$subcat=$_POST['subcat'];
	$maincat=$_POST['category'];
	$type=$_POST['maincat'];
	
	$sql="select main_cat.id from main_cat, major_cat where main_cat.category='$maincat' and
	main_cat.refno_maj=major_cat.id and major_cat.category='$type'"; //selecting id from main_cat
	$res=mysql_query($sql);
	while($row = mysql_fetch_array($res))
	{
		$refno_mn=$row['id'];
		
	}
	
	$sql="select major_cat.id from major_cat where major_cat.category='$type'";
	$res=mysql_query($sql);
	while($row = mysql_fetch_array($res))
	{
		$refno_maj=$row['id'];
	}
	
	$sql="select id from sub_cat";
	$res=mysql_query($sql);
	$id=0;
	while($row = mysql_fetch_array($res))
	{
		$id=$row['id'];
	}
	$id=$id+1;
	//echo $refno_mn;
	//echo $refno_maj;
	$sql2="insert into sub_cat values('$id','$refno_mn','$refno_maj','$subcat')"; // insert in to sub category
	$result=mysql_query($sql2);
	if($result)
	{
		echo "<br/><h3 align='center' style='color:red;'>Added Successfully</h3>";
	}
	//header("Refresh:1;url=add_consumable_item.php");
	echo "<script>window.location = 'add_consumable_item.php';</script>";
		
}
?>
</form>
</div>
</body>
</html>