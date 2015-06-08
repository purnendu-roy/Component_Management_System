<?php
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
<body>
<?php
	if(!isset($_POST['f1']))
	{
		$c=$_GET['category'];
		echo "<h4 align='center' style='green;'>Specifications of ".$c.":</h4>";
		form();
	}
	else
	{
		print "<h5 align='center'>Please enter the following details</h5>";
     	form();
	}
	
function form()
{
		echo "<table >
		<tr>
		<td>Spec 1 : </td>
		<td><input type='text' name='s1' size='30'></td>
		</tr>
		<tr>
		<td>Spec 2 : </td>
		<td><input type='text' name='s2' size='30'></td>
		</tr>
		<tr>
		<td>Spec 3 : </td>
		<td><input type='text' name='s3' size='30'></td>
		</tr>
		<tr>
		<td>Spec 4 : </td>
		<td><input type='text' name='s4' size='30'></td>
		</tr>
		<tr>
		<td>Spec 5 : </td>
		<td><input type='text' name='s5' size='30'></td>
		</tr>
		<tr>
		<td>Spec 6 : </td>
		<td><input type='text' name='s6' size='30'></td>
		</tr>
		<tr>
		<td>Spec 7 : </td>
		<td><input type='text' name='s7' size='30'></td>
		</tr>
		<tr>
		<td>Spec 8 : </td>
		<td><input type='text' name='s8' size='30'></td>
		</tr>
		<tr>
		<td>Spec 9 : </td>
		<td><input type='text' name='s9' size='30'></td>
		</tr>
		<tr>
		<td>Spec 10 : </td>
		<td><input type='text' name='s10' size='30'></td>
		</tr>
		<tr>
		<td><br><input type='submit' name='Add' Value='Submit'></td>
		<td><input type='Reset' name='Reset'></td>
		</tr>
		</table>";
}
?>
</body>
</html>
