<?php

use Ubiquity\assets\AssetsManager;
use Ubiquity\cache\CacheManager;
use Ubiquity\controllers\Router;
use Ubiquity\orm\DAO;

CacheManager::startProd($config);
DAO::start();
Router::start();
Router::addRoute("_default", "controllers\\IndexController");
AssetsManager::start($config);
