<?php

# Composer autoload
require 'vendor/autoload.php';

require 'config.php';

# Initiate the Slim Framework	
$app = new \Slim\Slim();

# Initiate the Database PDO
$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
$usr = DB_USER;
$pwd = DB_PASS;

$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);


# ROUTES

## Admin Routes


## Frontend Routes

/**
 *  The user wants to go to a specific thread.
 *  @format www.example.com/boards/vg/thread/1
 */
$app->get('/boards/:board/thread/:threadId', function($board, $threadId) use ($app, $pdo) {
		
	$thread = new \MIBS\Thread($app, $pdo, $board, $threadId);
	$thread->getOriginalPost();
	$thread->countResponses();
	
});

/**
 *  The user messed with the url, requested no Thread.
 *  Let's 404.
 */
$app->get('/boards/:board/thread', function($board) use($app) {
	$app->notFound();
});

/**
 *  The user wants to go to page N of a Board.
 *  @format www.example.com/boards/2
 */
$app->get('/boards/:board/:page', function($board, $page) use ($app) {
	
	# The Board (N) Page
	
});

/**
 *  The user wants to see the Board first page.
 *  @format www.example.com/board
 */
$app->get('/boards/:board', function($board) use ($app) {
	
	# The Board First Page.
	
});

/**
 *  The user messed with the url, no board is set.
 *  Let's call 404.
 */
$app->get('/boards', function() use ($app) {
	
	$app->notFound();
	
});

/**
 *  The welcome page.
 *  @format www.example.com
 */
$app->get('/', function() use ($app) {
	
	# The welcome page.
	
});

# Error handler
$app->error(function(\Exception $e) use($app) {
	echo 'Erro 500.<br/>Mensagem: '.$e->getMessage(); # Error 500 - Message:
});

# 404 Not Found handler
$app->notFound(function() use($app) {
	echo '404 - P&aacute;gina n&atilde;o encontrada!'; # 404 - Page Not Found
});

# Start Slim Framework
$app->run();