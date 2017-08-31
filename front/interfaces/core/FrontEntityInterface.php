<?php

namespace front\interfaces\core;

/**
 * Entity interface for front app
 *
 * @property \common\models\core\ar\Route $route Route model.
 *
 * @package front\interfaces\core
 */
interface FrontEntityInterface
{
    /**
     * Check that entity can be displayed using this url
     *
     * @param string $url Url for checking
     *
     * @return bool
     */
    public function checkUrl($url);

    /**
     * Get url to entity starting with slash
     *
     * @return string
     */
    public function getUrl();

    /**
     * Parent tree for entity without sorting
     *
     * @return \yii\db\ActiveRecord[]
     */
    public function getParentTree();

    /**
     * Related route
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoute();
}