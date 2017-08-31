<?php

namespace common\components;

use common\models\core\ar\Widget;

/**
 * Component for parsing widgets and replace shortcodes with widget html
 *
 * @package common\components
 */
class WidgetParser
{
    /**
     * Parse widget shortcodes
     *
     * @param string $content Content for parsing
     *
     * @return string
     */
    public static function parse($content)
    {
        preg_match_all("/\[{widget ([a-zA-Z0-9-_]+)([^}]*)}\]/", $content, $widgets);
        if (!count($widgets)) {
            return $content;
        }
        /** @var Widget[] $installedWidgets */
        $installedWidgets = Widget::find()->indexBy('alias')->all();
        foreach ($widgets[0] as $key => $widget) {
            if (key_exists($widgets[1][$key], $installedWidgets)) {
                /** @var \front\controllers\widgets\BaseController $widgetClassName */
                $widgetClassName = $installedWidgets[$widgets[1][$key]]->front_controller;
                if (!class_exists($widgetClassName)) {
                    continue;
                }
                $html = $widgetClassName::handle($widget);
                $content = str_replace($widget, $html, $content);
            }
        }

        return $content;
    }
}
