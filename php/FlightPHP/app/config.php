<?php

$config = [
  'defaults' => [
    'fetchLimit' => 5,
    'offset' => 0
  ],
  'db' => [
    'host' => 'xxx',
    'user' => 'xxx',
    'password' => 'xxx',
    'dbname' => 'xxx',
  ],

  'autoloader' => __DIR__ . '/../vendor/autoload.php',
  'flight' => [
    'views_path' => __DIR__ . '/routes',
  ],
  'og' => [
    'title' => 'Otsikko',
    'description' => 'Kuvaus',
    'image' => ''
  ]
];



function stringEndsWith($haystack, $needle) {
  return strlen($needle) === 0
    || (substr($haystack, strlen($needle) * -1) === $needle);
}

function isLocalhost() {
  return stringEndsWith($_SERVER['SERVER_NAME'], '.test');
}

if (isLocalhost()) {
  // Display errors
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // Localhost database config
  $config['db']['host'] = 'localhost';
  $config['db']['user'] = 'root';
  $config['db']['password'] = 'meShiel4';
}
