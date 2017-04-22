<?php

/**
 *
 */
class Users
{
	private $db;

	function __construct()
	{
		# code...

		$this->db = Core::dbConnect();
	}


	/*

	*/
	function dataArray( $id )
	{
		// Select all user data
		$query = $this->db->prepare("SELECT * FROM nanousers WHERE id=? OR orcid_id=? LIMIT 1");
		$query->execute( array( $id,$id ) );

		$row = $query->fetch(PDO::FETCH_ASSOC);

		$papers = $this->db->prepare("SELECT * FROM papers WHERE user_id=? OR orcid_id=? ORDER BY date DESC");
		$papers->execute( array( $id,$id ) );

		$row['papers'] = $papers->fetchAll(PDO::FETCH_ASSOC);

		return $row;

	}



}


?>
