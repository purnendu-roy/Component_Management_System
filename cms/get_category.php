<html>
<body>
<form onLoad="_top">
<?php
	$q=$_GET["q"];
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	}
	$_SESSION['category']=$q;
	include 'db.php';
	
	$sql="select distinct main_cat.category from main_cat ,  major_cat where major_cat.category='$q' and 
	major_cat.id=main_cat.refno_maj";
	$result = mysql_query($sql);
	if($q!='Semi Conductor' && $q!='Others' )
	{
		echo "<tr><td>Select Category :</td><td><select name='maincat' onchange='getSubcat(this.value)'
		style='width:173px;'><option></option>";

		while($row = mysql_fetch_array($result))
		{
			echo "<option>".$row['category']."</option>";
		}

		echo "</select><td><a href='add_new_category.php'>New Category</a></td></tr>";// new category
		echo "<tr><td>Select Sub Category:</td><td><select name='subcat' id='sub' style='width:173px;'>
		</select></td>";
		echo "<td><a href='add_new_subcategory.php'>New Sub Category</a></td></tr>"; // new sub category


		$sql = "SELECT * FROM specification where category='$q'";
		$res = mysql_query($sql);
		$count=mysql_num_rows($res);
		if($count==1)
		{	
			echo "<tr><td>Description :</td><td><input type='text' name='des'></td></tr>";
			$row=mysql_fetch_array($res);
			
			if(!empty($row['f1']))
			echo "<tr><td>".$row['f1'].":</td><td><input type='text' name='f1'></td></tr>";
		
			if(!empty($row['f2']))
				echo "<tr><td>".$row['f2'].":</td><td><input type='text' name='f2'></td></tr>";
			
			if(!empty($row['f3']))
				echo "<tr><td>".$row['f3'].":</td><td><input type='text' name='f3'></td></tr>";

			if(!empty($row['f4']))
				echo "<tr><td>".$row['f4'].":</td><td><input type='text' name='f4'></td></tr>";

			if(!empty($row['f5']))
				echo "<tr><td>".$row['f5'].":</td><td><input type='text' name='f5'></td></tr>";

			if(!empty($row['f6']))
				echo "<tr><td>".$row['f6'].":</td><td><input type='text' name='f6'></td></tr>";
			
			if(!empty($row['f7']))
				echo "<tr><td>".$row['f7'].":</td><td><input type='text' name='f7'></td></tr>";
			
			if(!empty($row['f8']))
				echo "<tr><td>".$row['f8'].":</td><td><input type='text' name='f8'></td></tr>";
			
			if(!empty($row['f9']))
				echo "<tr><td>".$row['f9'].":</td><td><input type='text' name='f9'></td></tr>";

			if(!empty($row['f10']))
				echo "<tr><td>".$row['f10'].":</td><td><input type='text' name='f10'></td></tr>";

			echo "<tr><td>Quantity :</td><td><input type='text' name='quant'></td></tr>";
			
			echo "<tr><td>Price (Rs) :</td><td><input type='text' name='price'></td></tr>";

			echo "<tr><td>Purchase Date :</td><td><input type=date name='pdate' style='width:168px;'>
			</td><td>(DD/MM/YYYY)</td></tr>";
			echo "<tr><td>Entry Date :</td><td><input type=date name='edate' style='width:168px;'>
			</td><td>(DD/MM/YYYY)</td></tr>";
			
			echo "<tr><td>Supplier :</td><td><input type='text' name='supplier'></td></tr>";
			echo "<tr><td>Manufacturer :</td><td><input type='text' name='manu'></td></tr>";
			echo "<tr><td>Bill No. :</td><td><input type='text' name='bno'></td></tr>";

			if(isset($_SESSION['caprefno']))
			{
				print ("<tr><td>Reference No. :</td><td><input type='text' name='refno' 
				value='".$_SESSION['caprefno']."'></input></td>");
				
				unset($_SESSION['caprefno']);
			}
			else
			{
				print ("<tr><td>Reference No. :</td><td><input type='text' name='refno'></input></td>");
			}
			echo "<tr><td>Alert Level :</td><td><input type='text' name='alert'></td></tr>";
			//Submit button and reset button
			echo "<tr><td><input type='submit' Value='Submit'></td>";
			echo "<td><input type='reset' Value='Reset'></td></tr>";
		}
		
		else
		{
			header("location:addspec.php?category=$q");
		}
			
	}
	if($q=='Semi Conductor' || $q=='Others')
	{
		echo "<tr><td>Select Category :<select name='maincat' onchange='getSubcat(this.value)'>
		<option></option>";

		while($row = mysql_fetch_array($result))
		{
			echo "<option>".$row['category']."</option>";
		}
		
		echo "</select><a href='add_new_category.php'>New Category</a></td></tr>";

	}
?>
</body>
</html>
