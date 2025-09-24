<?php
namespace App\Common\DTOs;

use JsonSerializable;

class DiscordMessageDto implements JsonSerializable
{
    protected const DESCRIPTION_LINES_LIMIT = 5;
    protected const LEFT_BORDER_COLOR = 'FF3E3E';

    protected $title;
    protected $url;
    protected $description;
    protected $fields;
    protected $footer;
    protected $thumbnail;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $this->shortDescription($description);
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function getFooter()
    {
        return $this->footer;
    }

    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    public function jsonSerialize()
    {
        return [
            'tts' => false,
            'file' => null,
            'embeds' => [
                [
                    'type' => 'rich',
                    'color' => hexdec(self::LEFT_BORDER_COLOR),
                    'title' => $this->getTitle(),
                    'url' => $this->getUrl(),
                    'description' => $this->getDescription(),
                    'thumbnail' => [
                        'url' => $this->getThumbnail()
                    ],
                    'fields' => $this->getFields(),
                    'footer' => $this->getFooter(),
                    'timestamp' => date('c', strtotime('now'))
                ]
            ]
        ];
    }

    private function shortDescription($description)
    {
        return implode("\n", array_slice(explode("\n", $description), 0, self::DESCRIPTION_LINES_LIMIT));
    }
}