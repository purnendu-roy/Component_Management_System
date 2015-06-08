<?php
include 'admin.php';
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	
	if(!isset($_SESSION['auth']))
		header("Location:index.php");
	
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
			width:80%;
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
</head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>cms</title>
<body>
<form action="issue_no_dues_lab.php" method="POST" onLoad="_top">
<?php
	if(!isset($_POST['submit']))
	{
		echo "<h3 align='center' style='color:grey'>Check No Dues</h3>";
		form();
	}
	else if($_POST['submit'] && $_POST['lab'])
	{
		check();
	}
	else
	{
		echo "<h3 align='center' style='color:red'>Please Select Lab</h3>";
		form();
	}
?>
<?php
function form()
{
	echo "<table align='center'><tr><td>Select Lab :</td>";
	include 'db.php';
		$sql = " SELECT name from labs";
		$result = mysql_query($sql);
		echo "<td><select name='lab'><option></option>";
		while($row = mysql_fetch_array($result))
		{
			echo "<option >".$row['name']."</option>";
		}
		echo "</select></td>";
	echo "</td><td><input type='submit' name='submit' value='GO'></input></td></tr>"; 
}
function check()
{
		$labname=$_POST['lab'];
		include 'db.php';
		
		//faculty issue_no_dues_lab...... DISTINCT uid 
		
		$sql="SELECT * FROM user_issue_consumable where utype='Faculty'";
		$result=mysql_query($sql);
		//$raw=mysql_fetch_array($result);
		//$utyp=$raw['utype'];
		
						
		if(mysql_num_rows($result) >0)
		{
			print "<br/><h3 style='color:red' align='center'>Components Issued from ".$labname."</h5>";
			echo "<br/><table border='1' align='center' id='edittab'><tr><th>No</th>
			<th>ID</th><th>Name</th><th>Lab</th><th>Type</th><th>Category</th><th>Sub Category</th>
			<th>Description</th><th>Quantity</th><th>Issue Date</th><th>Return Date</th>";
			
			$v=1;
			$no=1;
	
			while($row = mysql_fetch_array($result))
			{
				$rno=$row['uid'];
				$cid=$row['cid'];
				
				$f1="select * from faculty where id='$rno'";
				$resf1=mysql_query($f1);
				$resfac=mysql_fetch_array($resf1);
				$facname=$resfac['name'];
				$lab1=$resfac['lab'];		
				
				$sql2="SELECT * FROM consumable WHERE id='$cid'";
				$result2=mysql_query($sql2);
				$row2=mysql_fetch_array($result2);
				$type=$row2['type'];
				$cat=$row2['category'];
				$sub=$row2['subcat'];
				$des=$row2['description'];
				
			 if($labname == $lab1)
			 {
				if(($v%2)==0)
				{	
					echo "<tr class='alt'><td>".$no."</td><td>".$rno."</td>";
					echo "<td>".$facname."</td><td>".$labname."</td>";
					echo "<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td>
					<td>".$cat."</td><td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$no."</td><td>".$rno."</td>";
					echo "<td>".$facname."</td><td>".$labname."</td>";
					echo "<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td>
					<td>".$cat."</td><td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
				$v++;
				$no++;
			 }
			}
		}
		else
			print "<br/><h3 style='color:red' align='center'>Not Found!</h5>";
		
		//student issue_no_dues_lab......
		/*$a1="select * from request_issue where utype='Student'";
		$r1=mysql_query($a1);
	 if( mysql_num_rows($result) >0 )
	 {
			print "<br/><h3 style='color:red' align='center'>Components Issued from ".$labname."</h5>";
			echo "<br/><table border='1' align='center' id='edittab'><tr><th>No</th>
			<th>ID</th><th>Name</th> <th>Guide</th><th>Req. To</th><th>Type</th><th>Category</th>
			<th>Sub Category</th><th>Description</th><th>Quantity</th><th>Issue Date</th><th>Return Date</th>";
			
			$v=1;
			$no=1;
			
			while($row = mysql_fetch_array($result))
			{
				$rno=$row['uid'];
				echo $rno;
				$cid=$row['cid'];
				$idate=$row['idate'];
				//echo $idate;
				
				//request issue
				$r2=mysql_fetch_array($r1);
				$c1=$r2['status'];
				$guide=$r2['gname'];
				$b1='Approved';
				echo $guide;
				
				$f1="select * from faculty where id='$rno'";
				$resf1=mysql_query($f1);
				$resfac=mysql_fetch_array($resf1);
				$facname=$resfac['name'];
				//echo $facname;
				$id1=$resfac['id'];
				$lab1=$resfac['lab'];		
				
				$sql1="SELECT * FROM student WHERE roll='$rno'";
				$result1=mysql_query($sql1);
				$row1=mysql_fetch_array($result1);
				$name=$row1['name'];
				
				$sql2="SELECT * FROM consumable WHERE id='$cid'";
				$result2=mysql_query($sql2);
				$row2=mysql_fetch_array($result2);
				$type=$row2['type'];
				$cat=$row2['category'];
				$sub=$row2['subcat'];
				$des=$row2['description'];
				
			 	if(($v%2)==0)
				{	
					echo "<tr class='alt'><td>".$no."</td><td>".$rno."</td>";
					echo "<td>".$name."</td><td>".$facname."</td><td>".$labname."</td>";
					echo "<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td>
					<td>".$cat."</td><td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
				else
				{
					echo "<tr><td>".$no."</td><td>".$rno."</td>";
					echo "<td>".$name."</td><td>".$facname."</td><td>".$labname."</td>";
					echo "<td><a href='issue_comp_details.php?id=".$cid."'>".$type."</a></td>
					<td>".$cat."</td><td>".$sub."</td><td>".$des."</td><td>".$row['quantity']."</td>
					<td>".$row['idate']."</td><td>".$row['rdate']."</td></tr>";
				}
				$v++;
				$no++;
			 }
			
	 }*/
		
}
?>
</form>
</body>
</html>