<?php

namespace Saitama\Model\FreespaceContent;

class Shop
{
    private $url;

    private $name;
    
    public function __construct(string $url = null, string $name = null)
    {
        $this->url = $url;
        $this->name = $name;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}