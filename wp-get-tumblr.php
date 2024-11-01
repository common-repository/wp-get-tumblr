<?php
/*
* Plugin Name: WP Get Tumblr
* Description: Import tumblr posts using tumblr api. Insert get_tumblr('tumblr id','number of posts'); where you want to show the posts.
* Author: Kosuke Kato
* Plugin URI: http://www.kosukekato.com
* Version: 0.1
* */

function getTumblr($tumblr, $num = null) {
if (is_null($num)) {
  $num = '10';
}
$req_url = 'http://'.$tumblr.'.tumblr.com/api/read?num='.$num;
$xml = @simplexml_load_file($req_url);
if ($xml) {
foreach ($xml->posts->post as $tumblr) {
  if ($tumblr->{"link-text"}) {
	  $title = $tumblr->{"link-text"};
	  $permalink = $tumblr->{"link-url"};
	  echo '<li><a href="'.$permalink.'" target="_blank">'.$title.'</a>';
  }
  else if ($tumblr->{"quote-text"}) {
  $quote = $tumblr->{"quote-source"};
  echo '<li>'.$quote.'</li>';
  }
  else if ($tumblr->{"photo-caption"}) {
  $photo = $tumblr->{"photo-caption"};
  $url = $tumblr->{"photo-url"}[5];
  echo '<li class="clearfix"><img src="'.$url.'" width="50" class="imagel" />'.$photo.'</li>';
  }
  else if ($tumblr->{"video-caption"}) {
  $video = $tumblr->{"video-caption"};
  echo '<li>'.$video.'</li>';
  }
}
} else {
  echo 'XML Error';
}
}