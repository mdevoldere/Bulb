<?php

namespace Bulb\Local;


class LocalCollection extends Collection
{
    protected $localFile;

    public function __construct(string $_path)
    {
        $this->localFile = new LocalFile($_path);
    }

    public function Exists() : bool
    {
        return $this->localFile->Exists();
    }

    public function Name() : string
    {
        $this->localFile->Name();
    }

    public function Path() : string
    {
        $this->localFile->Path();
    }

    public function Dirname() : string
    {
        $this->localFile->Dirname();
    }

    public function Load()
    {
        if($this->localFile->Exists())
            $this->AddFile($this->localFile->Path());
    }

    public function Save($_data = null) : int
    {
        return $this->localFile->Save($this->ToArray());
    }

    public function AddFile(string $_path) : bool
    {
        if(\is_file($_path))
        {
            try
            {
                $a = (require $_path);
                // exporter($a, 'aaa');
                if(\is_array($a))
                    $this->Update($a);
                return true;
            }
            catch (\Exception $e)
            {
                \trigger_error($e->getMessage(), E_USER_ERROR);
                return false;
            }
        }

        return false;
    }


}