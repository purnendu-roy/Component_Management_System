<html>
<body>
<?php
	$q=$_GET["q"];
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	$c=$_SESSION['catsearch'];
	include 'db.php';
	
	$sql= "SELECT major_cat.category, major_cat.id FROM main_cat,major_cat 
	WHERE main_cat.category = '$q' and main_cat.refno_maj=major_cat.id";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$p=$row['category'];
	$id=$row['id'];
	
	$sql = "SELECT distinct sub_cat.category FROM sub_cat,main_cat,major_cat WHERE main_cat.category = '$q'
	and main_cat.id=sub_cat.refno_mn and sub_cat.refno_maj=major_cat.id and major_cat.category='$c'";
	$result = mysql_query($sql);
	if($p=='Semi Conductor' || $p=='Others')
	{	
		$sql = "SELECT * FROM specification where category='$q'";
		$res = mysql_query($sql);
		$count=mysql_num_rows($res);
		if($count==1)
		{	
			echo "<tr><td>Sub Category</td><td><select name='subcat' style='width:172px;'><option></option>";
			while($row = mysql_fetch_array($result))
			{
				echo "<option>".$row['category']."</option>";
			}
		
			echo "</select></td></tr>";
			$row=mysql_fetch_array($res);
			if(!empty($row['f1']))
				echo "<br/><tr><td>".$row['f1'].":</td><td><input type='text' name='f1'></td></tr>";
			if(!empty($row['f2']))
				echo "<br/><tr><td>".$row['f2'].":</td><td><input type='text' name='f2'></td></tr>";
			if(!empty($row['f3']))
				echo "<br/><tr><td>".$row['f3'].":</td><td><input type='text' name='f3'></td></tr>";
			if(!empty($row['f4']))
				echo "<br/><tr><td>".$row['f4'].":</td><td><input type='text' name='f4'></td></tr>";
			if(!empty($row['f5']))
				echo "<br/><tr><td>".$row['f5'].":</td><td><input type='text' name='f5'></td></tr>";
			if(!empty($row['f6']))
				echo "<br/><tr><td>".$row['f6'].":</td><td><input type='text' name='f6'></td></tr>";
			if(!empty($row['f7']))
				echo "<tr><td>".$row['f7'].":</td><td><input type='text' name='f7'></td></tr>";
			if(!empty($row['f8']))
				echo "<tr><td>".$row['f8'].":</td><td><input type='text' name='f8'></td></tr>";
			if(!empty($row['f9']))
				echo "<tr><td>".$row['f9'].":</td><td><input type='text' name='f9'></td></tr>";
			if(!empty($row['f10']))
				echo "<tr><td>".$row['f10'].":</td><td><input type='text' name='f10'></td></tr>";
			echo "<br/><tr><td>Manufacturer :</td><td><input type='text' name='manu'></td></tr>";
			echo "<br/><tr><td><input type='submit' value='Search'></td>
			<td><input type='reset' value='Reset'></td></tr>";

		}
		else
		{
			header("location:addspec.php?category=$q");
		}
	}
	else
	{
		echo "<option> </option>";
		while($row = mysql_fetch_array($result))
		{
			echo "<option>".$row['category']."</option>";
		}
	}
?>
</body>
</html>

