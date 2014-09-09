<?php
/**
 * Configure the database and bootstrap Eloquent
 */

$config = parse_ini_file("config.ini");

$capsule = new Illuminate\Database\Capsule\Manager;

$capsule->addConnection(array(
		'driver'    => 'mysql',
		'host'      => $config['database.host'],
		'database'  => $config['database.dbname'],
		'username'  => $config['database.username'],
		'password'  => $config['database.password'],
		'charset'   => 'utf8',
		'collation' => 'utf8_general_ci',
		'prefix'    => ''
));

$capsule->setAsGlobal();

$capsule->bootEloquent();

// set timezone for timestamps etc
date_default_timezone_set('UTC');

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);
