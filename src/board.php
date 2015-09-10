<?php namespace MIBS;

/**
 *  The Board info.
 */
 
class Board {
	
	private $pdo = null;
	
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
		
		$select = $this->pdo->select()->from('boards')->where('uri', '=', $this->bURI);
		$stmt = $select->execute();
		$data = $stmt->fetch();
		
		if($data) {
			$board_exists = true;
			$this->bName = $data['title'];
			$this->bSubtitle = $data['subtitle'];
		} else {
			
			$board_exists = false;
		}
				
		return $board_exists;
	}
	
	public function getBoardInfo() {
		return array('board_uri' => $this->bURI, 'board_title' => $this->bName, 'board_subtitle' => $this->bSubtitle);
	}

}