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

        $this->layout = $this->app->Layout();

        $this->layout->Body($this->app->Request()->Action());

        $this->id = $this->app->Request()->Id();

        $this->init();
    }

    protected function init()
    {

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
                $redir_controller = 'Home';

            if(empty($redir_action))
                $redir_action = 'index';

            $this->app->Request()->redirectTo($redir_controller, $redir_action);
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
        $this->app->View()->addGlobal('layout', $this->layout);
        $this->app->View()->addGlobal('session', $_SESSION);
        $this->app->View()->addGlobal('site', $this->app->Config()->FindAll());

        return $this->app->View()->render(
            $this->layout->getTheme(),
            [
                'response' => $this->vars,
            ]
        );
    }

    protected function json()
    {
        return \json_encode([
            'request' => $this->app->Request()->Path(),
            'response' => $this->vars
        ]);
    }

    public function indexAction()
    {
        return 'Hello World !';
    }
}