<?php

require_once 'includes/DbHandler.php';
require_once 'includes/PassHash.php';
require_once 'includes/functions.php';
require '../vendor/autoload.php';


$app = new \Slim\Slim();

// User id from db - Global variable
$user_id = NULL;

require_once 'routes/grades.php';
require_once 'routes/computations.php';
require_once 'routes/users.php';

$app->run();