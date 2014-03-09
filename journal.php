<?php
//First let's check if the file used to create the DB tables exists
$filename = 'blogsetup.php';
if (file_exists($filename)) 
{
   die("Warning: Please delete the blogsetup.php file before using your blog.");
}

//Some protection against hacking attempts...
define('IN_SITE' , true);

//Include required files
include ("config.php");
include ("db.php");

?>

<html>
<head>
<title><?php echo $cfg_blogtitle ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $cfg_cssfile ?>">
</head>

<body>

<div class="aha">
This is meant to be removed, it only serves to cover up an ugly toolbar my host puts at the top of the page!
</div>


<div class="container">

<div class="header">
<?php echo $cgf_blogname ?> - Add a Comment to this Entry
</div>

<?php

//Just to be sure:

$sql = "SELECT * FROM php_blog WHERE id=$id";

$result = mysql_query($sql) or
print ("Can't select entries from table 'php_blog'.<br />" . $sql . "<br />" . mysql_error());

while ($row = mysql_fetch_array($result)) {
	$date = date("l, F j, Y | g:ia",$row["timestamp"]);
	$title = $row["title"];
	$entry = $row["entry"];
	$password = $row["password"];

	if($password == 1) {
		if($username == $my_username) {
  			if($pass == $my_password) 
			{
				echo '<div class="news_item">';
				echo '<p class="news_title">'.$title.'</p>';
				echo '<p class="news_entry">'.$entry.'</p>';
				echo '<p class="news_date"><b>Posted:</b> '.$date;
				echo '</p></div>';
  			}
			else 
			{
				print "Sorry, wrong password entered!";
  			}
		}
		else 
		{
			print "<b>$title</b><br /><br />";
			printf("This is a password protected entry.  If you have a password, please log in below.\n");
			printf("<form method=\"post\" action=\"journal.php?id=%s\"><br /><strong>username:</strong> <input type=\"text\" name=\"username\" /><br /><br /><strong>password:</strong> <input type=\"password\" name=\"pass\" /><br /><br /><input type=\"submit\" name=\"submit\" value=\"Submit\" /></form>\n",$id);
			print "<hr /><br /><br />";
		}
	}
	else 
	{
		echo '<div class="news_item">';
		echo '<p class="news_title">'.$title.'</p>';
		echo '<p class="news_entry">'.$entry.'</p>';
		echo '<p class="news_date"><b>Posted:</b> '.$date;
		echo '</p></div>';
		
 		$commentquery = "SELECT * FROM php_blog_comments WHERE entry='$id' ORDER BY timestamp";
 		$commentresult = mysql_query($commentquery) or print("Can't get comments.<br />" . mysql_errno() . ": " . mysql_error());
 		
		while ($row = mysql_fetch_array($commentresult)) {
  			$timestamp = date("F j, Y | g:ia",$row["timestamp"]);
			echo '<div class="news_item">';
			echo '<p class="news_entry">'.$row["comment"].'</p>';
			echo '<p class="news_date"><b>Comment by:</b> <a href="'.$row["url"].'">'.$row["name"].'</a> | '.$timestamp;
			echo '</p></div>';
		}
		$timestamp = strtotime("now");
 ?>
<br>
<div class="news_item">
<form method="post" action="process.php">
<input type="hidden" name="entry" value="<?php echo $id ?>">
<input type="hidden" name="timestamp" value="<?php echo $timestamp ?>">
<table>
<tr><td><b>Name:</b></td><td><input type="text" name="name" size="25" value=""></td></tr>
<tr><td><b>Email:</b></td><td><input type="text" name="email" size="25" value=""></td></tr>
<tr><td><b>URL:</b></td><td><input type="text" name="url" size="25" value="http://"></td></tr>
</table>
<br>
<table>
<tr><td><b>Comments:</b></td></tr>
<tr><td><textarea cols="60" rows="5" name="comment"></textarea></td></tr>
<tr><td align="right"><input type="submit" name="comments" value="Post Comment"></td></tr>
</table>
</form>

<?php
	}
}

$sql_prev = "SELECT * FROM php_blog WHERE id<$id ORDER BY id DESC LIMIT 1";
$result_prev = mysql_query ($sql_prev) or
print ("Can't select previous entry id table php_blog.<br />" . $sql_prev . "<br />" . mysql_error());

while ($row = mysql_fetch_array($result_prev))
{
	$prev = $row["id"];
}

if($prev)
{
	// print a previous link
	printf("<a href=\"journal.php?id=%s\">previous</a> | ", $prev);
}
else
{
	// just print the word "previous"
	print"previous | ";
}

$sql_next = "SELECT * FROM php_blog WHERE id>$id ORDER BY id LIMIT 1";
$result_next = mysql_query ($sql_next) or
print ("Can't select next entry id table php_blog.<br />" . $sql_next . "<br />" . mysql_error());

while ($row = mysql_fetch_array($result_next))
{
	$next = $row["id"];
}

if($next)
{
	// print a next link
	printf("<a href=\"journal.php?page=entry&amp;id=%s\">next</a>", $next);
}
else
{
	// just print the word "next"
	print"next";
}

echo '  |  <a href="index.php">back</a>';
?>
</div>