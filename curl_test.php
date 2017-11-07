<?php

$url = urldecode($_REQUEST["url"]);

if(!empty($url)){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
	//curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT,30);
	$output = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	echo '<b>' . $url . '</b> returned ' . ($httpcode==200||$httpcode==301||$httpcode==302?"<span class='success'>".$httpcode."</span>":"<span class='error'>".$httpcode."</span>");
	//if(stristr($output, "failed")){echo " but <span class='error'>FAILED</span>";}
} else {echo 'url not passed';}

?>