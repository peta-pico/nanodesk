<?php

/**
 *
 */
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

		//Alle speciale chars (é, á, ñ, etc, omzetten naar hun best matchende UTF-8 variant: e, a, n)
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		
		//Alle overige vreemde chars verwijderen (', ", &, etc)
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		
		//Alle chars kleine letters
		$clean = strtolower(trim($clean, '-'));
		
		//custom teken plaatsen voor spaties (bijvoorbeeld na elke ' of " *empty space* ")
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
		
	}
}


?>
