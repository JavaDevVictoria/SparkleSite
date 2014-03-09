<?php

include('config.php');

$sql = "SELECT * FROM php_blog_comments ORDER BY timestamp DESC LIMIT 5";
$result = mysql_query ($sql) or
print ("Can't select comments from table php_blog_comments.<br />" . $sql . "<br />" . mysql_error());
 $timestamp = date("j/M H:i",$row["timestamp"]);
while($row = mysql_fetch_array($result))
{
 $timestamp = date("j/M H:i",$row["timestamp"]);
 $varshort = substr($row["comment"],0,35);
 printf("<b><a href=\"%s\" target=\"_blank\">%s</a> [at] %s</b><br> <i>$varshort</i>...<br>\n", $row["url"], $row["name"], $timestamp);
}
?> 

