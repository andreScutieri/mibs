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
	private $rFileName = null;
	private $rFileUrl = null;
	private $rFileThumb = null;
	private $rHuman = null;
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
		
		$this->rId = $response_data['id'];
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
	
	public function processContent() {
		
		if($this->rFiles != '' && !empty($this->rFiles)) {
			
			$fileInfo = json_decode($this->rFiles);
			$rFileName = $fileInfo->{'name'}.'.'.$fileInfo->{'mime'};
			$rFileThumb = SITE_URL.'/content/thumb/'.$tFileName;
			$rFileUrl = SITE_URL.'/content/'.$tFileName;
			$rHuman = '('.$fileInfo->{'human'}.', '.$fileInfo->{'width'}.'x'.$fileInfo->{'height'}.', '.$fileInfo->{'oriName'}.')';
			
		}
		
		return $this;
	}
	
	public function getResponseArray() {
		
		return array('id' => $this->rId, 
					 'name' => $this->rName,
					 'trip' => $this->rTrip,
					 'email' => $this->rEmail,
					 'capcode' => $this->rCapcode,
					 'body' => $this->rBody,
					 'posted_at' => $this->rPostedAt,
					 'bumped_at' => $this->rBumpedAt,
					 'files' => $this->rFiles,
					 'filename' => $this->rFileName,
					 'fileurl' => $this->rFileUrl,
					 'filethumb' => $this->rFileThumb,
					 'human' => $this->rHuman,
					 'ip' => $this->rIP,
					 'sticky' => $this->rSticky,
					 'locked' => $this->rLocked,
					 'sage' => $this->rSage
					);
}