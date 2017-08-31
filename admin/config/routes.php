<?php

$routes = [];
$routePath = __DIR__ . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR;

foreach (scandir($routePath) as $file) {
    $file = $routePath . $file;
    if (!is_file($file)){
        continue;
    }

    $fileInfo = pathinfo($file);

    if ($fileInfo['extension'] !== 'php'){
        continue;
    }

    $moduleRoute = require($file);
    $routes = array_merge_recursive($routes, $moduleRoute);
}

return $routes;