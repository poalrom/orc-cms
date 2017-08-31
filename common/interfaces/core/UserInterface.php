<?php

namespace common\interfaces\core;

/**
 * User model interface
 *
 * @package common\interfaces\core
 */
interface UserInterface
{

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getName();

}