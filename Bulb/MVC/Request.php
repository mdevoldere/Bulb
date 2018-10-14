<?php

namespace Bulb\MVC;

use Bulb\Tools\Collection;


class Request
{
    public static function cleanLower($value = null, $default = null)
    {
        if($value === null)
        {
            if($default != null)
                $value = $default;
            else
                return null;
        }

        return (\mb_convert_case(\trim(\strip_tags(($value))), MB_CASE_LOWER));
    }
    
    const DEFAULT_CONTROLLER = 'home';

    const DEFAULT_ACTION = 'index';

    const DEFAULT_ID = null;

    protected $controller = self::DEFAULT_CONTROLLER;

    protected $action = self::DEFAULT_ACTION;

    protected $id = self::DEFAULT_ID;

    protected $path = '/';

    protected $url = '/';

    protected $session = [];

    protected $post = [];

    protected $files = [];

    /***** GETTERS *****/

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     * @deprecated
     */
    public function getUrl()
    {
        return $this->path;
    }

    public function getPost($key = null)
    {
        return Collection::getCollection($this->post, $key);
    }

    public function getFiles($key = null)
    {
        return Collection::getCollection($this->files, $key);
    }

    public function getSession($key = null)
    {
        return Collection::getCollection($this->session, $key);
    }



    /***** Request Methods *****/


    /**
     * Request constructor.
     */
    public function __construct()
    {
        if(!empty($_POST))
        {
            $this->post = new Collection($_POST);
        }

        if(!empty($_FILES))
        {
            $this->files = new Collection($_FILES);
        }

        if(!empty($_SESSION))
        {
            $this->session = new Collection($_SESSION);
        }
    }

    public function setRequest($controller = null, $action = null, $id = null)
    {
        $this->controller = static::cleanLower($controller, static::DEFAULT_CONTROLLER);
        $this->action = static::cleanLower($action, static::DEFAULT_ACTION);
        $this->id = static::cleanLower($id, static::DEFAULT_ID);

        $this->path = ('/'.$this->controller.'/'.$this->action.(!empty($this->id) ? '/'.$this->id : ''));

        return $this;
    }

    public function go($prefix = '')
    {
        if(!\headers_sent())
        {
            \header(('location: '.$prefix.$this->getPath()));
            exit();
        }
    }

    
}