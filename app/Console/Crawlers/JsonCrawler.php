<?php
namespace App\Console\Crawlers;

class JsonCrawler
{
    protected $content;
    protected $url;

    public function __construct()
    {}

    protected function load()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);

        $this->setContent($content);
    }

    protected function setContent($content)
    {
        $this->content = $content;
    }

    protected function getContent($associative = false)
    {
        return json_decode($this->content, $associative);
    }

    public function setUrl($url)
    {
		$this->url = $url;
    }

    protected function getUrl()
    {
        return $this->url;
    }

    public function query($selector)
    {
        $this->load();
        
        $content = $this->getContent();

        if(isset($content->{$selector})) {
            return $content->{$selector};
        }

        return null;
    }
}