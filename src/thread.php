<?php namespace MIBS;

/**
 *  The thread of a single board.
 *  @package MIBS
 */
class Thread {

	private $pdo = null;
	private $app = null;
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
	private $tFileName = null;
	private $tFileUrl = null;
	private $tFileThumb = null;
	private $tHuman = null;
	private $tIP = null;
	private $tSticky = null;
	private $tLocked = null;
	private $tSage = null;
	
	private $tResponses = array();
	
	public function __construct($app, $pdo, $board, $threadId = null) {
		
		$this->app = $app;
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
		
		try {
			$select = $this->pdo->select()
								->from('posts_'.$this->board)
								->where('id', '=', $this->tId);
			$stmt = $select->execute();
			$data = $stmt->fetch();
			
			if($data) {
				$thread_exists = true;
				
				$this->tSubject = $data['subject'];
				$this->tEmail = $data['email'];
				$this->tName = $data['name'];
				$this->tTrip = $data['trip'];
				$this->tCapcode = $data['capcode'];
				$this->tBody = $data['body'];
				$this->tFiles = $data['files'];
				$this->tFilehash = $data['filehash'];
				$this->tIP = $data['ip'];
				$this->tPostedAt = $data['posted_at'];
				$this->tBumpedAt = $data['bumped_at'];
				$this->tSticky = $data['sticky'];
				$this->tLocked = $data['locked'];
				$this->tSage = $data['sage'];
				
				if(!($this->tFiles == '') && !empty($this->tFiles)) {
				
					$fileInfo = json_decode($this->tFiles);
					$tFileName = $fileInfo->{'name'}.'.'.$fileInfo->{'mime'};
					$tFileThumb = SITE_URL.'/content/thumb/'.$tFileName;
					$tFileUri = SITE_URL.'/content/'.$tFileName;
					$tHuman = '('.$fileInfo->{'human'}.', '.$fileInfo->{'width'}.'x'.$fileInfo->{'height'}.', '.$fileInfo->{'oriName'}.')';
					
				}				
				
			} else {
				$thread_exists = false;
			}
			
			
		} catch (\Exception $e) {
			$this->app->error($e);
		}
	
		return $thread_exists;
	}
	
	/**
	 *  Gets the responses to the Thread.
	 *  @return self
	 */
	public function getResponses($limit = false) {
		
		if($limit){ $select = $this->pdo->select()->from('posts_'.$this->board)->where('thread', '=', $this->tId)->orderBy('posted_at', 'DESC')->limit(10); } else { $select = $this->pdo->select()->from('posts_'.$this->board)->where('thread', '=', $this->tId)->orderBy('posted_at', 'ASC'); }
		
		$stmt = $select->execute();
		
		$response_array = $stmt->fetchAll();
				
		if($response_array) {
		
			if($limit) { $response_array = array_reverse($response_array); } # If we limit by 5, we fetched the last 5, so they're last-to-first order. We flip it.
			
			foreach($response_array as $responseData) {
				
				$responseHandler = new \MIBS\Response($this->pdo, $this->tId);
				
				$this->tResponses[] = $responseHandler->setContent($responseData)->processContent()->getResponseArray();
				
			}
		}
		
		return $this;
		
	}
	
	/**
	 *  Finds how many responses the original post has and
	 *  sets the $tNumResponses field
	 *  
	 *  @return int num_responses
	 */
	public function countResponses() {
		
		try {
			$select = $this->pdo->select(['id'])->count('*', 'num_ids')->from('posts_'.$this->board)->where('thread', '=', $this->tId);
			$stmt = $select->execute();
			$num_responses = $stmt->fetchColumn(1);
			
		} catch(\Exception $e) {
			$this->app->error($e);
		}
		
		return $num_responses;
	}
	
	public function getThreadArray() {
		
		$op_post = array('id' => $this->tId,
						 'name' => $this->tName,
						 'email' => $this->tEmail,
						 'capcode' => $this->tCapcode,
						 'body' => $this->tBody,
						 'posted_at' => $this->tPostedAt,
						 'bumped_at' => $this->tBumpedAt,
						 'files' => $this->tFiles,
						 'filehash' => $this->tFilehash,
						 'filename' => $this->tFilename,
						 'fileurl' => $this->tFileUrl,
						 'filethumb' => $this->tFileThumb,
						 'human' => $this->tHuman,
						 'ip' => $this->tIP,
						 'sticky' => $this->tSticky,
						 'locked' => $this->tLocked,
						 'sage' => $this->tSage
						);
			
		if(!empty($this->tResponses)) {
			
			return array('op_post' => $op_post);
			
		} else {
			
			return array_merge(array('op_post' => $op_post), $this->tResponses);
			
		}
		
	}
}