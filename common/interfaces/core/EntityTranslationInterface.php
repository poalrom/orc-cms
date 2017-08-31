<?php
namespace common\interfaces\core;

/**
 * Interface for entity translation models
 *
 * @package common\interfaces\core
 */
interface EntityTranslationInterface
{
    /**
     * Is translation empty?
     *
     * @return boolean
     */
    public function isEmpty();
}