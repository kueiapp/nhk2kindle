<?php

/*
* Get NHK Easy article meta
* Power by Kueiapp.com
* Autohr: Kuei App
* Copyright: Kuei App
*/

include_once __DIR__."/modal/DataHandler.class.php";		

function preprocessString($input){
	return htmlspecialchars( addcslashes($input,"'") );
}

function getIdNumber($mp3Url){
	return str_replace(".mp4", "", $mp3Url);
}

function rssReader2($url){

	$dh = new DataHandler();

	// $feeds = file_get_contents($url);
	/* Using cURL is reliabler */
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_HEADER, FALSE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_REFERER, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	$feeds = curl_exec($curl);
	curl_close($curl);

	$feeds = utf8_encode($feeds);
	
	$str = "";
	// Remove some UNICODE chars
	// $json = preg_replace('/\x{feff}$/u', "", json_encode($feeds) );
	if ( strpos($feeds,"ï»¿",1) !== 0 ){
		echo "unicode string found---\n";
		$str = str_replace("ï»¿", "", $feeds);
	}

	// Handle by Array
	$json = json_decode( $str, true );
	echo "json type = ".gettype($json)."\n";
	// var_dump($json);

	// Destruct the JSON stucture
	$data = $json[0];
	foreach($data as $detail){
		foreach($detail as $d){
			$id = getIdNumber($d["news_easy_voice_uri"]);
			$dh->insert((Object)array(
				"id"=>			$id,
				"title"=>		$d["title"],
				"link"=>		$d["news_web_url"],
				"easyLink"=>"https://www3.nhk.or.jp/news/easy/{$id}/{$id}.html",
				"pubDate"=>	$d["news_publication_time"],
				"imgUrl"=>	$d["news_web_image_uri"],
				"mp3Url"=>	$d["news_easy_voice_uri"]
			));
		}
	}
	
}//endfor

rssReader2("https://www3.nhk.or.jp/news/easy/news-list.json");
