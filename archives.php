<?php

include("config.php");
?>

<html><head>
<title><?php echo $cfg_blogtitle ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $cfg_cssfile ?>">
</head>

<body>


<div class="container">

<div class="header">
<?php echo $cgf_blogname ?> - Archives
</div>

<div class="news_item">

<?php

$result = mysql_query("SELECT timestamp, id, title FROM php_blog WHERE FROM_UNIXTIME( timestamp, '%Y' ) = $year ORDER BY id DESC");

while ($row = mysql_fetch_array($result))
{
$date = date("l F d Y",$row["timestamp"]);
$id = $row["id"];
$title = $row["title"];

echo "$date<br><a href=\"journal.php?id=$id\">$title</a><br><br>";
}

?>

</div>

<?php

include("config.php");
?>

<div id="side">
<h2>Archives</h2>
<ul>

<?php
$result = mysql_query("SELECT FROM_UNIXTIME( timestamp, '%Y' ) AS get_year, COUNT(*) AS entries FROM php_blog GROUP BY get_year");

while ($row = mysql_fetch_array($result))
{
$get_year = $row["get_year"];
$entries = $row["entries"];

echo "<a href=\"archives.php?year=$get_year\">entries from $get_year</a> ($entries)<br>";
}

?>
</ul>
</div>
</div>
</body>
</html>