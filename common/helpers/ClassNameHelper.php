<?php

namespace common\helpers;

use yii\helpers\Inflector;

/**
 * Helper for transform classnames
 *
 * @package common\helpers
 */
class ClassNameHelper
{
    /**
     * Get short classname using reflection
     * For example, admin\controllers\core\MainController transform MainController.
     *
     * @param string $classname Full classname
     * @param bool   $camelCase Should be classname transformed to camelCase
     *
     * @return string Название класса.
     */
    public static function getShortName($classname, $camelCase = false)
    {
        $reflection = new \ReflectionClass($classname);
        $classname = $reflection->getShortName();
        if ($camelCase) {
            $classname = Inflector::camelize($classname);
        }

        return $classname;
    }

    /**
     * Get full class name from path. Path must be absolute
     * For example /var/www/user001/data/www/site.ru/admin/controllers/core/LoginController.php
     * transform to admin\controllers\core\LoginController
     *
     * @param string $path Path to class file
     *
     * @return string
     */
    public static function getFullClassFromPath($path)
    {
        return str_replace([\Yii::getAlias('@root'), '.php', '/'], ['', '', '\\'], $path);
    }


}