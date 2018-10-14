<?php

namespace Bulb\MVC;

use Bulb\MVC\ViewModel\Page;
use Bulb\MVC\ViewModel\PageLayout;

class Controller
{
    /** @var App  */
    protected $app;

    /** @var  Layout */
    protected $layout;

    protected $vars = [];

    public function __construct(App $app)
    {
        $this->app = $app;

        $this->layout = $this->app->createLayout();

        $this->layout->setBody($this->app->getRequest()->getAction());

        $this->init();
    }

    protected function init()
    {

    }

    public function setVar($key, $value)
    {
        $this->vars[$key] = $value;

    }

    protected function view()
    {
        $this->app->getView()->addGlobal('layout', $this->layout);
        $this->app->getView()->addGlobal('site', $this->app->getConfig()->getItems());

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