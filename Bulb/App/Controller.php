<?php

namespace Bulb\App;

use Bulb\Http\Request;
use Bulb\Http\Router;
use Bulb\Http\Session;

class Controller
{
    /** @var Application  */
    protected $app;

    /** @var  Layout */
    protected $layout;

    protected $vars = [];

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->layout = $this->app->createLayout();

        $this->layout->setBody($this->app->getRequest()->getAction());

        $this->id = $this->app->getRequest()->getId();

        $this->init();
    }

    protected function init()
    {

    }

    protected function getId($default = null)
    {
        if(($this->id === null) && ($default !== null))
            $this->id = $default;

        return $this->id;
    }

    protected function getIdSafe($default = null)
    {
        return \basename($this->getId($default));
    }

    protected function auth(string $redir_controller = '', string $redir_action = '')
    {
        Session::setUsers();

        if(!Session::auth())
        {
            if(empty($redir_controller))
                $redir_controller = Request::DEFAULT_CONTROLLER;

            if(empty($redir_action))
                $redir_action = Router::DEFAULT_ACTION;

            $this->app->getRequest()->goTo($redir_controller, $redir_action);
        }

        //exiter($_SESSION);

        return true;
    }

    public function setVar($key, $value)
    {
        $this->vars[$key] = $value;

    }

    protected function view()
    {
       // exiter($this);
        $this->app->getView()->addGlobal('layout', $this->layout);
        $this->app->getView()->addGlobal('session', $_SESSION);
        $this->app->getView()->addGlobal('site', $this->app->getConfig()->findAll());

        return $this->app->getView()->render(
            $this->layout->getTheme(),
            [
                'response' => $this->vars,
            ]
        );
    }

    protected function json()
    {
        return \json_encode([
            'request' => $this->app->getRequest()->getPath(),
            'response' => $this->vars
        ]);
    }

    public function indexAction()
    {
        return 'Hello World !';
    }
}