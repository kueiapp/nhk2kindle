<?php

/*
* To parse NHK Easy article content
* Power by Kueiapp.com
* Autohr: Kuei App
* Copyright: Kuei App
*/

include_once __DIR__."/simple_html_dom.php"; 
include_once __DIR__."/mail/compose.php";        
include_once __DIR__."/modal/DataHandler.class.php";        

// mb_language('ja');
mb_internal_encoding('UTF-8');

$dh = new DataHandler();
$newsArray = $dh->getNews();

foreach($newsArray as $item){
  // Get link from db
  $url = $item["easy_link"];
  echo "Parsing url: {$url}\n";
  if( isset($url) ){
      // test
      // $article = file_get_contents("test.html");
      // Get html remote content or you can use cURL
      $html = file_get_html($url);
      $title = $html->find("title",0)->plaintext;
      $article = $html->find("article.article-main",0)->outertext;

      $result = parse_url($url);
      $author = $result['host'];

      // Compose and email
      composeToKindle('{YOUR_KINDLE_ADDRESS}', $url, $title, $article, $author);
  }
  else{
      echo "Could not get URL string..";
  }

  sleep( rand(4,20) );
}
