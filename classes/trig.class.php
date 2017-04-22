<?php

class Trig {

	function aida( $doi, $orcid, $sentence, $date = false )
	{

		$date = ( $date !='' ) ? $date : date("c", time());

		$data =
		   '@prefix : <http://example.org/nanodesk/example/aida/> .
			@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .
			@prefix dc: <http://purl.org/dc/terms/> .
			@prefix pav: <http://purl.org/pav/> .
			@prefix prov: <http://www.w3.org/ns/prov#> .
			@prefix np: <http://www.nanopub.org/nschema#> .
			@prefix ex: <http://example.org/> .
			@prefix orcid: <http://orcid.org/> .

			:Head {
				: np:hasAssertion :assertion ;
					np:hasProvenance :provenance ;
					np:hasPublicationInfo :pubinfo ;
					a np:Nanopublication .
			}

			:assertion {
			    <http://dx.doi.org/'.$doi.'> ex:includesStatement <http://purl.org/aida/'.urlencode( $sentence ).'> .
			}


			:provenance {
				:assertion prov:wasAttributedTo orcid:'.$orcid.' .
			}

			:pubinfo {
				: dc:created "'.$date.'"^^xsd:dateTime ;
				pav:createdBy orcid:'.$orcid.' .

			}
		';

		return $data;
	}

	/*
	/ Example of a read nanopub
	*/
	function writeReadNanopub(array $paper, $orcid, $date=false )
	{
		$date = ( $date !='' ) ? $date : date("c", time());

		$data = '@prefix : <http://purl.org/np/> .
		@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .
		@prefix dct: <http://purl.org/dc/terms/> .
		@prefix pav: <http://purl.org/pav/> .
		@prefix prov: <http://www.w3.org/ns/prov#> .
		@prefix orcid: <http://orcid.org/> .
		@prefix np: <http://www.nanopub.org/nschema#> .
		@prefix npx: <http://purl.org/nanopub/x/> .
		@prefix fabio: <http://purl.org/spar/fabio/> .
		@prefix pc: <http://purl.org/petapico/o/paperclub#> .

		:Head {
			: np:hasAssertion :assertion ;
				np:hasProvenance :provenance ;
				np:hasPublicationInfo :pubinfo ;
				a np:Nanopublication .
		}

		:assertion {
			orcid:'.$orcid.' pc:hasRead <http://dx.doi.org/'.$paper['doi'].'> .

			<http://dx.doi.org/'.$paper['doi'].'>
				dct:bibliographicCitation "'.$paper['description'].'" ;
				dct:title "'.$paper['title'].'" ;
				fabio:hasPublicationYear "'.$paper['year'].'"^^xsd:gYear .
		}

		:provenance {
			:assertion prov:wasAttributedTo orcid:'.$orcid.' .
		}

		:pubinfo {
			: dct:created "'.$date.'"^^xsd:dateTime ;
				pav:createdBy orcid:'.$orcid.' .
			: a npx:ExampleNanopub .  # remove this line once we are done with testing
		}';

		// Set filename of the trigfile
		$filename = uniqid(mt_rand(), true).'_'.time().'_'.$orcid;

		// Write the file to folder
		$this->writeFile($filename, $data, '../trigfiles');

		// make file trusty or signed
		$this->makeTrusty($filename);

		return 'signed.'.$filename.'.trig';

	}//

	/*
	 Write a nanopub
	 $np_type = read | retract
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
		$file = $this->loadTemplate($np_type);

		$find = array(
			'|*ORCID*|',
			'|*NP_URI*|',
			'|*DOI*|',
			'|*PAPER_CITE*|',
			'|*PAPER_TITLE*|',
			'|*PAPER_YEAR*|',
			'|*DATETIME*|');

		$orcid 			=  ($np_info['orcid'] !='') ? $np_info['orcid'] : '';
		$np_uri 		=  ($np_info['np_uri'] !='') ? $np_info['np_uri'] : '';
		$doi 			=  ($np_info['doi'] !='') ? $np_info['doi'] :'';
		$paper_cite 	=  ($np_info['paper_cite'] !='') ? $np_info['paper_cite'] :'';
		$paper_title 	=  ($np_info['paper_title'] !='') ? $np_info['paper_title'] :'';
		$paper_year 	= ($np_info['paper_year'] !='') ? $np_info['paper_year'] :'';
		$date 			= ( $np_info['date'] !='' ) ? $np_info['date'] : date("c", time());


		$replace = array(
			$orcid,
			$np_uri,
			$doi,
			$paper_cite,
			$paper_title,
			$paper_year,
			$date
		);

		$file = @str_replace($find,$replace,$file);

		return $file;
	}

	/*
		Loads the correct template

	*/

	function loadTemplate($np_type)
	{
		$path = '../nanopubs/';
		//load correct template
		switch ($np_type)
		{
			case 'read':
				$template = 'read.txt';
				break;
			case 'retract':
				$template = 'retract.txt';
				break;

			default:
				$template = 'read.txt';
				break;
		}

		$file = file_get_contents($path.$template);

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
			//$trusty_output = exec("java -jar -Dfile.encoding=UTF-8 ../trigfiles/nanopub.jar sign -k /home/petapico/nanodesk-config/keys/id_dsa ../trigfiles/".$file.".trig", $trusty_outputx);

			// local config
			$trusty_output = exec("java -jar -Dfile.encoding=UTF-8 ../trigfiles/nanopub.jar sign -k ../id_key ../trigfiles/".$file.".trig", $trusty_outputx);

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
				@unlink ( "../trigfiles/".$filename);
				@unlink ( "../trigfiles/".str_replace("signed.","",$filename) );



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
