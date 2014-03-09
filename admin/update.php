<?php
//First let's check if the file used to create the DB tables exists
$filename = '../blogsetup.php';
if (file_exists($filename)) 
{
   die("Warning: Please delete the blogsetup.php file before using your blog.");
}

//Some protection against hacking attempts...
define('IN_SITE' , true);

//Include required files
include ("../config.php");
include ("../db.php");

?>

<html>
<head>
<title><?php echo $cfg_blogtitle ?> - Control Panel</title>
<link rel="stylesheet" type="text/css" href="../<?php echo $cfg_cssfile ?>">
</head>

<body>


<div class="container">

<div class="header">
<?php echo $cgf_blogname ?> - Update an entry
</div>


<?php

$result = mysql_query ("SELECT * FROM php_blog WHERE id=$id") or print ("Can't select entry.<br />" . $sql . "<br />" . mysql_error());
while ($row = mysql_fetch_array($result))
	{
		$old_timestamp = $row["timestamp"];
		$old_title = $row["title"];
		$old_entry = $row["entry"];
		$old_password = $row["password"];

		$old_title = str_replace('"','\'',$old_title);

		$old_month = date("F",$old_timestamp);
		$old_date = date("d",$old_timestamp);
		$old_year = date("Y",$old_timestamp);
		$old_time = date("H:i",$old_timestamp);
	}


print"<form method=\"post\" action=\"$PHP_SELF\">
<input type=\"hidden\" name=\"id\" value=\"$id\">
<table><tr><td><b>date:</b></td><td>
				<select name=\"month\">
				<option value=\"$old_month\">$old_month</option>
				<option value=\"January\">January</option>
				<option value=\"February\">February</option>
				<option value=\"March\">March</option>
				<option value=\"April\">April</option>
				<option value=\"May\">May</option>
				<option value=\"June\">June</option>
				<option value=\"July\">July</option>
				<option value=\"August\">August</option>
				<option value=\"September\">September</option>
				<option value=\"October\">October</option>
				<option value=\"November\">November</option>
				<option value=\"December\">December</option>
				</select>

				<input type=\"text\" name=\"date\" size=\"2\" value=\"$old_date\">

				<select name=\"year\">
				<option value=\"$old_year\">$old_year</option>
				<option value=\"2004\">2004</option>
				<option value=\"2005\">2005</option>
				<option value=\"2006\">2006</option>
				<option value=\"2007\">2007</option>
				<option value=\"2008\">2008</option>
				<option value=\"2009\">2008</option>
				<option value=\"2010\">2010</option>
				</select>

				<input type=\"text\" name=\"time\" size=\"5\" value=\"$old_time\">
			</td></tr>
<tr><td><b>title:</b></td><td><input type=\"text\" name=\"title\" size=\"40\" value=\"$old_title\"></td></tr>
</table>
<textarea cols=\"65\" rows=\"20\" name=\"entry\">$old_entry</textarea>
<p align=\"right\"><input type=\"submit\" name=\"update\" value=\"Update\"><input  align=\"right\" type=\"submit\" name=\"delete\" value=\"Delete\"></p>
</form>";

if($update)
    {
    	$timestamp = strtotime ("$month $date $year $time");
 include("config.php"); 

	$result = mysql_query("UPDATE php_blog SET timestamp='$timestamp', title='$title', entry='$entry' WHERE id=$id") or print ("Can't update entry.<br />" . $sql . "<br />" . mysql_error());
	print"<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=../index.php?id=$id\">";
	mysql_close();
     }


if($delete)
{
include("../config.php");
$timestamp = strtotime ("$date $month $year $time");

$result = mysql_query("DELETE FROM php_blog WHERE id=$id") or print ("Can't delete entry.<br />" . $sql . "<br />" . mysql_error());

mysql_close();

if ($result != false)
{
print "<b>This entry has been successfully deleted from the database.</b>";
}

}

?>

