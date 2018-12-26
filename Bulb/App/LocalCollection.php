<?php

namespace Bulb\App;


class LocalCollection extends Collection
{

    protected $localFile;

    public function __construct(string $_path)
    {
        $this->localFile = new LocalFile($_path);
    }

    public function File() : LocalFile
    {
        return $this->localFile;
    }

    public function Load($_filename = null) : array
    {
        if(!empty($_filename))
            Local::LoadFile($_filename, $this);
        else
            Local::LoadFile($this->localFile->Path(), $this);

        return $this->items;
    }

    public function Save() : int
    {
        if(!empty($this->items))
        {
            return $this->localFile->Save($this->ToArray());
        }


        return 0;
    }

}