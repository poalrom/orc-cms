<?php

namespace admin\interfaces\core;

/**
 * Entity interface for admin panel
 *
 * @package admin\interfaces\core
 */
interface AdminEntityInterface
{
    /**
     * Save entity with route and translations
     *
     * @param \yii\db\ActiveRecord[]       $translations Translations array
     * @param \common\models\core\ar\Route $route Route model
     * @param array                        $params Additional params
     *
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function fullSave(&$translations, &$route, &$params = []);

    /**
     * Delete entity with route and translations
     *
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function fullDelete();
}