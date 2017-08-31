<?php

namespace common\components;

use common\models\core\ar\Lang;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Language component
 *
 * @package front\components\core
 */
class LanguageComponent
{
    /**
     * Current language
     *
     * @var null|Lang
     */
    static private $_current = null;

    /**
     * All languages
     *
     * @var null|Lang[]
     */
    static private $_all = null;

    /**
     * Array contains all languages using format: id => name
     *
     * @return array
     */
    public static function getLanguageList()
    {
        return ArrayHelper::map(static::getAll(), 'id', 'name');
    }

    /**
     * Get current language
     *
     * @return Lang
     */
    public static function getCurrent()
    {
        if (static::$_current === null) {
            static::$_current = static::getDefault();
        }

        return static::$_current;
    }

    /**
     * Get all languages
     *
     * @return Lang[]
     */
    public static function getAll()
    {
        if (static::$_all === null) {
            static::$_all = Lang::find()->all();
        }

        return static::$_all;
    }

    /**
     * Get default lang
     *
     * @return Lang
     */
    public static function getDefault()
    {
        return array_pop(array_filter(static::getAll(), function($lang) {
            /** @var Lang $lang */
            return $lang->is_default;
        }));
    }

    /**
     * Set language for current request
     *
     * @param string|Lang|null $data Language URL or Lang AR model. Can be null, if you want to set default language
     *
     * @return Lang
     */
    public static function setCurrent($data = null)
    {
        if ($data instanceof Lang) {
            static::$_current = $data;
        } elseif (is_string($data)) {
            static::$_current = static::getLangByUrl($data);
        } else {
            static::$_current = LanguageComponent::getDefault();
        }
        Yii::$app->language = static::$_current->local;

        return static::$_current;
    }

    /**
     * Get language by url
     *
     * @param string $url Language URL
     *
     * @return null|Lang
     */
    public static function getLangByUrl($url)
    {
        return array_pop(array_filter(static::getAll(), function($lang) use ($url) {
            /** @var Lang $lang */
            return $lang->url === $url;
        }));
    }
}