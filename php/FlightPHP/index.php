<?php

/* * * * *\
 *  Init *
\* * * * */

// Config
require_once __DIR__ . '/config.php';

// Require autoloader
require_once $config['autoloader'];

// Set views path
Flight::set('flight.views.path', $config['flight']['views_path']);

// Set config
Flight::view()->set('config', $config);

// Setup database
Flight::register('db', 'PDO', array('mysql:host='.$config['db']['host'].';dbname='.$config['db']['dbname'], $config['db']['user'], $config['db']['password']),
  function($db){
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
);



/* * * * *\
 * Views *
\* * * * */

Flight::route('/', function() {
  Flight::render('home');
});



/* * * * * * * * *\
 * Data Handlers *
\* * * * * * * * */

Flight::route('POST /post-data', function() {
  Flight::render('db-handlers/post-data');
  die();
});
Flight::route('GET /get-data', function() {
  Flight::render('db-handlers/post-data');
  die();
});



// Run router
Flight::start();
