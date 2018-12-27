<?php

namespace Bulb\ViewModels;


use Bulb\App\ViewModel;

class Message extends ViewModel
{
    public $author;

    public $authorEmail;

    public $authorPhone;

    public $message;

    public $date;

    public $read = 0;

    public $response = 0;


    public function __construct($_values = [])
    {
        $this->date = \date('d-m-y H:i');

        parent::__construct($_values);
    }

    public function Validate(): bool
    {
        if(empty($this->author)
            || !\filter_var($this->authorEmail, FILTER_VALIDATE_EMAIL)
            || empty($this->message)
        )
            return false;

        if(empty($this->name))
            $this->name = 'Message';

        if(empty($this->authorPhone))
            $this->authorPhone = '0';

        return parent::Validate();
    }
}