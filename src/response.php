<?php namespace MIBS;

/**
 * The response to a thread.
 * @package MIBS 
 */
class Response {
	
	private $pdo;
	
	private $tId = null;
	private $rName = null;
	private $rTrip = null;
	private $rEmail = null;
	private $rCapcode = null;
	private $rBody = null;
	private $rPostedAt = null;
	private $rBumpedAt = null;
	private $rFiles = null;
	private $rFilehash = null;
	private $rIP = null;
	private $rSticky = null;
	private $rLocked = null;
	private $rSage = null;
	
	public function __construct($pdo, $tId) {
		$this->pdo = $pdo;
		$this->tId = $tId;
		
	}
	
	/**
	 *  Sets the Response content.
	 *  @param array $response_data
	 *  @return self
	 */	
	public function setContent(array($response_data)) {
		
		$this->rName = $response_data['name'];
		$this->rTrip = $response_data['trip'];
		$this->rEmail = $response_data['email'];
		$this->rCapcode = $response_data['capcode'];
		$this->rBody = $response_data['body'];
		$this->rPostedAt = $response_data['posted_at'];
		$this->rBumpedat = $response_data['bumped_at'];
		$this->rFiles = $response_data['files'];
		$this->rFilehash = $response_data['filehash'];
		$this->rIP = $response_data['ip'];
		$this->rSticky = $response_data['sticky'];
		$this->rLocked = $response_data['locked'];
		$this->rSage = $response_data['sage'];
		
		return $this;
	}
	
}