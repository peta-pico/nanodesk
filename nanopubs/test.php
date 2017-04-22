<?php 
error_reporting(E_ALL & ~E_NOTICE);
include('../classes/trig.class.php');

$trig = new Trig;

// read requires: orcid, doi, paper_cite, paper_title, paper_year, datetime
//Retract NP requires : orcid, np_uri, datetime

$np_array = array();
$np_array['orcid'] = '0000-0003-3734-6091';
$np_array['doi'] = '10.1016/s0278-6915(00)00124-1';
$np_array['paper_cite'] = 'this is the cite';
$np_array['paper_title'] = 'Toxicological profile of diethyl phthalate: a vehicle for fragrance and cosmetic ingredients';
$np_array['paper_year'] = '2001';
$np_array['np_uri'] = 'http://purl.org/np/RAVJLNeVvlXPlYx9uo9XvhWUCozKKtPVOVN7DentpI6wQ&lt;br&gt;';



echo $trig->makeNanopub('retract',$np_array);


 ?>