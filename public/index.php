<?php
// # use Namespaces for HTTP request
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// # include the Slim framework
require '../vendor/autoload.php';

// # include DB connection file
require '../src/config/db.php';

// # create new Slim instance
$app = new \Slim\App;

// # include Arts route
require '../src/routes/nutzer.php';
require '../src/routes/giro.php';
require '../src/routes/fest.php';
require '../src/routes/kredit.php';

// # let Slim starts to run
// without run(), the api routes won't work
$app->run();