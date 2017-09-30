<?php

namespace admin\helpers;

/**
 * Helper for actions with files
 * @package admin\helpers
 */
class FileHelper extends \yii\helpers\FileHelper
{

    /**
     * Get template list from directory
     *
     * @param string $catalog Path to directory from front "views" folder.
     * For example: "front/views/pages/categories" -> "pages/categories".
     *
     * @return string[]
     */
    public static function getTemplates($catalog)
    {
        $theme = \Yii::$app->params['theme'];
        $dir = \Yii::getAlias('@front') . DIRECTORY_SEPARATOR .
            'views' . DIRECTORY_SEPARATOR .
            $theme . DIRECTORY_SEPARATOR .
            $catalog;
        $list = [];
        if (is_dir($dir)) {
            foreach (glob($dir . '/*') as $file) {
                $pathInfo = pathinfo($file);
                if (isset($pathInfo['extension']) && $pathInfo['extension'] === 'php') {
                    $list[$pathInfo['filename']] = $pathInfo['filename'];
                }
            }
        }

        return $list;
    }

}