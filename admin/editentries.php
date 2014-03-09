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
<?php echo $cgf_blogname ?> - Modify Existing Entry
</div>

<div>
<p>Click the entry you want to modify, and you will be taken to a page where you will be able to edit it.  You will also be able to delete entries from there.</p>
<br>

<?php
$result = mysql_query("SELECT timestamp, id, title FROM php_blog ORDER BY id DESC");
while($row = mysql_fetch_array($result))
	{
		$date  = date("l F d Y",$row["timestamp"]);
		$id = $row["id"];
		$title = $row["title"];
		$title = strip_tags($title);
		if(strlen($title) >= 20)
			{
				$title = substr ( $title, 0, 20 );
				$title = "$title...";
			}
		else
			{}
		print("<a href=\"update.php?id=$id\">$date -- $title</a><br>");
	}
mysql_close();
?>
</div>
</div>
</body>
</html>