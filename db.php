<?php
//Some protection against hacking attempts...
if ( !defined('IN_SITE') )
{
	die("Hacking attempt");
}

//Define database handles
$db = @mysql_connect("$dbhost","$dbuser","$dbpass") or die( "Unable to connect to database.");
mysql_select_db("$dbname") or die( "Unable to select database. Are you sure the information in config.php is correct?");

?>