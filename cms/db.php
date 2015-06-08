<?php
$con=mysql_connect("localhost","root","shanoo");

if(!$con)
{
	die('could not connect :'.mysql_error());
}
else
{
	mysql_select_db("test123",$con);
}
?>