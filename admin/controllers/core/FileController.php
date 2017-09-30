<?php

namespace admin\controllers\core;

use alexantr\elfinder\CKEditorAction;
use alexantr\elfinder\ConnectorAction;
use alexantr\elfinder\InputFileAction;
use mihaildev\elfinder\PathController;
use Yii;
use yii\web\Controller;

/**
 * Class for file uploader
 * @see https://github.com/MihailDev/yii2-elfinder
 *
 * @package admin\controllers\core
 */
class FileController extends PathController
{

    const ADMIN_FILE_ROUTE = 'core/file';

    public $root = [
        'path' => 'uploads',
        'name' => 'Uploads'
    ];

    /**
     * Dynamic route to all file actions
     */
    const FILE_ROUTE = 'core/file/<action>';
}