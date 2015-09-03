<?php namespace MIBS;

/**
 *  The Board info.
 */
 
class Board {
	
	private $bURI = null;
	private $bName = null;
	private $bSubtitle = null;
	
	function __construct($pdo, $board_uri) {
		$this->pdo = $pdo;
		$this->bURI = $board_uri;
	}
	
	/**
	 *  Populates the class with the board info.
	 *  @return bool $board_exists
	 */
	public function fetchBoardData() {
		
		return $board_exists;
	}

}