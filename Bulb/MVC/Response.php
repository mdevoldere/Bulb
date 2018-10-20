<?php

namespace Bulb\MVC;


class Response extends Request
{
    /** @var  Response */
    protected static $mainResponse;

    /**
     * @return Response
     */
    public static function getResponse() : Response
    {
        if(self::$mainResponse === null)
            self::$mainResponse = new Response(self::getRequest());

        return self::$mainResponse;
    }

    /** @var string  */
    protected $mediaType = 'text/html';

    /** @var string  */
    protected $content = '';


    /**
     * @param string $_mediaType
     */
    public function setMediaType(string $_mediaType = 'html')
    {
        switch($_mediaType)
        {
            case 'html':
                $this->mediaType = 'text/html';
                break;
            case 'json':
                $this->mediaType = 'application/json';
                break;
            case 'xml':
                $this->mediaType = 'application/xml';
                break;
            case 'csv':
                $this->mediaType = 'text/csv';
                break;
            case 'text':
                $this->mediaType = 'text/plain';
                break;
            /*case 'pdf':
                $this->mediaType = 'application/pdf';
                break;
            case 'png':
                $this->mediaType = 'image/png';
                break;
            case 'jpg':
                $this->mediaType = 'image/jpeg';
                break;
            case 'zip':
                $this->mediaType = 'application/zip';
                break;*/
            default:
                $this->mediaType = 'text/html';
                break;
        }
    }


    /**
     * Response constructor.
     * @param Request|null $_request
     */
    public function __construct(Request $_request = null)
    {
        if($_request !== null)
            $this->_setPath($_request->controller, $_request->action, $_request->id);
    }

    public function setUrl($route = null)
    {
        $this->_setUrl($route)->redirect();
    }

    public function setPath($controller = null, $action = null, $id = null)
    {
        $this->_setPath($controller, $action, $id)->redirect();
    }

    public function run()
    {
        if(!\headers_sent())
        {
            try
            {
                \header('Content-Type: '.$this->mediaType);
                echo \trim($this->content);
                exit();
            }
            catch (\Exception $e)
            {
                exit($e->getCode().': Bulb Response Fatal Error');
            }
        }
    }

    public function redirect()
    {
        if(!\headers_sent())
        {
            \header('location: '.$this->getUrl());
            exit();
        }
    }
}