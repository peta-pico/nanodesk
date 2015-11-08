<?php
// head functions

//adds files into the <head>
//accepts style, script, custom
function add_files($array = false){

		$return = '';

/*		echo "<pre>";
			print_r($array);
		echo "</pre>";
*/
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

}
?>