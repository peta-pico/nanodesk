<?php

/**
 *
 */
class Papers
{
	private $db;

	function __construct()
	{
		# code...

		$this->db = Core::dbConnect();
	}


	/*

	*/
	function dataArray( $paper_id, $orcid_id )
	{
		// Select all paper data
		$query = $this->db->prepare("SELECT * FROM papers WHERE id=? AND orcid_id=? LIMIT 1");
		$query->execute( array( $paper_id, $orcid_id ) );

		$row = $query->fetch(PDO::FETCH_ASSOC);


		$aidas = $this->db->prepare("SELECT * FROM aidas WHERE paper_id=? AND orcid_id=? ORDER BY date DESC");
		$aidas->execute( array( $paper_id, $orcid_id ) );

		$row['aidas'] = $aidas->fetchAll(PDO::FETCH_ASSOC);

		return $row;

	}



}


?>
