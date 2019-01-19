<?php

namespace Bulb\Tools;

class Compiler
{


    public static function compileStatic($filename, $version, array $files)
    {
        static::getCompilerDefault();
        static::$compilerDefault->addDir($files, true);
        sleep(1);
        return static::$compilerDefault->compile($filename, $version, true);
    }



    /** @var string $appName */
    protected $appName;

    /** @var string $version */
    protected $version;

    /** @var string $version */
    protected $fileName;

    /** @var array $fileList */
    protected $fileList = [];

    /** @var string $output */
    protected $output;


    public function __construct(string $appName, string $version = '0.0.1', array $src_files = [])
    {
        $this->appName = $appName;

        if(empty($version))
            $version = '0.0.1';

        $this->fileName = ($this->appName.'-'.$version);

        $this->Add($src_files);
    }

    public function Add($src_file)
    {
        if(empty($src_file))
            return $this;

        if(\is_array($src_file))
        {
            foreach ($src_file as $single_file)
            {
                $this->Add($single_file);
            }

            return $this;
        }

        if(!\is_string($src_file))
            return $this;

        if(!\is_file($src_file))
            return $this;

        $this->fileList[$src_file] = \basename($src_file);

        return $this;
    }

    public function MergeFiles()
    {
        if(empty($this->fileList))
            return $this;

        $this->output = null;
        $sTmp = null;

        foreach ($this->fileList as $f => $fName)
        {
            $sTmp = file_get_contents($f);
            static::removePhpKeys($sTmp);
            $this->output .= $sTmp;
        }

        return $this;
    }

    public function compile(string $_path, string $version = '0.0.1', bool $minify = false) : bool
    {
        if(!\is_dir($_path))
            return false;

        $this->MergeFiles();

        if($minify === true)
        {

        }

        if(false !== ($saved = $this->saveFile($filename.$version, '<?php /*** '.date('Y-m-d H:i:s').' ***/'."\n".$data.' ?>'))) {
             if((true === $minify)) {
                sleep(1);
                $this->saveFile($filename.$version.'.min', php_strip_whitespace($this->dest.$filename.$version.'.php'));
            }
        }

        $r = $this->fileList;
        $this->Add([], true);
        return $r;
    }

    public function saveFile(string $_path, string $data)
    {
        try
        {
            \file_put_contents(($_path.'.php'), \trim($data));
        }
        catch(\Exception $ex)
        {
            exit($ex->getMessage());
        }
    }

    public static function removePhpKeys(&$input)
    {
        $len   = strlen($input);
        $start = substr($input, 0, 5);
        $end   = substr($input, ($len-2), 2);

        if('<?php' == $start) {
            $input = substr($input, 5, $len);
        }
        else {
            $start = substr($start, 0, 2);
            if('<?' === $start) {
                $input = substr($input, 2, $len);
            }
        }

        $len = strlen($input);
        if('?>' === $end) {
            $input = substr($input, 0, ($len-2));
        }
    }





}