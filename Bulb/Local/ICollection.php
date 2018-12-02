<?php
/**
 * Bulb\Local\ICollection
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
 * Interface ICollection
 * @package Bulb\Local
 */
interface ICollection extends IModel
{
    /**
     * Empty current ICollection
     * @return $this
     */
    public function clear();

    /**
     * Current ICollection items count
     * @return int
     */
    public function count() : int;

    /**
     * Delete item in current ICollection using $_filter
     * @param null $_filter
     * @return bool
     */
    public function remove($_filter = null) : bool;

}