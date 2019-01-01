<?php

namespace Bulb\ViewModels;


use Bulb\App\Model;

class Theme extends Model
{
    public $id = 0;
    /*public $blue = '#007bff';
    public $indigo = '#6610f2';
    public $purple = '#6f42c1';
    public $pink = '#e83e8c';
    public $red = '#dc3545';
    public $orange = '#fd7e14';
    public $yellow = '#ffc107';
    public $green = '#28a745';
    public $teal = '#20c997';
    public $cyan = '#17a2b8';
    public $white = '#fff';
    public $gray = '#6c757d';*/
    public $primary = '#007bff';
    public $secondary = '#6c757d';
    public $success = '#28a745';
    public $info = '#17a2b8';
    public $warning = '#ffc107';
    public $danger = '#dc3545';
    public $light = '#f8f9fa';
    public $dark = '#343a40';

    public function Validate(): bool
    {
        return parent::Validate();
    }
}