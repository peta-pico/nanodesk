<?php 

class trig{



	function aida($doi, $date, $orcid){

		$date = date("c", time());

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
			    <'.$doi.'> ex:includesStatement <http://purl.org/aida/Malaria+is+transmitted+by+mosquitoes.> .
			}
			
			:provenance {
				:assertion prov:wasAttributedTo orcid:'.$orcid.' .
			}
			
			:pubinfo {
				: dc:created "'.$date.'"^^xsd:dateTime ;
					pav:createdBy orcid:'.$orcid.' .
			}';	

			return $data;

	}




	function writeFile($filename, $text, $path){
		//create new file
		$myfile = fopen($path.'/'.$filename.".trig", "w");

		//write to file
		fwrite($myfile, $text);
		fclose($myfile);
		return true;
	}





}


 ?>