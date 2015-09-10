<?php namespace MIBS;

/**
 *  Creates a page with 10 threads. Also handles pagination.
 *  @package MIBS
 */
 class Page {
	 
	private $pdo = null;
	private $app = null;
	private $board = null;
	private $page_num = null;
	
	public $pThreads = null;	 
	public $pPageSelector = null;
	
	function __construct($app, $pdo, $board, $page_num) {
		$this->app = $app;
		$this->pdo = $pdo;
		$this->board = $board;
		$this->page_num = $page_num;
	}
	
	/**
	 *  Fetches 10 threads from the desired page.
	 *  @return bool threads_exist
	 */
	public function fetchThreads() {
		
		if($this->page_num == 1) {		
			$select = $this->pdo->select()->from('posts_'.$this->board)->whereNull('thread')->orderBy('bumped_at', 'DESC')->limit(10);
		}
		
		try {
		
			$stmt = $select->execute();
			$threads = $stmt->fetchAll();
			
			if($threads) {
				$threads_exist = true;
				
				foreach($threads as $thread) {
					
					$thread = new \MIBS\Thread($this->app, $this->pdo, $this->board, $thread['id']);
					if($thread->getOriginalPost()) {
						$data = $thread->getResponses(true)->getThreadArray();
						$this->pThreads[] = $data;
					}
					else {
						$threads_exist = false;
					}
				}
				
			} else {
				$threads_exist = false;
			}
		
		} catch(\Exception $e) { 
			$this->app->error($e);
		}
		
		return $threads_exist;
	}
	
	/**
	 *  Returns the threads
	 *  @return array $pThreads
	 */
	public function getThreads() {
		return $this->pThreads;		
	}
	 
	
	/**
	 *  Creates a simple HTML menu with all the pages.
	 *  @return string $page_selector_html
	 */
	public function createPageSelector() {
		
		$num_pages = $this->countPages();
		
		$before = "<nav><ul class=\"pagination\" \"pagination-lg\">";
		$link_prev = null;
		$link_next = null;
		$after = "</ul></nav>";
		$content = '';
		
		$counter = 1;
		
		if($this->page_num > 1) {
			$link_prev = '<li><a href="'.SITE_URL.'/boards/'.$this->board.'/'.($this->page_num-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
		} else {
			$link_prev = '<li class="disabled"><a href="#" aria-label="Anterior"><span aria-hidden="true">&laquo;</span></a></li>';
		}
		
		if($this->page_num < $num_pages) {
			$link_next = '<li><a href="'.SITE_URL.'/boards/'.$this->board.'/'.($this->page_num+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
		} else {
			$link_next = '<li class="disabled"><a href="#" aria-label="Pr&oacute;ximo"><span aria-hidden="true">&raquo;</span></a></li>';
		}
				
		while($counter <= $num_pages) {
			if($counter == $this->page_num) {
				$li = '<li class="active"><span>'.$counter.'<span class="sr-only">(current)</span></span></li>';
			} else {
				$li = '<li><a href="'.SITE_URL.'/boards/'.$this->board.'/'.$counter.'">'.$counter.'</a></li>';
			}
			$content = $content.$li;
			
			$counter++;
		}
		
		$page_selector_html = $before.$link_prev.$content.$link_next.$after;
		
		return $page_selector_html;
	
	}
	
	/**
	 *  Fetches all the threads, count them and divide
	 *  the number by 10 (ceil), to find out the 
	 *  necessary number of pages.
	 *  @return $number_of_pages
	 */
	private function countPages() {
		
		$select = $this->pdo->select()->from('posts_'.$this->board)->count('id', 'num_ids')->whereNull('thread')->limit(300);
		
		try {
			$stmt = $select->execute();
			$data = $stmt->fetchAll();
						
			$num_threads = $data[0]['num_ids'];
			
			$number_of_pages = ceil($num_threads/10);
						
		} catch(\Exception $e) {
			$this->app->error($e);
		}
		
		return $number_of_pages;
	}
 }