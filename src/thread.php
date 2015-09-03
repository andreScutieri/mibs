<?php namespace MIBS;

/**
 *  The thread of a single board.
 *  @package MIBS
 */
class Thread {

	private $pdo = null;
	private $board = null;
	
	private $tId = null;
	private $tName = null;
	private $tTrip = null;
	private $tEmail = null;
	private $tCapcode = null;
	private $tBody = null;
	private $tPostedAt = null;
	private $tBumpedAt = null;
	private $tFiles = null;
	private $tFilehash = null;
	private $tIP = null;
	private $tSticky = null;
	private $tLocked = null;
	private $tSage = null;
	
	public function __construct($pdo, $board, $threadId = null) {
		
		$this->pdo = $pdo;
		$this->board = $board;
		$this->tId = $threadId;
		
	}
	
	/**
	 *  Gets the first post of a Thread, based on the Id and
	 *  populates the Thread.
	 *  
	 *  @return bool thread_exists
	 */
	public function getOriginalPost() {
	
		return $thread_exists;
	}
	
	/**
	 *  Gets the responses to the Thread.
	 *  @return self
	 */
	public function getResponses() {
		
		return $this;
	}
	
	/**
	 *  Finds how many responses the original post has and
	 *  sets the $tNumResponses field
	 *  
	 *  @return int num_responses
	 */
	public function countResponses() {
		
		return $num_responses;
	}
}