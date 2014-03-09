
<?php

// Information needed to connect to mySQL
$dbhost = "localhost"; // usually this is localhost but if it doesnt work, check with your hosting provider
$dbname = "sparkle1_creamedcoconut"; // the name of the database you want to use
$dbuser = "sparkle1"; // your mySQL username (must have access to the database above!)
$dbpass = "bintge"; // your mySQL password

// Some new variables, allows for more customization of the blog
$cgf_blogname = "My Test Blog";	//the name displayed at the top of the page
$cfg_blogtitle = "Test Installation with Installer"; //page title, defined inside HTML's <header> tag
$cfg_cssfile = "./skins/evo.css"; //the css file used; allows for easy changing when new styles are available.
$cfg_sort = "desc"; //defines whether the posts should be sorted in ascending or descending timestamp order. Can be changed to DESC
$cfg_language = "./lang/francais.php"; //language pack to be used

// Connection handle
$db = @mysql_connect("$dbhost","$dbuser","$dbpass");
mysql_select_db("$dbname") or die( "Unable to select database. Are you sure the information in config.php is correct?");

?>
