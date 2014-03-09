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
<?php echo $cgf_blogname ?> - Create new entry
</div>


<?php

$current_month = date("F");
$current_date = date("d");
$current_year = date("Y");
$current_time = date("H:i");
?>

<form method="post" action="<?php echo $PHP_SELF ?>">
<br>
<table>
<tr>
<td><b>Date:</b></td>
<td>
<select name="month">
<option value="<? echo $current_month ?>"><? echo $current_month ?></option>
<option value="January">January</option>
<option value="February">February</option>
<option value="March">March</option>
<option value="April">April</option>
<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="August">August</option>
<option value="September">September</option>
<option value="October">October</option>
<option value="November">November</option>
<option value="December">December</option>
</select>

<input type="text" name="date" size="2" value="<? echo $current_date ?>">

<select name="year">
<option value="<? echo $current_year ?>"><? echo $current_year ?></option>
<option value="2004">2004</option>
<option value="2005">2005</option>
<option value="2006">2006</option>
<option value="2007">2007</option>
<option value="2008">2008</option>
<option value="2009">2008</option>
<option value="2010">2010</option>
</select>

<input type="text" name="time" size="5" value="<? echo $current_time ?>">
</td>
</tr>
<tr><td><b>Title:</b></td><td><input type="text" name="title" size="40"></td></tr>
</table>
<br>
<table>
<tr><td><b>Message:</b></td></tr>
<tr><td><textarea cols="65" rows="20" name="entry"></textarea></td></tr>
<tr><td align="right"><input type="submit" name="submit" value="Submit"></td></tr>
</table>
<br>
<b>Enable password protection? : </b> <input type="checkbox" name="password" value="1"><br>
(If enabled, only people who know the password will be able to view this entry.  This is ideal if you only want yourself and close friends to be able to read an entry.)
</form>
<br>

<?php

if($submit) {
$timestamp = strtotime ("$month $date $year $time");
$entry = nl2br($entry);

$sql = "INSERT INTO php_blog (timestamp,title,entry,password) VALUES ('$timestamp','$title','$entry','$password')";

$result = mysql_query($sql) or print ("Can't insert into table php_blog.<br />" . $sql . "<br />" . mysql_error());

if ($result != false)
{
print "Your entry has successfully been entered into the database!";
}

mysql_close();
}

?>
</div>
</body>
</html>

