<?php


namespace Bulb\Local;

/**
 * Interface ILocal
 * Describe a IModel directory|file
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
     * Get the file path
     * @return string
     */
    public function getPath() : string;

    /**
     * Save $_content in file
     * @param null|mixed $_data
     * @return int
     */
    public function save($_data = null) : int;

    /**
     * Delete File or some content if $_filter
     * @param null|mixed $_filter
     * @return bool
     */
    public function delete($_filter = null) : bool;

}