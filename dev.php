<?php
/**
 * Created by Devoldere.net.
 * User: Mickael DEVOLDERE <support@devoldere.net>
 */

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

$dev_trace = 0;


function devtrace($msg = null)
{
    global $dev_trace;

    echo '--- DEV TRACE '.++$dev_trace.' --- '.$msg;
}

function lineWriter($msg, $prefix = '<br>', $suffix = null)
{
    echo ($prefix.$msg.$suffix);
}

function _exporter($var, $title = null)
{
    $c = ' ('.(is_array($var) ? count($var) : (is_string($var) ? strlen($var) : '')).') '.$title;

    $html = '<style>.devPre { text-align:left; } .devGreen { color: #009900; } .devBlue { color: #0000CC; } .devRed { color: #990000; }</style>';

    $html .= ('<pre class="devPre"><hr /><p><strong style="font-size:20px;">'.gettype($var).$c.'</strong> '.@var_export($var, true).'</p></pre>');

    // <span class="devBlue"></span>

    $html = \str_replace('array', '<span class="devGreen">array</span>', $html);
    $html = \str_replace('object', '<span class="devGreen">object</span>', $html);
    $html = \str_replace('string', '<span class="devGreen">string</span>', $html);
    $html = \str_replace('integer', '<span class="devGreen">integer</span>', $html);
    $html = \str_replace('boolean', '<span class="devGreen">boolean</span>', $html);
    $html = \str_replace('__set_state', '<span class="devRed">__set_state</span>', $html);
    $html = \str_replace('=>', '<span class="devBlue">=></span>', $html);

    return $html;
}

function exporter($var, $title = null)
{
    echo \_exporter($var, $title);
}

function imploder(array $var, $title = null)
{
    echo \_exporter(implode(';', $var), $title);
}

function exiter($var, $title = null)
{
    exit(\_exporter($var, $title));
}
/*
function bulb_error_handler($no, $str, $file, $line)
{
    $e = new \Bulb\Core\Tools\Exception\Exception($str, $no);
    $e->setFile($file, $line);
    $e->kill();
}
*/
/*function bulb_error_handler_old($no, $str, $file, $line)
{
    echo '<h2>Erreur ['.$no.']</h2><ul><li>Fichier : '.$file.'</li><li>Ligne '.$line.'</li></ul>';

    switch($no){
        case E_USER_ERROR : // Fatal
            echo '<h3>Fatal Error</h3><p>'.$str.'</p>';
            exiter(\Bulb\Loader::getLoaded(), 'autoLoad');
            break;
        case E_USER_WARNING : // Warning
            echo '<h3>Warning</h3><p>'.$str.'</p>';
            break;
        case E_USER_NOTICE : // Notice
            echo '<h3>Notice</h3><p>'.$str.'</p>';
            break;
        default:
            echo '<h3>Error</h3><p>'.$str.'</p>';
            exiter(\Bulb\Loader::getLoaded(), 'autoLoad');
            break;
    }
}*/

//\Bulb\Loader::getClass('\\Bulb\\Core\\Tools\\Exception\\Exception');

//set_error_handler(['\\Bulb\\Core\\Tools\\Exception\\Exception', 'err']);
//set_error_handler('bulb_error_handler');
