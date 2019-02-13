<?php
/*
* Data handler between database and controller
* Power by Kueiapp.com
* Autohr: Kuei App
* Copyright: Kuei App
*/

include_once __DIR__."/config.php";		
include_once __DIR__."/Query.class.php";

class DataHandler{

// members
	private $dbh;
	
// functions
	// 建立連線
	function __construct(){
		 $this->dbh = new Query();
	}

	function insert($obj){
		$this->dbh->insertNews(
			$obj->id,
			$obj->title,
			$obj->link,
			$obj->easyLink,
			$obj->pubDate,
			$obj->imgUrl,
			$obj->mp3Url
		);
	}

	function getNews($page=0){
		return $this->dbh->getNews($page);
	}

}