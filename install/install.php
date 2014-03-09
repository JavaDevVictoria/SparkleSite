<?php
//Set security safeguard
define ('IN_SITE' , true);

//Importing required files
include( "../functions.php" );

//Let's find what languages are available
$output = list_dir( "../lang" , "d" );
$output = explode( "," , $output ) ;

//Let's find what skins are available
$output2 = list_dir( "../skins" , "f" );
$output2 = explode( "," , $output2 ) ;

//Let's see if there is a config.php already
file_exists('../config.php') ? $config = true : $config = false ;

//Checking for desired css file
if( !isset( $cfg_cssfile ) )
{
	$cfg_cssfile = "evo.css";
}

//Creating the page
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sparkle SBS Installation</title>
<link rel="stylesheet" type="text/css" href="../skins/<?php echo $cfg_cssfile ?>">
</head>

<body>

<div class="container">

<div class="header">
Sparkle Installation
</div>

<?php
//End things here if config.php was found
if( $config == true )
{
	die( '<p class="news_item"><b>Warning:</b> config.php file detected!<br>
			This usually means that Sparkle was already installed. If you are sure you wish to proceed, then delete that file and try again.</p>' );
	
}

//Let's check if any POST information was submited, and if it's valid
$parsed_stuff = explode( "|" , parse_POST() );
$parsed_problems = explode( "; " , $parsed_stuff[1] );

//Let's get on with creating the page accordingly
if( $parsed_stuff[0] > 0 && $parsed_stuff[0] < 9 )
{
	echo( '<p class="news_item"><b>Error:</b> The following fields were left blank: </br>' );
	foreach ( $parsed_problems as $var )
	{
		echo $var."  ";
	}
	echo( '</p>' );
}
if( $parsed_stuff[0] != 0 )
{
	?>
	<div class="news_item">
	<form action="install.php" method="post" enctype="application/x-www-form-urlencoded">
	<p class="news_title">Database Information</p>
	<table>
	<tr><td>Hostname: </td><td><input name="dbhost" type="text" value="localhost" size="15"></td></tr>
	<tr><td>Database: </td><td><input name="dbname" type="text" value="test" size="15"></td></tr>
	<tr><td>Username: </td><td><input name="dbuser" type="text" size="15" maxlength="15"></td></tr>
	<tr><td>Password: </td><td><input name="dbpass" type="password" size="15" maxlength="15"></td></tr>
	</table>
	<p class="news_title">General Settings</p>
	<table>
	<tr><td>Default skin: </td><td>
	<select name="cfg_cssfile">
	<?php
	foreach ( $output2 as $var )
	{
		if( $var != "" )
		{
			echo '<option value="'.$var.'">'.$var.'</option>';
		}
	}
	?>
	</select>
	</td></tr>
	<tr><td>Default language: </td><td>
	<select name="cfg_language">
	<?php
	foreach ( $output as $var )
	{
		if( $var != "" )
		{
			echo '<option value="'.$var.'">'.$var.'</option>';
		}
	}
	?>
	</select>
	</td></tr>
	<tr><td>Page title: </td><td><input name="cfg_blogtitle" type="text" value="Page title here"></td></tr>
	<tr><td>Page name: </td><td><input name="cfg_blogname" type="text" value="My Blog"></td></tr>
	<tr><td>Sort order: </td><td>
	<select name="cfg_sort">
	<option value="asc">Ascending</option>
	<option value="desc">Descending</option>
	</select>
	</td></tr>
	<tr><td>&nbsp;</td><td align="right"><input name="submit" type="submit" value="Submit"></td></tr>
	</table>
	</form>
	</div>
	</div>
	</body>
	</html>
	<?php
	exit();
}

//If we got this far it means the user supplied all the required info

//Let's create the tables

$db = @mysql_connect( $_POST['dbhost'] , $_POST['dbuser'] , $_POST['dbpass'] );
$result = @mysql_select_db( $_POST['dbname'] );

if( !$db || $result == false )
{
	die( '<p class="news_item"><b>Unable to connect/select database!</b><br>'.mysql_error().'</p>' );
}


$sql1="CREATE TABLE php_blog (
  id int(20) NOT NULL auto_increment,
  timestamp int(20) default NULL,
  title varchar(255) NOT NULL,
  entry longtext NOT NULL,
  password TINYINT DEFAULT '0' NOT NULL,
  PRIMARY KEY  (id)
)";

$sql2="CREATE TABLE php_blog_comments (
  id int(20) NOT NULL auto_increment,
  entry int(20) NOT NULL,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  comment longtext NOT NULL,
  timestamp int(20) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY id (id)
)";

$result = mysql_query($sql1) or die ('<p class="news_item">Can\'t create the required tables (php_blog) in the database: ' . mysql_error() );
$result2 = mysql_query($sql2) or die ('<p class="news_item">Can\'t create the required tables (php_blog_comments) in the database: ' . mysql_error());
mysql_close();

if ($result != false && $result2 != false )
{
	echo '<p class="news_item">Step 1: Tables successfully created!</p>';
}


//Let's create the string with the data that will be written
$data = '
<?php

// Information needed to connect to mySQL
$dbhost = "'.$_POST['dbhost'].'"; // usually this is localhost but if it doesnt work, check with your hosting provider
$dbname = "'.$_POST['dbname'].'"; // the name of the database you want to use
$dbuser = "'.$_POST['dbuser'].'"; // your mySQL username (must have access to the database above!)
$dbpass = "'.$_POST['dbpass'].'"; // your mySQL password

// Some new variables, allows for more customization of the blog
$cgf_blogname = "'.$_POST['cfg_blogname'].'";	//the name displayed at the top of the page
$cfg_blogtitle = "'.$_POST['cfg_blogtitle'].'"; //page title, defined inside HTML\'s <header> tag
$cfg_cssfile = "./skins/'.$_POST['cfg_cssfile'].'"; //the css file used; allows for easy changing when new styles are available.
$cfg_sort = "'.$_POST['cfg_sort'].'"; //defines whether the posts should be sorted in ascending or descending timestamp order. Can be changed to DESC
$cfg_language = "'.$_POST['cfg_language'].'"; //language pack to be used

// Connection handle
$db = @mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("$dbname") or die( "Unable to select database. Are you sure the information in config.php is correct?");

?>
';

//Write the data to the config.php file
$file = "../config.php";  
$file_handle = @fopen( $file,"w" ); 
if( !$file_handle || !fwrite( $file_handle, $data ) )
{
	?>
	<div class="news_item">
	<p><b>Error:</b> Failed to create file!<br>
	It is likely that your host does not grant write access to scripts for that folder.</p>
	<p>To work around this:<br>
	<b>1)</b> Open notepad and paste the code below.<br>
	<b>2)</b> Save it as "config.php" (don't forget the double quotes, as notepad usually adds .txt to the end of the filename)<br>
	<b>3)</b> Upload the file into Sparkle's root folder on your host.</p>
	
	<p>In case you are having troubles with this instructions, visit <a href="http://sparksbs.sourceforge.net/">our homepage</a> for help.</p>
	
	</div>
	<div align="center">
	<form><textarea name="code" cols="90" rows="23" readonly="readonly"><?php echo $data ?></textarea></form>
	</div>
	<?php
}
else
{
	echo '<p class="news_item">Step 2: Configuration data successfully saved!</p>';
	echo '<p class="news_item">Now that everything is set up, please delete the /install folder.</p>';
	fclose( $file_handle );
}

echo "</div></div></body></html>";

?>