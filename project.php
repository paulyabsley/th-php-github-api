<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/inc/authenticate.php';
require __DIR__ . '/inc/watch.php';

$response = $api->get('/user/subscriptions');
$subscriptions = $api->decode($response);

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

$packages = array();
$composer = json_decode(file_get_contents('composer.lock'));
foreach ($composer->packages as $package) {
    $repo = substr($package->source->url, 19, -4);
    $subscribed = false;
    foreach ($subscriptions as $sub) {
    	if ($repo == $sub->full_name) {
    		$subscribed = true;
    	}
    }
    $packages[] = [
        'full_name' => $repo,
        'version' => $package->version,
        'subscribed' => $subscribed
    ];
}
echo $twig->render('project.html', [
	'alert' => $alert,
    'title' => 'Project Repos',
    'items' => $packages
]);