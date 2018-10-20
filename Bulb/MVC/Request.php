<?php

namespace Bulb\MVC;

use Bulb\Tools\Collection;
use Bulb\Tools\Utils;


class Request
{
    const DEFAULT_GET_KEY = 'url';

    const DEFAULT_CONTROLLER = 'home';

    const DEFAULT_ACTION = 'index';

    const DEFAULT_ID = null;

    /** @var  Request */
    protected static $mainRequest;

    /**
     * Get Main Request
     * @return Request
     */
    public static function getRequest() : Request
    {
        if(self::$mainRequest === null)
            self::$mainRequest = new Request();

        return self::$mainRequest;
    }

    /**
     * Get Item from $_GET or $_GET array if no key specified
     * returns null if no result
     * @param null $key
     * @param null $subkey
     * @return mixed|null
     */
    public static function get($key = null, $subkey = null)
    {
        return !empty($_GET) ? Collection::getArrayItem($_GET, $key, $subkey) : null;
    }

    /**
     * Get Item from $_POST or $_POST array if no key specified
     * returns null if no result
     * @param null $key
     * @param null $subkey
     * @return mixed|null
     */
    public static function post($key = null, $subkey = null)
    {
        return !empty($_POST) ? Collection::getArrayItem($_POST, $key, $subkey) : null;
    }

    /**
     * Get Item from $_FILES or $_FILES array if no key specified
     * returns null if no result
     * @param null $key
     * @param null $subkey
     * @return mixed|null
     */
    public static function files($key = null, $subkey = null)
    {
        return !empty($_FILES) ? Collection::getArrayItem($_FILES, $key, $subkey) : null;
    }

    /**
     * Get Item from $_SESSION or $_SESSION array if no key specified
     * returns null if no result
     * @param null $key
     * @param null $subkey
     * @return mixed|null
     */
    public static function session($key = null, $subkey = null)
    {
        return !empty($_SESSION) ? Collection::getArrayItem($_SESSION, $key, $subkey) : null;
    }

    protected $baseUrl = '';

    /** @var string  */
    protected $controller = self::DEFAULT_CONTROLLER;

    /** @var string  */
    protected $action = self::DEFAULT_ACTION;

    /** @var null|int|string  */
    protected $id = self::DEFAULT_ID;

    /** @var string  */
    protected $path = '/';

    /***** GETTERS *****/

    /**
     * @param $suffix
     * @return string
     */
    public function getController(string $suffix = null)
    {
        return $this->controller.$suffix;
    }

    /**
     * @param $suffix
     * @return string
     */
    public function getAction(string $suffix = null)
    {
        return $this->action.$suffix;
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
     */
    public function getUrl()
    {
        return $this->baseUrl.$this->path;
    }


    /**
     * Request constructor.
     * @param $_baseUrl
     */
    public function __construct(string $_baseUrl = '')
    {
        $this->baseUrl = $_baseUrl;
        $this->_setUrl(self::get(self::DEFAULT_GET_KEY));
    }

    protected function _setUrl($route = null)
    {
        if($route !== null)
        {
            try
            {
                if(!\is_array($route))
                {
                    $route = \explode('/', $route);
                }

                $this->_setPath(
                    (!empty($route[0]) ? $route[0] : null),
                    (!empty($route[1]) ? $route[1] : null),
                    (!empty($route[2]) ? $route[2] : null)
                );
            }
            catch(\Exception $e)
            {
                $this->_setPath();
            }
        }


        return $this;
    }

    protected function _setPath(string $controller = null, string $action = null, $id = null)
    {
        $this->controller   = Utils::cleanLower($controller, static::DEFAULT_CONTROLLER);
        $this->action       = Utils::cleanLower($action, static::DEFAULT_ACTION);
        $this->id           = Utils::cleanLower($id, static::DEFAULT_ID);

        $this->path         = ('/'.$this->controller.'/'.$this->action.(!empty($this->id) ? '/'.$this->id : ''));

        return $this;
    }


    /*public function parseUrl()
        {
            \parse_str($_SERVER['QUERY_STRING'], $this->query);

            if(\array_key_exists('url', $this->query))
            {
                $this->setRoute($this->query['url']);
            }

            return $this;
        }*/
    
}