<?php

namespace Bulb\App;

/**
 * Class Model
 * @package Bulb\Local
 */
interface IModel
{
    /** Get all Model keys/values as array. Values are returned "as it".
     * @return array
     */
    public function FindAll() : array;

    /** Get all Model keys/values as array. Values using "Model class" are converted to array
     * @return array
     */
    public function ToArray() : array;

}