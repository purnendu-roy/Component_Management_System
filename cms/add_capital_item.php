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
	<!--<link rel="stylesheet" type="text/css" media = "all" href="css/jquery-ui.css"/>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
	$(function()
	{
		$( "#datepicker" ).datepicker({changeMonth: true, changeYear: true,});
		$( "#datepicker" ).datepicker( "option", "showAnim", "slideDown");
		$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy");
		
	});
	</script>-->
</head>
<body>
<form action="add_capital_item.php" method="POST" onLoad="_top">
<?php
		if(!isset($_POST['ename']))
		{
			print "<br><br><h4 align='center' style='color:#4682B4'><b>Add Capital Items</b></h4>";
			addform();
		}
		else if($_POST['ename'] && $_POST['maincat'] && $_POST['price'] && $_POST['pdate'] && $_POST['edate'])
		{
			addData();
		}
		else
		{
			print "<br><br><h4 align='center' style='color:red'><b>Please enter the following details</b></h4>";
			addform();
		}

	function addform()
	{
		include "db.php";
		$result=mysql_query("select name from labs");
		
		print("<b> <table align='center'>
		<tr><td>Equipment Name:</td><td><input type='text' name='ename'></input></td>
		<tr><td>Category : </td><td><input type='text' name='maincat' ></td></tr>
		<tr><td>Description:</td><td><input type='text' name='des'></input></td>
		<tr><td>Supplier :</td><td><input type='text' name='supplier'></input></td>
		<tr><td>Unit Price:</td><td><input type='text' name='price'></input></td>
		<tr><td>Bill No. :</td><td><input type='text' name='billno'></input></td>");
		if(isset($_SESSION['caprefno']))
		{
			print ("<tr><td>Reference No.:</td>
			<td><input type='text' name='refno' value='".$_SESSION['caprefno']."'></input></td>");
			unset($_SESSION['caprefno']);
		}
		else
		{
			print ("<tr><td>Reference No. :</td><td><input type='text' name='refno'></input></td>");
		}
		print ("<tr><td>Manufacturer:</td><td><input type='text' name='manu'></input></td></tr>
				<tr><td>Warranty :</td><td><input type='text' name='warranty'></input></td></tr>");
				
		/*echo "<tr><td>Lab:</td><td><select name='lab' style='width:173px'><option></option>";
		while($row=mysql_fetch_array($result))
		{
			echo "<option>".$row['name']."</option>";
		}
		echo "</select></td></tr>";*/
		
		echo "<tr><td>Purchase Date:</td>
		<td><input type='date' name='pdate' style='width:168px;'></input></td></tr>
		<tr><td>Entry Date:</td><td><input type='date' name='edate' style='width:168px;'></input></td></tr>
		<tr><td>Quantity:</td><td><input type='text' name='quantity'></input></td></tr>";
		echo "<tr><td><br><input type='submit' name='add' value='Add' id='submit'></input>
		<td><br><input type='reset' name='reset' value='Reset'></input></tr>";
		print("</td></table>");
	}
?>
<?php
function addData()
{
include 'db.php';

	$sql="select id from capital";
	$res=mysql_query($sql);
	$id=0;
	while($row = mysql_fetch_array($res))
	{
		$id=$row['id'];
	}
	$id=$id+1;
	$ename = $_POST['ename'];
	$maincat = $_POST['maincat'];
	$des = $_POST['des'];
	$supplier = $_POST['supplier'];
	$uprice = $_POST['price'];
	$bno = $_POST['billno'];
	$refno = $_POST['refno'];
	$manu = $_POST['manu'];
	$warranty = $_POST['warranty'];
	//$lab = $_POST['lab'];
	$pdate = $_POST['pdate'];
	$edate = $_POST['edate'];
	$quantity= $_POST['quantity'];
	$tamount= $uprice * $quantity; //calculating total amount unit_price*quantity
	$status='Available';
	
	//query for inserting capital items
	/*$sql="INSERT INTO capital values('$id','$ename','$maincat','$des','$supplier','$uprice','$bno','$refno',
	'$manu','$warranty','$lab','$pdate','$edate','$quantity','$tamount','$status','')";*/
	
	$sql="INSERT INTO capital values('$id','$ename','$maincat','$des','$supplier','$uprice','$bno','$refno',
	'$manu','$warranty','$pdate','$edate','$quantity','$tamount','$status','')";
	$result=mysql_query($sql);
	if($result)
	{
		echo "<h4 align='center' style='color:red'><b>Added Successfully</b></h4>";
		//header("refresh:1;add_capital_item.php");
		echo "<script>window.location = 'add_capital_item.php';</script>";
	}
	else
	{
		echo "<h4 align='center' style='color:red'><b>ID already exists</b></h4>";
		addform();
	}
}
?>
</form>
</body>
</html>