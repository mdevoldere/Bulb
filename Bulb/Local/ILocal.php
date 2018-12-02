<?php


namespace Bulb\Local;

/**
 * Interface ILocal
 * Describe IModel directory|file
 * @package Bulb\Local
 */
interface ILocal
{

    /**
     * Is current ILocal exists.
     * @return bool
     */
    public function isValid() : bool;

    /**
     * Get current file NAME.
     * @return string
     */
    public function getName() : string;

    /**
     * Get current file PATH
     * @return string
     */
    public function getPath() : string;

    /**
     * Save $_content in file
     * @param mixed $_data
     * @return int bytes wrote
     */
    public function save($_data) : int;

    /**
     * Delete File or some content if $_filter
     * @param null|mixed $_filter
     * @return bool
     */
    public function remove($_filter = null) : bool;

}