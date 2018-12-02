<?php
/**
 * Bulb\Local\IModel
 *
 * Bulb Model Description
 *
 * @category   CategoryName
 * @package    Bulb\Local
 * @author     MDEVOLDERE "Mike"
 * @copyright  2018 MDEVOLDERE "Mike"
 * @license    https://www.gnu.org/licenses/gpl.txt GPL 3
 * @version    1.0.0
 * @link       http://
 */

namespace Bulb\Local;

/**
 * Interface IModel.
 * Describe Base Bulb Model Interface
 * @package Bulb\Local
 */
interface IModel
{

    /**
     * Current IModel Unique ID
     * @return int|string
     */
    public function getId();

    /**
     * Set a new ID to current IModel
     * @param int|string $_id
     * @return $this
     */
    public function setId($_id);

    /**
     * Is current IModel valid. Typically valid if all of its properties are correctly filled.
     * @return bool
     */
    public function isValid() : bool;

    /**
     * Check if current IModel has item named $_key
     * @param string|int $_key
     * @return bool
     */
    public function has($_key) : bool;

    /**
     * Check if current IModel has item named $_key with value === null
     * @param $_key
     * @return bool true if item exists && its value === null. False instead
     */
    public function hasNull($_key) : bool;

    /**
     * Find an item in current IModel using $_key
     * @param int|string $_pattern item Key
     * @param mixed $_filter Default value
     * @return mixed Item value if $_key found. $_default instead.
     */
    public function find($_pattern, $_filter = null);

    /**
     * Get All current Model items as an array
     * @param null|mixed $_filter Allows to filter items to recover
     * @return array
     */
    public function findAll($_filter = null) : array;

    /**
     * @param string|int $_key
     * @param null $_value
     * @return bool
     */
    public function insert($_key, $_value = null) : bool;

    /**
     * Update current IModel item with new value
     * @param int|string $_pattern item Key
     * @param null $_filter new value to apply
     * @return bool
     */
    public function update($_pattern, $_filter = null) : bool;

    /**
     * Returns current IModel as string.
     * @param null|mixed $_filter
     * @return string
     */
    public function toString($_filter = null) : string;

}