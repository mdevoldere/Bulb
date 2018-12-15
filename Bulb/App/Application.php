<?php

namespace Bulb\App;

use Bulb\Http\Request;

/**
 * Class App
 * @package Bulb\MVC
 */
class Application extends App
{
    const DEFAULT_NAMESPACE = 'BulbApp';

    /** @var Request */
    protected $request = null;

    /** @var View */
    protected $view = null;

    /**
     * @param string $_path
     * @param string $_instance
     * Constructor
     */
    public function __construct(string $_path, ?string $_instance = null)
    {
        parent::__construct($_path, $_instance);

        $this->Request();
    }

    /**
     * @return Request
     */
    public function Request() : Request
    {
        if($this->request === null)
            $this->request = new Request($this->app->Config()->Find('path', '/'));

        return $this->request;
    }

    /**
     * @return View
     */
    public function View() : View
    {
        $this->view = $this->view ?: new View($this->app->Path());
        return $this->view;
    }

    public function Layout() : Layout
    {
        $l = new Layout($this->Config()->Find('theme'));

        $l->Css($this->Config()->Find('css'));

        return $l;
    }

    public function Run()
    {
        try
        {
            $this->View()->addPath($this->Request()->Controller());

            $this->View()->addGlobal('request', $this->request->Route());

            $c = $this->Controller($this->Request()->Controller());

            $c = (new $c($this));

            $a = ($this->Request()->Action().'Action');

            if(!\method_exists($c, $a))
            {
                throw new \InvalidArgumentException('BulbApp::InvalidAction['.$this->Request()->Action().']');
            }

            echo $c->{$a}();
            exit();
        }
        catch(\Exception $ex)
        {
            \exporter($ex, 'Exception');
            \exiter($this, 'App');
        }

        exit('No App to Run');
    }

    public function Link($path)
    {
        return ($this->Config()->Find('url').$path);
    }

}