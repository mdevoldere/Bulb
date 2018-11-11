<?php

namespace Bulb\Local;


class LocalFile extends Local
{

    /** @var null|Collection $collection */
    protected $collection = null;

    /**
     * LocalFile constructor.
     * @param string $_path
     */
    public function __construct(string $_path)
    {
        parent::__construct($_path);

        if(!LocalDir::isDir(\dirname($_path), false))
            exit('LocalFile::InvalidFileDir');

        $this->path = $_path;

        $this->exists = \is_file($this->path);
    }

    /**
     * @return null|string
     */
    public function getContent()
    {
        if($this->exists)
            return (\file_get_contents($this->path));

        return null;
    }

    /**
     * @param string $_data
     * @return int
     */
    public function saveContent(string $_data = null) : int
    {
        if(empty($_data))
            $_data = '';

        try
        {
            $r = \file_put_contents($this->path, $_data);
            $this->exists = true;
            return (($r !== false) ? $r : 0);
        }
        catch (\Exception $e)
        {
            return 0;
        }
    }

    /**
     * @return array
     */
    public function getArray() : array
    {
        return $this->getCollection()->findAll();
    }

    /**
     * @return Collection
     */
    public function getCollection() : Collection
    {
        if($this->collection === null)
        {
            try
            {
                $a = (($this->exists) ? (require $this->path) : []);
                $this->collection = new Collection((\is_array($a) ? $a : []));
            }
            catch (\Exception $e)
            {
                exit('LocalFile::InvalidCollection');
            }
        }

        return $this->collection;
    }

    /**
     * @param bool $_includeMaster
     * @return int
     */
    public function saveCollection(bool $_includeMaster = false) : int
    {
        $this->getCollection();
        return $this->saveContent(('<?php return '.\var_export($this->collection->findAll($_includeMaster), true).';'));
    }

    public function delete()
    {
        if($this->exists)
            $this->exists = !(\unlink($this->path));

        return !$this->exists;
    }

    /**
     * @param string $_path
     * @return bool
     */
    public function copyTo(string $_path) : bool
    {
        $_path = new LocalFile($_path);
        return ($this->exists ? \copy($this->path, $_path->getPath()) : false);
    }

}