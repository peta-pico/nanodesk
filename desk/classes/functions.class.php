<?php
class Functions
{

	// function __construct(argument)
	// {
	// 	# code...
	// }

	function dumpArray( $array )
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	function cleanup($str, $replace=array(), $delimiter='-') {
		
		if( !empty($replace) ) {
				$str = str_replace((array)$replace, ' ', $str);
		}

		// Change all the special characters to their matching  UTF-8 variant
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		
		// Delete all the strange characters, like comma etc.
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		
		// Change everything into lower case.
		$clean = strtolower(trim($clean, '-'));
		
		// Place a custom character for each space.
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
		
	}
	
}



?>
