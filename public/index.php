<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Frederico\Weather\App\App\Router;
use Frederico\Weather\App\Config\Database;
use Frederico\Weather\App\Controller\HomeController;
use Frederico\Weather\App\Controller\PageNotFoundController;

//Initialize Database env
Database::getConnection('prod');

//Home Controller
Router::add('GET', '/', HomeController::class, 'index', []);
Router::add('GET', '/dadus_klima', HomeController::class, 'dadusKlima', []);
Router::add('GET', '/pagenotfound', PageNotFoundController::class, 'index', []);
Router::add('GET', '/mapa', HomeController::class, 'mapa', []);
Router::add('GET', '/dadus_klima/buka', HomeController::class, 'postDadusKlima', []);
Router::add('POST', '/dadus_klima', HomeController::class, 'liveSearch', []);
Router::add('GET', '/konaba', HomeController::class, 'konaba', []);
Router::run();
