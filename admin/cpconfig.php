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
//include ("../db.php");

?>

<html>
<head>
<title><?php echo $cfg_blogtitle ?></title>
<link rel="stylesheet" type="text/css" href="../<?php echo $cfg_cssfile ?>">
</head>

<body>



<div class="container">

<div class="header">
<?php echo $cgf_blogname ?>
</div>

<?php
//Let's check if the user has given all the needed info
if ($_POST['cfg_blogname'])
{
	$cfg_blogname = stripslashes( $_POST['cfg_blogname'] );
	if ($_POST['cfg_blogtitle'])
	{
		$cfg_blogtitle = stripslashes( $_POST['cfg_blogtitle'] );
		if ($_POST['cfg_cssfile'])
		{
			$cfg_cssfile = $_POST['cfg_cssfile'];
			$cfg_sort = $_POST['cfg_sort'];
				
			//Let's create the new config file:
			echo $cfg_sort;
			$data = '
			<?
			// COMPLETE YOUR MYSQL DETAILS IN THE QUOTATION MARKS BELOW.
			// Information needed to connect to mySQL
			$dbhost = "'.$dbhost.'"; // usually this is localhost but if it doesnt work, check with your hosting provider
			$dbname = "'.$dbname.'"; // the name of the database you want to use
			$dbuser = "'.$dbuser.'"; // your mySQL username (must have access to the database above!)
			$dbpass = "'.$dbpass.'"; // your mySQL password
			
			// DO NOT CHANGE ANYTHING BELOW THIS LINE!
			// Header and footer files - if not in same folder as installation, include absolute URLs
			$header = "header.inc";
			$footer = "footer.inc";
			
			// The names of the tables you wish to create for the blog (doesnt need to be changed)
			$php_blog = "php_blog";
			
			// Some new variables, allows for more customization of the blog
			$cgf_blogname = "'.$cfg_blogname.'";	//the name displayed at the top of the page
			$cfg_blogtitle = "'.$cfg_blogtitle.'"; //page title, defined inside HTML\'s <header> tag
			$cfg_cssfile = "./skins/'.$cfg_cssfile.'"; //the css file used; allows for easy changing when new styles are available.
			$cfg_sort = "'.$cfg_sort.'"; //defines whether the posts should be sorted in ascending or descending timestamp order. Can be changed to DESC

                        $showlastfive = "'.$showlastfive.'"; 
			
			//Connection handle
			$db = @mysql_connect("$dbhost","$dbuser","$dbpass");
			mysql_select_db("$dbname") or die( "Unable to select database. Are you sure the information in config.php is correct?");
			
			?>
			';
			
			$file = "../config.php";   
			if (!$file_handle = fopen($file,"w")) { echo "Cannot open file"; }  
			if (!fwrite($file_handle, $data)) { echo "Cannot write to file"; }  
			echo "You have successfully written data to $file";   
			fclose($file_handle); 
		}
	}
}
else
{
//Display the form to update the fields
?>
<div>
<br>
Here you can edit some basic options for your Blog.
<br>
<form action="cpconfig.php" method="post" target="_self">
<table>
<tr><td><b>Blog title:</b></td><td><input name="cfg_blogname" type="text" value="<?php echo $cgf_blogname ?>" maxlength="100"></td></tr>
<tr><td><b>Page title:</b></td><td><input name="cfg_blogtitle" type="text" value="<?php echo $cfg_blogtitle ?>" maxlength="100"></td></tr>
<tr><td><b>Style to use:</b></td><td><input name="cfg_cssfile" type="text" value="<?php echo basename($cfg_cssfile) ?>" maxlength="50"></td></tr>
<tr><td><b>Sort order:</b></td><td><select name="cfg_sort"><option value="ASC">Ascending</option><option value="DESC">Descending</option></select></td></tr>

<tr><td><b>Show summaries of last 5 comments?:</b></td><td><select name="showlastfive"><option value="yes">Yes</option><option value="no">No</option></select></td></tr>

<tr><td></td><td align="right"><input value="Ok" name="submit" type="submit"></td></tr>
</table>
</form>
</div>
<?php
}
?>
<div>
<p class="p" align="center"><b>Powered by </b><a href="http://creamed-coconut.org">SparkleBlog</a></p>
</div>

</div>

</body>
</html>
