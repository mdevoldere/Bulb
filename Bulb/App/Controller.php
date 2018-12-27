<?php

namespace Bulb\App;

use Bulb\Http\Http;
use Bulb\Http\Session;

class Controller
{
    /** @var App  */
    protected $app;

    protected $post;

    protected $vars = [];

    public function __construct(App $app)
    {
        $this->app = $app;

        $app->View()->Layout($app->Config()->Find('theme'));

        $app->View()->Body($app->Route()->Action());

        $this->post = Http::Post();

        $this->init();
    }

    protected function init()
    {

    }

    protected function RequestId()
    {
        return $this->app->Route()->Id();
    }

    protected function auth(string $redir_controller = '', string $redir_action = '')
    {
        if(!Session::auth())
        {
            if(empty($redir_controller))
                $redir_controller = 'Home';

            if(empty($redir_action))
                $redir_action = 'index';

            $this->app->Route()->redirectTo($redir_controller, $redir_action);
        }

        //exiter($_SESSION);

        return true;
    }

    public function setVar($key, $value)
    {
        $this->vars[$key] = $value;
        return $this;
    }

    protected function view()
    {
       //\exiter($this);

        return $this->app->View()->Render([
            'request' => $this->app->Route()->Route(),
            'response' => $this->vars,
            'site' => $this->app->Config()->ToArray(),
            'session' => $_SESSION,
        ]);
    }

    protected function json()
    {
        return \json_encode([
            'request' => $this->app->Route()->Route(),
            'response' => $this->vars,
        ]);
    }

    public function indexAction()
    {
        return 'Hello World !';
    }
}