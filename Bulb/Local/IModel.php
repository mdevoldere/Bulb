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
 * Interface IModel
 * Describe Base Bulb Model Interface
 * @package Bulb\Local
 */
interface IModel
{

    /**
     * Current IModel Unique ID
     * @return int
     */
    public function getId() : int;

    /**
     * Current IModel NAME. Typically a simple and explicit name
     * @return string
     */
    public function getName() : string;

    /**
     * Is current IModel registered. Typically registered if ID > 0 (ID > 0 usually means that the object is already saved somewhere such as a database).
     * @return bool
     */
    public function isRegistered() : bool;

    /**
     * Is current IModel valid. Typically valid if all of its properties are correctly filled.
     * @return bool
     */
    public function isValid() : bool;

    /**
     * Find an item in current IModel using $_key
     * @param int|string $key item Key
     * @param mixed|null $_default Default value
     * @return mixed|null Item value if $_key found. $_default instead.
     */
    public function find($key, $_default = null);

    /**
     * Get All current Model items as an array
     * @param null|mixed $_filter Allows to filter items to recover
     * @return array
     */
    public function findAll($_filter = null) : array;

    /**
     * Update current IModel item with new value
     * @param int|string $_key item Key
     * @param null $_value new value to apply
     * @param bool $_force set to false allows to protect write operations in specific context
     * @return bool
     */
    public function update($_key, $_value = null, bool $_force = true) : bool;

    /**
     * Update properties of current IModel using $_collection. typically call above method update(key, value) for each item in $_collection
     * @param array|IModel $_collection where each key is an item key in current IModel
     * @param bool $_force set to false allows to protect write operations in specific context
     * @return bool
     */
    public function updateAll($_collection = [], bool $_force = true) : bool;

    /**
     * Returns current IModel as string.
     * @param null|mixed $_filter
     * @return string
     */
    public function toString($_filter = null) : string;

}