<?php

# Composer autoload
require 'vendor/autoload.php';

require 'config.php';

# Initiate the Slim Framework	
$app = new \Slim\Slim();

# ROUTES
$app->get('/', function() use ($app) {
	
	$app->notFound();
	
});

# Error handler
$app->error(function(\Exception $e) use($app) {
	echo 'Erro 500.<br/>Mensagem: '.$e->getMessage();
});

# 404 Not Found handler
$app->notFound(function() use($app) {
	echo '404 - P&aacute;gina n&atilde;o encontrada!';
});

# Start Slim Framework
$app->run();