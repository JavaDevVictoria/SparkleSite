<?php

//Set security safeguards
define ('IN_SITE' , true);
$logged = false;
$my_username = "";
$my_password = "";

//Let's set this so we don't get lost when using functions from diferent places and such
//It points to the script's root dir, from the current one
$root_dir = "./";

//Importing required files
include( 'includes/functions.php' );
include( 'includes/page_common.php' );

//Let's see if we have a config file, if not we set some basic stuff
if( file_exists('config.php') )
{
	$config = true;
	include('config.php');
}
else
{
	$config = false ;
	$cfg_cssfile = "evo.css";
	$cfg_blogtitle = "Welcome to Sparkle!";
	$cgf_blogname = "Welcome to Sparkle!";
}

//Let's see if the install folder was deleted already
$output = explode( "," , list_dir( '.' , 'd' ) );
$install = false;
foreach( $output as $var )
{
	if( $var == 'install' )
	{
		//$install = true;
	}
}

//Creating the page
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $cfg_blogtitle ?></title>
<link rel="stylesheet" type="text/css" href="./skins/<?php echo $cfg_cssfile ?>">
</head>

<body>

<div class="container">

<div class="header">
<?php echo $cgf_blogname ?>
</div>

<?php echo $menu_text ?>

<div class="main">

<?php
//Let's end things here if no config.php was found, or if the install folder still exists
if( !$config ) 
{
   die('<p class="news_item"><b>Warning: No config file found!</b><br> Have you ran the <a href="install/install.php">install script</a> yet?');
}
else if( $install ) 
{
   die('<p class="news_item"><b>Warning: Install folder detected!</b><br> Please delete the /install folder before using Sparkle.');
}

//Let's retrieve entries from the database
$sql = "SELECT * FROM php_blog ORDER BY timestamp ".$cfg_sort." LIMIT 5";

$result = @mysql_query($sql);
if( !result )
{
	echo ("<p class=\"news_entry\"><b>Can't select entries from table 'php_blog'.</b><br>".$sql."<br><br>".mysql_error()."</p>" );
}


while ($row = mysql_fetch_array($result)) {
	if( $cfg_timeformat == "24h" )
	{
		$date = date("l, F j, Y | H:i",$row["timestamp"]);
	}
	else
	{
		$date = date("l, F j, Y | g:ia",$row["timestamp"]);
	}
	$title = $row["title"];
	$entry = $row["entry"];
	$password = $row["password"];
	$id = $row["id"];
	//Check for valid login
	if( $my_username == $_POST['username'] && $my_password == $_POST['password'] )
	{
		$logged = true;
	}

	if ($password == "1" && !$logged) 
	{
		print "<b>$title</b><br /><br />";
		printf("This is a password protected entry.  If you have a password, please log in below.\n");
		printf("<form method=\"post\" action=\"journal.php?id=%s\"><br /><strong>username:</strong> <input type=\"text\" name=\"username\" /><br /><br /><strong>password:</strong> <input type=\"password\" name=\"pass\" /><br /><br /><input type=\"submit\" name=\"submit\" value=\"Submit\" /></form>\n",$id);
		print "<hr /><br /><br />";
	}
	if ( ($password == "1" && $logged) || (!$password) )
	{
		echo '<div class="news_item">';
		echo '<p class="news_title">'.$title.'</p>';
		$entry = rep_code( $entry );
		echo '<p class="news_entry">'.$entry.'</p>';
		echo '<p class="news_date"><b>Posted:</b> '.$date.' | ';

		$query = mysql_query("SELECT id FROM php_blog_comments WHERE entry=$id");
		$num_rows = mysql_num_rows($query);
		
		if ($num_rows) {
	 		echo "<a href=\"journal.php?id=$id\">$num_rows comments</a>";
		}
	  	else 
		{
	  		echo "<a href=\"journal.php?id=$id\">Make a comment</a>";
	  	}
		echo "</p></div>";
	}
}

echo $foot_text;
?>
