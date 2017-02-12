<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/inc/authenticate.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

$args = ['title' => 'Search'];
if (!empty($_GET['q'])) {
	$response = $api->get(
		'/search/repositories/',
		['q' => filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING)]
	);
	$repositories = $api->decode($response);
	$args['items'] = $repositories->items;
}

echo $twig->render('search.html', $args);