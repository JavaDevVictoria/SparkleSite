<?php

//Set security safeguards
define ('IN_SITE' , true);
$logged = false;
$my_username = "";
$my_password = "";

//Let's set this so we don't get lost when using functions from diferent places and such
//It points to the script's root dir, from the current one
$root_dir = "../";

//Importing required files
include( '../includes/functions.php' );
include( '../includes/page_common.php' );

//Let's see if we have a config file
if( file_exists('../config.php') )
{
	$config = true;
	include('../config.php');
}
else
{
	$config = false ;
	$cfg_cssfile = "evo.css";
	$cfg_blogtitle = "Welcome to Sparkle!";
	$cgf_blogname = "Welcome to Sparkle!";
}

//Let's see if the install folder was deleted already
$output = explode( "," , list_dir( ".." , "d" ) );
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
<link rel="stylesheet" type="text/css" href="../skins/<?php echo $cfg_cssfile ?>">
</head>

<body>

<div class="container">

<div class="header">
<?php echo $cgf_blogname ?> - Post an entry
</div>

<?php echo $menu_text ?>

<div class="main">

<?php
//Let's end things here if no config.php was found, or if the install folder still exists
if( !$config ) 
{
   die( '<p class="news_item"><b>Warning: No config file found!</b><br> Have you ran the <a href="install/install.php">install script</a> yet?' . $foot_text );
}
else if( $install ) 
{
   die( '<p class="news_item"><b>Warning: Install folder detected!</b><br> Please delete the /install folder before using Sparkle.</p>' . $foot_text );
}

$output = explode( "," , val_input() );
if( $output[0] == 0 )
{
	$month = $_POST['month'];
	$date = $_POST['date'];
	$year = $_POST['year'];
	$time = $_POST['time'];
	
	$timestamp = strtotime( "$month $date $year $time" );
	$entry = nl2br( htmlspecialchars ( $_POST['entry'] ) );
	$title = $_POST['title'];
	$password = $_POST['password'];
	
	$sql = "INSERT INTO php_blog (timestamp,title,entry,password) VALUES ('$timestamp','$title','$entry','$password')";
	
	$result = @mysql_query($sql);
	if( $result === false )
	{
		echo '<div class="news_item"><b>Operation failed!</b> Can\'t insert into table php_blog.<br>';
		echo( 'Query: ' . $sql . '<br>Reported error: ' . mysql_error() );
	}
	else
	{
		echo '<div class="news_item"><b>Operation suceeded!</b> News entry has been posted.<br>';
		echo '<a href="../index.php">Return to Home</a> | <a href="postentry.php">Post new entry</a>';
	}
	mysql_close();

	echo '</div>' .	$foot_text;
}
else
{
	$current_month = date("F");
	$current_date = date("d");
	$current_year = date("Y");
	$current_time = date("H:i");
	
	if( $output[0] > 0 )
	{
		echo '<p class="news_item"><b>Warning:</b> The following was left blank: |';
		foreach( $output as $key => $var )
		{
			if( $key > 0 && !empty( $var ) )
			{
				echo "$var|";
			}
		}
		echo '</p>';
	}
	
	?>
	<div class="news_item">
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
	</div>
	<?php
	echo $foot_text;
}

?>