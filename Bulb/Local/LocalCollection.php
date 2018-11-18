<?php


namespace Bulb\Local;


class LocalCollection extends Collection
{

    /** @var LocalDir */
    protected $path;

    /** @var LocalFile */
    protected $file;

    public function __construct(string $_path, string $_file = '')
    {
        parent::__construct();

        $this->path = Local::getLocalDir($_path);

        if(!$this->path->isExists())
        {
            \trigger_error('LocalCollection::Invalid['.$this->path->getName().']', E_USER_WARNING);
        }

        if(!empty($this->file))
        {
            $this->file = $this->path->getFile($_file);
        }

        $this->load();
    }

    public function load()
    {
        return $this;
    }
}