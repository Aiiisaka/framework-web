<?php
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\session\PhpSession;
use Ubiquity\controllers\Startup;

\Ubiquity\security\csrf\CsrfManager::start();
\Ubiquity\cache\CacheManager::startProd($config);
\Ubiquity\orm\DAO::start();
Router::start();
Router::addRoute("_default", "controllers\\IndexController");
\Ubiquity\assets\AssetsManager::start($config);
