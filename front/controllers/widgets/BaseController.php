<?php

namespace front\controllers\widgets;

/**
 * Abstract class for all front parts of widgets.
 *
 * @package front\controllers\widgets
 */
abstract class BaseController
{
    /**
     * Widgets directory
     */
    const WIDGET_DIR = '@front/widgets';

    /**
     * Parse widget shortcode and return widget html
     *
     * @param string $shortcode
     *
     * @return string
     */
    public static function handle($shortcode)
    {
        return '';
    }

    /**
     * Get widget alias from shortcode
     *
     * @param string $shortcode
     *
     * @return bool|string
     */
    public static function getAlias($shortcode)
    {
        return preg_match('/(.*)alias="([^"]*)".*/', $shortcode, $alias) === 1 ? $alias : false;
    }

    /**
     * Get widget params from shortcode
     *
     * @param string $shortcode
     *
     * @return bool|array|string|\stdClass
     */
    public static function getParams($shortcode)
    {
        return preg_match("/(.*)params='([^']*)'(.*)/", $shortcode, $params) === 1 ? json_decode($params[2]) : false;
    }

}