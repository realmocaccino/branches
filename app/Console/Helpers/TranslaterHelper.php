<?php
namespace App\Console\Helpers;

use App\Console\Exceptions\{TextToTranslateIsEmpty, TextToTranslateWasNotSet};

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslaterHelper
{
    private $termToIgnore;
    private $text;
    private $translater;

    const PLACEHOLDER_TO_KEEP_TERMS = '---';

	public function __construct(GoogleTranslate $translater)
	{
        $this->translater = $translater;
	}

    public function detectLanguage(string $text)
    {
        $this->translater->setSource();
        $this->translater->translate($text);

        return $this->translater->getLastDetectedSource();
    }

    public function ignore(string $term)
    {
        $this->termToIgnore = $term;

        return $this;
    }

    public function isItDesiredLanguage(string $language)
    {
        return strstr($this->detectLanguage($this->text), $language);
    }

    public function setText(string $text)
    {
        $this->text = $text;
        $this->translater->setSource($this->detectLanguage($text));

        return $this;
    }
	
	public function translateTo(string $language)
    {
        if(!isset($this->text)) {
            throw new TextToTranslateWasNotSet();
        }
        
        if(!$this->text) {
            throw new TextToTranslateIsEmpty();
        }

        if($this->isItDesiredLanguage($language)) {
            return $this->text;
        }

        if($this->termToIgnore) {
            return $this->translateIgnoring($language);
        }
        
        return $this->translater->setTarget($language)->translate($this->text);
    }

    private function translateIgnoring(string $language)
    {
        $text = str_ireplace($this->termToIgnore, self::PLACEHOLDER_TO_KEEP_TERMS, $this->text);
        $translatedText = $this->translater->setTarget($language)->translate($text);
        return str_ireplace(self::PLACEHOLDER_TO_KEEP_TERMS, $this->termToIgnore, $translatedText);
    }
}