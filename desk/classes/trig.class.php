<?php

class Trig {

	/*
	 Write a nanopub
	 $np_type = [read | retract]
	 	'read' requires : orcid, doi, paper_cite, paper_title, paper_year, datetime
		'retract' requires : orcid, np_uri, datetime
	 $np_info = array of all info of the np e.g. title date, orcid etc.
	*/

	function makeNanopub($np_type, array $np_info)
	{
		// reurns a string with corrent template and information
		$file = $this->writeNanopub($np_type,$np_info);

		// new name for the file
		$filename = uniqid(mt_rand(), true).'_'.time().'_'.$np_info['orcid'];

		// Write the file to folder
		$this->writeFile($filename, $file, '../trigfiles');

		// make file trusty or signed - the file is in the same folder
		$this->makeTrusty($filename);

		// return the filename for refrence
		return 'signed.'.$filename.'.trig';
	}


	/*
		writes nanopub
		Read NP requires : orcid, doi, paper_cite, paper_title, paper_year, datetime
		Retract NP requires : orcid, np_uri, datetime
	*/
	function writeNanopub($np_type,$np_info)
	{
		$functions = new Functions;

		// load the correct telplate
		$file = $this->loadTemplate($np_type);

		// list of all the strings that need to be replaced
		// The order is important! 
		// If there are new 'tags', add them at the end of the list
		$find = array(
			'|*ORCID*|',
			'|*NP_URI*|',
			'|*DOI*|',
			'|*PAPER_CITE*|',
			'|*PAPER_TITLE*|',
			'|*PAPER_YEAR*|',
			'|*DATETIME*|',
			'|*DOI_URL*|',
			'|*AIDA_SENTENCE*|'
		);

		// 
		// 
		extract($np_info);
		$date = ( $np_info['date'] !='' ) ? $np_info['date'] : date("c", time());

		// Put the above data into an array
		// The order is important!
		$replace = array(
			$orcid,
			$np_uri,
			$doi,
			$paper_cite,
			$paper_title,
			$paper_year,
			$date,
			$doi_url,
			$functions->cleanup($aida_sentence) 
		);

		// replace all the "$find" w
		$file = @str_replace($find,$replace,$file);

		return $file;
	}

	/*
		Loads the correct template

	*/

	function loadTemplate($np_type)
	{
		// path of the template
		$path = '../nanopubs/templates/';
		
		// load the contents of the file
		if (@file_exists($path.$np_type.'.trig')) {
			$file = file_get_contents($path.$np_type.'.trig');
		}
		else
		{
			die('The NP template does not exsist');
			return false;
		}
		
		return $file;
	}



	function writeFile($filename, $text, $path)
	{
		// Set file name
		$file = $path.'/'.$filename.".trig";

		//create new file
		$myfile = fopen($file, "w");

		//write to file
		fwrite($myfile, $text);

		// Close file
		fclose($myfile);

		if( chmod( $file , 0755 ) )
		{
			return false;
		}
		else
		{
			return true;
		}

	}

	/*
	 Makes specific file trusty
	*/

	function makeTrusty( $file )
	{
		if(file_exists("../trigfiles/".$file.".trig"))
		{
			// server config
			$trusty_output = exec("java -jar -Dfile.encoding=UTF-8 ../trigfiles/nanopub.jar sign -k /home/petapico/nanodesk-config/keys/id_dsa ../trigfiles/".$file.".trig", $trusty_outputx);

			// local config
			// $trusty_output = exec("java -jar -Dfile.encoding=UTF-8 ../trigfiles/nanopub.jar sign -k ../id_key ../trigfiles/".$file.".trig", $trusty_outputx);

			return true;
		}
		else
		{
			return false;
		}

	}

	/*
		Extract hash from trusty file to store in db
		Provide full path to file including filename
	*/

	function getHashFromTrusty( $filename )
	{
		if(file_exists($filename))
		{
			$f = fopen($filename, 'r');
			$line = fgets($f);
			fclose($f);
			$line;

			// get first line and strip tags
			$lines = str_replace(array('<','>','.'), '', $line);
			$lines = explode('/', $lines);

			//return hash
			return trim(end($lines));
		}
		else
		{
			return false;
		}
	}


	function getHashFromUrl( $url )
	{
		// get first line and strip tags
		$lines = str_replace(array('<','>','.'), '', $url);
		$lines = explode('/', $lines);

		//return hash
		return trim(end($lines));
	}


	function uploadNanopub( $filename )
	{
		if(file_exists('../trigfiles/'.$filename))
		{
			if(NP_PUBLISH_METHOD == 'auto')
			{
				$publish_output = exec("java -jar -Dfile.encoding=UTF-8 ../trigfiles/nanopub.jar publish ../trigfiles/".$filename, $publish_output_text);
			}
			elseif(NP_PUBLISH_METHOD == 'manual')
			{
				$publish_output = exec("java -jar -Dfile.encoding=UTF-8 ../trigfiles/nanopub.jar publish -u ".NP_PUBISH_SERVER." ../trigfiles/".$filename, $publish_output_text);
			}


			// when fail:
			// $publish_output == "FAILED TO PUBLISH NANOPUBS"
			$publish_errors = array(
				"FAILED TO PUBLISH NANOPUBS","INVALID NANOPUB"
			);

			if( $publish_output == "FAILED TO PUBLISH NANOPUBS" || strpos($publish_output, 'INVALID NANOPUB') == true )
			{
				//-- the file is invalid and cannot be posted
				$alert['response'] =  "warning";
				$alert['message'] =  "INVALID NANOPUB DETECTED";
				print_r($alert);
				return false;
			}
			elseif($publish_output != '')
			{
				$alert['response'] =  "success";
				$alert['message'] =  $publish_output.". <br> Your paper will shortly appear in your list.";

				//delete the created files
				//@unlink ( "../trigfiles/".$filename);
				//@unlink ( "../trigfiles/".str_replace("signed.","",$filename) );



				return true;
			}
			else
			{
				$alert['response'] =  "error";
				$alert['message'] =  "File is not published<br>";
				$alert['message'] .=  "$publish_output<br>";
				print_r($alert);
				return false;
				//die();
			}
		}

		function descriptionFormat( array $data )
		{

		}



	} // END uploadNanopub





}


 ?>
