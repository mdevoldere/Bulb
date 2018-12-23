<?php
/**
 * Created by PhpStorm.
 * User: MDevoldere
 * Date: 23/12/2018
 * Time: 13:00
 */
namespace Bulb\Local;

interface ILocalFile
{
    public function Name(): string;

    public function Path(): string;

    public function Dirname(): string;

    public function Exists(): bool;

    /**
     * @return string
     */
    public function Load();

    /**
     * @param null|mixed $_data
     * @return int
     */
    public function Save($_data = null): int;
}