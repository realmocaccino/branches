<?php
namespace App\Console\Crawlers;

use Symfony\Component\DomCrawler\Crawler;

class BaseCrawler
{
    private $crawler;
    private $language;
    private $url;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function getContentFromAllElements($selector, $attribute = null)
    {
        $content = [];

        $this->load();

        $this->crawler->filter($selector)->each(function(Crawler $node) use(&$content, $attribute) {
            $content[] = $attribute ? $node->attr($attribute) : $node->text();
        });

        $this->crawler->clear();

        return $content;
    }

    public function getContentFromElement($selector, $attribute = null)
    {
        $content = null;

        $this->load();

        $nodes = $this->crawler->filter($selector);

        if($nodes->count()) {
            $content = $attribute ? $nodes->first()->attr($attribute) : $nodes->first()->text();
        }
        
        $this->crawler->clear();

        return $content;
    }

    private function getContentFromURL()
    {
        $instance = curl_init();
        curl_setopt($instance, CURLOPT_URL, $this->url);
        curl_setopt($instance, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($instance, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13');
        curl_setopt($instance, CURLOPT_HTTPHEADER, $this->getHeaders());
        $content = curl_exec($instance);
        curl_close($instance);

        return $content;
    }

    public function getHeaders()
    {
        $headers = ['Cookie: birthtime=470682001; lastagecheckage=1-0-1985;'];
        if($this->language) {
            $headers[] = 'Accept-Language: ' . $this->language;
        }
        return $headers;
    }

    public function handleText($text)
    {
        return trim(preg_replace('/[\r\t\n ]+/', ' ', $text));
    }

    public function load()
    {
        $this->crawler->addContent($this->getContentFromURL());
    }

    public function setLanguage(string $language)
    {
        $this->language = $language;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }
}