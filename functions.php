<?php
//Functions

//Some protection against hacking attempts...
if ( !defined('IN_SITE') )
{
	die("Hacking attempt");
}

function list_dir( $path , $type ) 
{
	$cwd = getcwd();
	chdir( $path );
	$d = dir( $path );
	$output = "";
	//echo "Handle: " . $d->handle . "<br />\n";
	//echo "Path: " . $d->path . "<br />\n";
	
	while (false !== ($entry = $d->read())) 
	{
		switch ( $type )
		{
			case "d":
				if( is_dir( $entry ) && $entry !== ".." && $entry != "." )
				{
					$output .= $entry.",";
				}
				break;
			case "f":
				if( is_file( $entry ) )
				{
					$output .= $entry.",";
				}
				break;
			default:
				$output .= $entry.",";
		}
	}
	return ( $output );
	chdir( $cwd );
	$d->close();
}

function parse_POST()
{
	$parse_result = 0;
	$return = "";
	if( empty( $_POST['dbhost'] ) )
	{
		$parse_result += 1;
		$return = "Hostname; ";
	}
	if( empty( $_POST['dbname'] ) )
	{
		$parse_result += 1;
		$return .= "Database; ";
	}
	if( empty( $_POST['dbuser'] ) )
	{
		$parse_result += 1;
		$return .= "DB Username; ";

	}
	if( empty( $_POST['dbpass'] ) )
	{
		$parse_result += 1;
		$return .= "DB Password; ";
	}
	if( empty( $_POST['cfg_cssfile'] ) )
	{
		$parse_result += 1;
		$return .= "Default Skin; ";
	}
	if( empty( $_POST['cfg_language'] ) )
	{
		$parse_result += 1;
		$return .= "Default Language; ";
	}
	if( empty( $_POST['cfg_blogtitle'] ) )
	{
		$parse_result += 1;
		$return .= "Blog Title; ";
	}
	if( empty( $_POST['cfg_blogname'] ) )
	{
		$parse_result += 1;
		$return .= "Blog Name; ";
	}
	if( empty( $_POST['cfg_sort'] ) )
	{
		$parse_result += 1;
		$return .= "Sort Order; ";
	}
	if( !isset( $_POST['cfg_sort'] ) )
	{
		$parse_result = -1;
	}
	return( $parse_result."|".$return );
}
?>