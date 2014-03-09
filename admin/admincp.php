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
<?php echo $cgf_blogname ?> - Control Panel
</div>

<div>
<p>To get started, click on an action below:</p>
<a href="blogadmin.php">Post an entry</a><br>
<a href="editentries.php">Modify an entry</a><br>
<a href="cpconfig.php">Configure your blog</a><br>
<a href="../index.php">View your blog</a><br>
<a href="http://creamed-coconut.org/forum" target=new>Click here to visit the Support Forums</a>
</div>

<p class="p" align="center"><b>Powered by </b><a href="http://creamed-coconut.org">SparkleBlog</a></p>

</div>

</body>
</html>