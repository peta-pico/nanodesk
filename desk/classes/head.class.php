<?php
// head functions

//adds files into the <head>
//accepts style, script, custom
function add_files($array = false){

		$return = '';

// This part of the function is commented for now. 
// Due to the fact that the count will give warnings 
// and it not necessarry in the current state of the website.
/*		echo "<pre>";
			print_r($array);
		echo "</pre>";


		if(count($array) >= 1)
		{
			foreach($array as $key => $value)
			{			
				// file type
				if($value[0] == 'style'){
					echo '<link rel="stylesheet" href="'.$value[1].'">';
				}
				if($value[0] == 'script'){
					echo '<script src="'.$value[1].'"></script>';
				}
				if($value[0] == 'custom'){
					echo $value[1];
				}
				
			}
		}
*/
}
?>