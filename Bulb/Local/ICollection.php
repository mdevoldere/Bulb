<?php


namespace Bulb\Local;


interface ICollection
{
    /**
     * Master IModel to complete the current ICollection. Usually with elements that may be missing in the current ICollection.
     * @param IModel|null $_masterCollection
     * @return ICollection
     */
    public function setMasterCollection(IModel $_masterCollection = null);

    /**
     * How many items in current ICollection
     * @return int
     */
    public function count() : int;

    /**
     * Empty current ICollection
     * @return ICollection
     */
    public function clear();
}