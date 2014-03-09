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
	chdir( $path ); //This is needed because is_dir() checks in the CWD
	$d = dir(".");
	$output = "";
	while (false !== ($entry = $d->read()))
	{
		switch ( $type )
		{
			case "d":
				if( is_dir( $entry ) && $entry != ".." && $entry != "." )
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
	$d->close();
	chdir( $cwd );
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

function val_input()
{
	$output = "";
	$return_val = 0;
	
	if( $_POST['submit'] )
	{
		if( empty( $_POST['date'] ) )
		{
			$output .= "Date,";
			$return_val += 1;
		}
		if( empty( $_POST['time'] ) )
		{
			$output .= "Time,";
			$return_val += 1;
		}		
		if( empty( $_POST['title'] ) )
		{
			$output .= "Title,";
			$return_val += 1;
		}		
		if( empty( $_POST['entry'] ) )
		{
			$output .= "Entry,";
			$return_val += 1;
		}
	}
	else
	{
		$return_val = -1;
	}
	return( $return_val.",".$output );
}

function rep_code( $entry )
{
	$codes = array( "/\[b\]/" 	=> '<b>' ,
					"/\[\/b\]/"	=> '</b>' ,
					"/\[u\]/"	=> '<u>' ,
					"/\[\/u\]/"	=> '</u>' ,
					"/\[i\]/"	=> '<em>' ,
					"/\[\/i\]/"	=> '</em>' ,
					"/:\)/"		=> '<img src="./smilies/icon_smile.gif" width="15" height="15">' ,
					"/;\)/"		=> '<img src="./smilies/icon_wink.gif" width="15" height="15">' ,
					"/:\(/"		=> '<img src="./smilies/icon_frown.gif" width="15" height="15">'
					 );
					 
	foreach( $codes as $k => $v )
	{
		$entry = preg_replace( $k, $v, $entry );
	}
	return $entry;
}


?>