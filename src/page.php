<?php namespace MIBS;

/**
 *  Creates a page with 10 threads. Also handles pagination.
 *  @package MIBS
 */
 class Page {
	 
	private $pdo;
	private $page_num;
	
	public $pThreads;	 
	public $pPageSelector;
	
	function __construct($pdo, $board, $page_num) {
		$this->pdo = $pdo;
		$this->page_num = $page_num;
	}
	
	/**
	 *  Fetches 10 threads from the desired page.
	 *  @return bool threads_exist
	 */
	public function fetchThreads() {
		
		return $threads_exist;
	}
	
	/**
	 *  Creates a simple HTML menu with all the pages.
	 *  @return string $page_selector_html
	 */
	public function createPageSelector() {
		
		return $page_selector_html;
	}
	
	/**
	 *  Fetches all the threads, count them and divide
	 *  the number by 10 (ceil), to find out the 
	 *  necessary number of pages.
	 *  @return $number_of_pages
	 */
	private function countPages() {
		
		return $number_of_pages;
	}
 }