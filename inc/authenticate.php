<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

$appUrl = 'http://github-api.local';

$clientId = 'c35be17fd539ee26475d';
$clientSecret = '5b44a39d12d76e0760bb70d18583042736da943b';

$config = new Milo\Github\OAuth\Configuration($clientId, $clientSecret, ['user', 'repo']);
$storage = new Milo\Github\Storages\SessionStorage;
$login = new Milo\Github\OAuth\Login($config, $storage);
$api = new Milo\Github\Api;

if ($login->hasToken()) {
	$token = $login->getToken();
	$api->setToken($token);
} else {
	if (isset($_GET['redirect'])) {
		$login->obtainToken($_GET['code'], $_GET['state']);
		header("Location: " . filter_input(INPUT_GET, 'redirect'));
		exit;
	} else {
		$login->askPermissions("$appUrl/inc/authenticate.php?redirect=" . $_SERVER['REQUEST_URI']);
	}
}