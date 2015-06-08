<html>
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>getuser_search</title>
</head>
<body>
<?php
	$q=$_GET["q"];
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	$_SESSION['catsearch']=$q;
	include 'db.php';
	
	$sql = " SELECT distinct main_cat.category FROM main_cat,major_cat WHERE major_cat.category = '$q'
	and major_cat.id=main_cat.refno_maj";
	
	$result = mysql_query($sql);
	if($q!='Semi Conductor' && $q!='Others')
	{
		echo "<tr><td>Select Category :</td>";
		echo "<td><select name='maincat' onchange='getSubcat(this.value)' style='width:172px;'>
		<option></option>";
		
		while($row = mysql_fetch_array($result))
		{
			echo "<option>".$row['category']."</option>";
		}
		echo "</select></tr>";
		echo "<tr><td>Select Sub Category</td><td><select name='subcat' id='sub' style='width:172px;'>
		</select></td></tr>";

		$sql = "SELECT * FROM specification where category='$q'";
		$res = mysql_query($sql);
		$count=mysql_num_rows($res);
		if($count==1)
		{	
			$row=mysql_fetch_array($res);
			
			if(!empty($row['f1']))
			{	echo "<tr><td>".$row['f1'].":</td><td><input type='text' name='f1'></td></tr>";
				$_SESSION['specs']=1;
			}
			if(!empty($row['f2']))
			{	echo "<tr><td>".$row['f2'].":</td><td><input type='text' name='f2'></td></tr>";
				$_SESSION['specs']=2;

			}
			if(!empty($row['f3']))
			{	echo "<tr><td>".$row['f3'].":</td><td><input type='text' name='f3'></td></tr>";
				$_SESSION['specs']=3;

			}
			if(!empty($row['f4']))
			{	echo "<tr><td>".$row['f4'].":</td><td><input type='text' name='f4'></td></tr>";
				$_SESSION['specs']=4;
			}
			if(!empty($row['f5']))
			{
				echo "<tr><td>".$row['f5'].":</td><td><input type='text' name='f5'></td></tr>";
				$_SESSION['specs']=5;
			}
			if(!empty($row['f6']))
			{
				echo "<tr><td>".$row['f6'].":</td><td><input type='text' name='f6'></td></tr>";
				$_SESSION['specs']=6;
			}
			if(!empty($row['f7']))
			{	echo "<tr><td>".$row['f7'].":</td><td><input type='text' name='f7'></td></tr>";
				$_SESSION['specs']=7;

			}
			if(!empty($row['f8']))
			{	echo "<tr><td>".$row['f8'].":</td><td><input type='text' name='f8'></td></tr>";
				$_SESSION['specs']=8;
			}
			if(!empty($row['f9']))
			{
				echo "<tr><td>".$row['f9'].":</td><td><input type='text' name='f9'></td></tr>";
				$_SESSION['specs']=9;
			}
			if(!empty($row['f10']))
			{
				echo "<tr><td>".$row['f10'].":</td><td><input type='text' name='f10'></td></tr>";
				$_SESSION['specs']=10;
			}

			echo "<tr><td>Manufacturer :</td><td><input type='text' name='manu'></td></tr>";
			echo "<tr><td><input type='submit' Value='Search'></td>";
			echo "<td><input type='reset' Value='Reset'></td></tr>";
		}
	}
	else
	{
		if($q=='Semi Conductor' || $q=='Others')
		{	
			echo "<tr><td>Select Category :";
			echo "<select name='maincat' onchange='getSubcat(this.value)' style='width:172px;'>
			<option></option>";
			while($row = mysql_fetch_array($result))
			{
				echo "<option>".$row['category']."</option>";
			}
			echo "</select></tr>";	
		}

	}
?>
</body>
</html>
