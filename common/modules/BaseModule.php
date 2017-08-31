<?php

namespace common\modules;

/**
 * Base module settings class
 * @package common\modules
 */
/**
 * Class BaseModule
 *
 * @package common\modules
 */
abstract class BaseModule
{
    /**
     * @var null|\ReflectionClass
     */
    protected static $reflection = null;

    /**
     * @return \ReflectionClass
     */
    protected static function getReflection()
    {
        if (is_null(static::$reflection)) {
            static::$reflection = new \ReflectionClass(static::class);
        }

        return static::$reflection;
    }

    /**
     * Can url to entity be empty?
     *
     * @return bool
     */
    public static function canUrlBeEmpty()
    {
        return false;
    }

    /**
     * Short name of module
     *
     * @return string
     */
    public static function getModuleName()
    {
        return mb_strtolower(static::getReflection()->getShortName());
    }

    /**
     * Short admin controller name
     *
     * @return string
     */
    public static function getMainAdminControllerName()
    {
        return static::getReflection()->getShortName();
    }

    /**
     * Short front controller name
     *
     * @return string
     */
    public static function getMainFrontControllerName()
    {
        return static::getReflection()->getShortName();
    }

    /**
     * Common model name
     *
     * @return string
     */
    public static function getModelName()
    {
        return static::getReflection()->getShortName();
    }

}