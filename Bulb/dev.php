<?php
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
