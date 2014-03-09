<?php

//Some protection against hacking attempts...
define('IN_SITE' , true);

//Include required files
include("config.php");
include("db.php");

//Check the $_POST data
if( $_POST['entry'] )
{
	$entry = $_POST['entry'];
}
if( $_POST['timestamp'] )
{
	$timestamp = $_POST['timestamp'];
}
if( $_POST['name'] )
{
	$name = $_POST['name'];
}
if( $_POST['email'] )
{
	$email = $_POST['email'];
}
if( $_POST['url'] )
{
	$url = $_POST['url'];
}
if( $_POST['comment'] )
{
	$comment = $_POST['comment'];
}


if($comment)
{
	$comment = strip_tags($comment);
	$comment = nl2br($comment);

	$result = mysql_query("INSERT INTO php_blog_comments (entry, timestamp, name, email, url, comment) VALUES ('$entry','$timestamp','$name','$email','$url','$comment')");

	if( !$result ) 
	{
	   die('Invalid query: ' . mysql_error());
	}
	else
	{
		echo '<meta HTTP-EQUIV="REFRESH" CONTENT="0; URL=journal.php?id='.$entry.'">';
	}
}
else
{
echo "Error: No comment posted!";
}
?>