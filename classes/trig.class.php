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
	function writeReadNanopub( $doi, $orcid, $date=false )
	{
		$date = ( $date !='' ) ? $date : date("c", time());

		$data = "
		@prefix : <http://example.org/nanodesk/example/read/> .
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
			orcid:".$orcid." ex:hasRead <http://dx.doi.org/".$doi."> .
		}

		:provenance {
			:assertion prov:wasAttributedTo orcid:".$orcid." .
		}

		:pubinfo {
			: dc:created \"".$date."\"^^xsd:dateTime ;
				pav:createdBy orcid:".$orcid." .
		}
		";

		// Set filename of the trigfile
		$filename = uniqid(mt_rand(), true).'_'.time().'_'.$orcid;

		// Write the file to folder
		$this->writeFile($filename, $data, '../trigfiles');

		//make file trusty
		$this->makeTrusty($filename);

		return 'trusty'.$filename.'trig';

	}//

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
			$trusty_output = exec("java -jar ../trigfiles/nanopub.jar mktrusty ../trigfiles/".$file.".trig", $trusty_output);

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

	function uploadNanopub($file)
	{
		if(file_exists('../trigfiles/'))
		{

		}






		if( file_exists("trigfiles/nanopub.jar") )
			{


				die('should be trusty');

				if ( $trusty_output == '')
				{
					//try upload
					// if succes, it will return a string
					$publish_output = exec("java -jar trigfiles/nanopub.jar publish trigfiles/trusty.".$filename.".trig", $publish_output);


					if( strpos($publish_output , 'INVALID NANOPUB') != false )
					{
						//-- the file is invalid and cannot be posted
						$alert['response'] =  "warning";
						$alert['message'] =  "INVALID NANOPUB DETECTED";
					}
					else
					{
						if($publish_output != '')
						{
							$alert['response'] =  "success";
							$alert['message'] =  $publish_output.". <br> Your paper will shortly appear in your list.";
						}
						else
						{
							$alert['response'] =  "danger";
							$alert['message'] =  "File is not published<br>".$publish_output;
						}
					}

					//delete the created files
					unlink ( "trigfiles/".$filename.".trig" );
					unlink ( "trigfiles/trusty.".$filename.".trig" );
				}

				else
				{
					//echo "file is not uploding...";
				}

			}
			else{
				//echo "file does not exsist";
			}
	}





}


 ?>
