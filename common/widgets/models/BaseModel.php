<?php

namespace common\widgets\models;

use common\models\core\ar\EntityModel;

/**
 * Base class for widget models
 *
 * @package common\widgets\models
 */
abstract class BaseModel extends EntityModel
{

    /**
     * Get current widget short code with some params
     *
     * @param array $params Params for short code
     *
     * @return string
     */
    public abstract function getShortCode($params = []);
}