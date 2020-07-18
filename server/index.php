<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once('./php/Router.php');
require_once('./php/LibraryManagerRB.php');

const ROOT_PATH = './';
const LIBRARY_PATH = ROOT_PATH . 'library/';
const CINEMA_PATH = ROOT_PATH . 'cinema/';

$library = new LibraryManagerRB();

$router = new Router([
  [
    'path' => '*',
    'name' => '404',
    'resource' => '404.php'
  ],
  [
    'path' => 'library/',
    // 'resource' => LIBRARY_PATH . 'index.php'
    'children' => [
      [
        'path' => '/author',
        'resource' => LIBRARY_PATH . 'author.php'
      ],
      [
        'path' => '/book',
        'resource' => LIBRARY_PATH . 'book.php',
      ],
      [
        'path' => '/genre',
        'resource' => LIBRARY_PATH . 'genre.php',
      ],
      [
        'path' => '/set',
        'resource' => LIBRARY_PATH . 'set.php',
      ],
      [
        'path' => '/triggers',
        'resource' => LIBRARY_PATH . 'triggers.php',
      ],
    ],
  ],
  [
    'path' => '/cinema',
    'resource' => CINEMA_PATH . 'index.php'
  ]
]);

$json = file_get_contents('php://input');
$request = json_decode($json, true);
$route = $router->getActiveRoute();

const DELETE = 'delete';
const UPDATE = 'update';
const ADD = 'add';

$response = [
  'success' => 0,
];

require_once($route['resource']);

responseJson($response);