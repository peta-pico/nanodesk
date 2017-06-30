<?php

/**
 *
 */
class Aidas
{
	private $db;

	function __construct()
	{
		# code...

		$this->db = Core::dbConnect();
	}


	/*

	*/
	function dataArray( $aida_id, $orcid_id )
	{
		// Select all paper data
		$query = $this->db->prepare("SELECT * FROM aidas WHERE id=? AND orcid_id=? LIMIT 1");
		$query->execute( array( $aida_id, $orcid_id ) );

		$row = $query->fetch(PDO::FETCH_ASSOC);

		$paper_id = $row['paper_id'];

		$papers = $this->db->prepare("SELECT * FROM papers WHERE id=? AND orcid_id=? ORDER BY date DESC");
		$papers->execute( array( $paper_id, $orcid_id ) );

		$row['paper'] = $papers->fetch(PDO::FETCH_ASSOC);

		return $row;

	}



}


?>
