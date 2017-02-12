<?php
require __DIR__ . '/vendor/autoload.php';
$api = new Milo\Github\Api;

$url = 'https://api.github.com/users/paulyabsley';
$response = $api->get($url);
$user = $api->decode($response);
echo '<img src="' . $user->avatar_url . '">';