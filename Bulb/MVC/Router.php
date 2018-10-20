<?php

namespace Bulb\MVC;

class Router
{

    const DEFAULT_APP_NAMESPACE = 'BulbApp';

    const DEFAULT_GET_KEY = 'url';


    /**
     * Router constructor.
     */
    private function __construct()
    {

    }


    public static function go($prefix = '')
    {
        if(!\headers_sent())
        {
            \header(('location: '.$prefix.Request::getRequest()->getPath()));
            exit();
        }
    }

    public static function getController(App $app)
    {
        try
        {
            $cName = self::DEFAULT_APP_NAMESPACE.'\\'.$app->getName().'\\Controllers\\'.\mb_convert_case($app->getRequest()->getController('Controller'), MB_CASE_TITLE);

            $a = ($app->getRequest()->getAction('Action'));

            /** @var Controller $cName */
            $c = (new $cName($app));

            if(!\method_exists($c, $a))
            {
                throw new \InvalidArgumentException('Bulb Router Error: Invalid action ['.$app->getRequest()->getAction().'] !');
            }

            return $c;
        }
        catch (\Exception $e)
        {
            exit('Bulb Router Fatal Error: '.$e->getCode());
        }
    }

    public static function getResponse(Controller $c)
    {

    }


}