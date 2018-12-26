<?php

namespace Bulb\Http\Exception;


class Exception extends \Exception
{

    public static function err($no, $str, $file, $line)
    {
        $e = new Exception($str, $no);
        $e->setFile($file, $line);
        $e->kill();
    }

    public static function exc(\Throwable $exception)
    {
        $e = new Exception($exception->getMessage(), $exception->getCode());
        $e->setFile($exception->getFile(), $exception->getLine());
        $e->kill();
    }

    protected static function getHtml()
    {
        return \file_get_contents(__DIR__.'/Exception.html');
    }

    protected static function setVar($key, $value, &$html)
    {
        $html = \str_replace('{$'.$key.'}', $value, $html);
    }


    protected $message = 'Unknow Error';
    protected $code = 0;
    protected $file;
    protected $line;

    protected $_color = '#f0ead8';

    public function __construct($message = null, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function setFile($file, $line = 0)
    {
        $this->file = $file;
        $this->line = \intval($line);
    }

    public function getTitle()
    {
        switch($this->code){
            case E_USER_ERROR : // 256 Fatal
                $this->_color = '#ff4d4d';
                return 'Fatal Error';
                break;
            case E_USER_WARNING : // Warning
                $this->_color = '#ff8c1a';
                return 'Warning';
                break;
            case E_USER_NOTICE : // Notice
                $this->_color = '#b3b3ff';
                return 'Notice';
                break;
            default:
                return 'Error';
                break;
        }
    }

    public function kill()
    {
        $html = static::getHtml();
        static::setVar('title', $this->getTitle(), $html);
        static::setVar('color', $this->_color, $html);
        static::setVar('code', $this->code, $html);
        static::setVar('message', $this->message, $html);
        static::setVar('file', basename($this->file), $html);
        static::setVar('line', $this->line, $html);
        static::setVar('dump',
            ((str_replace(["\r\n", "\r", "\n"], '<br>', $this->getTraceAsString().'<a href="#" onclick="Javascript:history.go(-1);">Go Back</a>'))), $html); // $this->getTraceAsString()._exporter(Loader::getLoaded(), '_autoLoad')
        exit($html);
    }

}