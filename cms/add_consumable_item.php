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
	function getCategory(str)
	{
		if (str=="")
		{
			document.getElementById("sub").hidden=true;
			document.getElementById("forms").innerHTML="";
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
				document.getElementById("forms").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","get_category.php?q="+str,true);
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
		xmlhttp.open("GET","get_subcategory.php?q="+str,true);
		xmlhttp.send();
	}

</script>
</head>
<body>

<form action="add_consumable_item.php" method="POST" onLoad="_top" name="myForm" id="myForm">
<?php
	if(!isset($_POST['component']))
	{
		echo "<h4 align='center' style='color:blue'><b>Add Consumable Items</b></h4></center>";
     	addform();
	}
	else if(isset($_POST['s1']))
	{
		addspec();
	}
	else if($_POST['component'] && $_POST['quant']&& $_POST['pdate'])
	{
		addData();
	}
	else
	{
		echo "<h4 align='center' style='color:red'><b>Please Enter The Following Details</b></h4></center>";
     	addform();
	}
?>
<?php
	//start add specification function
function addspec()
{
		include 'db.php';
		$s1=$_POST['s1'];
		$s2=$_POST['s2'];
		$s3=$_POST['s3'];
		$s4=$_POST['s4'];
		$s5=$_POST['s5'];
		$s6=$_POST['s6'];
		$s7=$_POST['s7'];
		$s8=$_POST['s8'];
		$s9=$_POST['s9'];
		$s10=$_POST['s10'];
			
		if($_POST['component']!='Semi Conductor' && $_POST['component']!='Others')
			$type = $_POST['component'];
		else
			$type= $_POST['maincat'];
		
		$sql1="select id from specification";
		$result1=mysql_query($sql1);
		$count=mysql_num_rows($result1);
		$id=$count+1;
		
		$sql2="insert into specification values('$id','$type','$s1','$s2','$s3','$s4','$s5','$s6','$s7','$s8','$s9','$s10')";
		$result2=mysql_query($sql2);
		if($result2)
			echo "<b><h4 align='center' style='color:red;'>Specifications of ".$type." added</b></h4>";
		else
			echo "Error";
		echo "<br><center>
		<input type=button onClick=location.href='admin.php' value='back' style=' width: 6em;  height:
		2.5em;'/></center>";
		//header("Refresh:1;url=admin.php");
}
?>
<?php
function addform()
{
	echo "<b><table align='center'><tr><td>Component:</td>";
	echo "<td><select name='component' id='type' onchange='getCategory(this.value)' style='width:173px;'>
	<option></option>";
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
	echo "<select></td></tr></table><br>";	
	echo "<table align='center' id='forms'>";
	echo "<table align='center' id='sub' >";
	echo "</table>";
	echo "</table>";	
}
?>
<?php
function addData()
{
include 'db.php';
	$sql="select max(id) as id from consumable";
	$res=mysql_query($sql);
	while($row = mysql_fetch_array($res))
		$id=$row['id'];
	$id=$id+1;
	
	$type = $_POST['component'];
	$maincat = $_POST['maincat'];
	$subcat = $_POST['subcat'];
	$des = $_POST['des'];
	
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

	$quant = $_POST['quant'];
	$price = $_POST['price'];
	$pdate = $_POST['pdate'];
	$edate = $_POST['edate'];
	$bno = $_POST['bno'];
	$supplier = $_POST['supplier'];
	$manu = $_POST['manu'];
	$refno = $_POST['refno'];
	$alert = $_POST['alert'];
	
	//$totalamt=$quant*$uprice;//total amount
	
	if($type!='Semi Conductor' && $type!='Others')
	{
		$sql3 = "SELECT id FROM specification where category='$type'";
		$res3 = mysql_query($sql3);
		$row3 = mysql_fetch_array($res3);
		$sid=$row3['id'];		
	}
	else
	{
		$sql4 = "SELECT id FROM specification where category='$maincat'";
		$res4 = mysql_query($sql4);
		$row4 = mysql_fetch_array($res4);
		$sid=$row4['id'];
	}
	//echo $id.$type.$maincat.$subcat.$des.$uprice.$quant.$pdate.$edate.$bno.$supplier;
$cq=0;
$sql2="insert into consumable values('$id','$type','$maincat','$subcat','$des','$quant','$price','$pdate','$edate','$bno','$supplier','$manu','$refno','$alert','$sid','$cq','$f1','$f2','$f3','$f4','$f5','$f6','$f7','$f8','$f9','$f10')";
	$result2=mysql_query($sql2);
	if($result2)
	{	
		$sql5 = "select max(id) as id from consum_details";
		$res5 = mysql_query($sql5);
		$row5 = mysql_fetch_array($res5);
		$id1=$row5['id'];
		$id1++;
		$sql6="insert into consum_details values('$id1','$id','$price','$quant','$pdate','$manu','$refno')";
		$res6 = mysql_query($sql6);	
		echo "<h4 align='center' style='color:red'><b>Added Successfully</b>
		<img src='images/added.png' style='position: absolute; top: 217px; left:530px; z-index: -1;'></h4>";
		echo "<br><center><input type=button onClick=location.href='admin.php' value='back'/></center>";
	}
	else
	{
		echo "<h5 align='center' style='color:red'><b>Error in Data!</b>
		<img src='images/error.gif' style='position: absolute; top: 200px; left: 700px;'></h4>";
		echo "<br><center><input type=button onClick=location.href='admin.php' value='back'/></center>";
		//addform();
	}
}
?>
</form>

</body>
</html>