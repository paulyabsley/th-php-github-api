<?php
$username = 'paulyabsley';
$url = 'https://api.github.com/users/paulyabsley';
$process = curl_init($url);
curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($process, CURLOPT_USERAGENT, $username);
curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
$return = curl_exec($process);
$results = json_decode($return);
echo '<img src="' . $results->avatar_url . '">';
curl_close($process);