<?php
namespace App\Common\Helpers;

use StdClass;

use App\Common\Models\Settings;
use App\Common\Helpers\Support;

class Head {
	
	protected $settings;
	private $title;
	private $internalTitle;
	private $description;
	private $styles = [];
	private $scripts = [];
	private $image;
	private $facebookId;
	private $robots;
	
	public function __construct() {
		$this->settings = Settings::find(1);
	}
	
	public function getTitle($sanitize = false)
	{
		if($sanitize) {
			return strip_tags(str_replace('"', '&quot;', $this->title));
		} else {
			return $this->title;
		}
	}
	
	public function getInternalTitle()
	{
		return $this->internalTitle ?? $this->title;
	}
	
	public function getFullTitle($sanitize = false)
	{
		return ($this->title ? $this->getTitle($sanitize) . ' - ' : null) . $this->settings->name . ((!$this->title and $this->settings->description) ? ' - ' . $this->settings->description : null);
	}
	
	public function getDescription()
	{
		return ($this->description ?? $this->settings->description);
	}
	
	public function getStyles()
	{
		return $this->styles;
	}
	
	public function getScripts()
	{
		return $this->scripts;
	}
	
	public function getImage()
	{
		return $this->image;
	}
	
	public function getFacebookId()
	{
		return $this->facebookId;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function setInternalTitle($internalTitle)
	{
		$this->internalTitle = $internalTitle;
	}
	
	public function setDescription($description)
	{
		$this->description = $description;
	}
	
	public function enableSearchIndexing()
	{
		$this->robots = true;
	}
	
	public function disableSearchIndexing()
	{
		$this->robots = false;
	}
	
	public function isSearchIndexingDisabled()
	{
		return !($this->robots ?? $this->settings->robots);
	}
	
	public function addStyle($style)
	{
		$this->styles[] = $this->checkForAbsolutePath($style, 'css');
	}
	
	public function addScript($script)
	{
		$this->scripts[] = $this->checkForAbsolutePath($script, 'js');
	}
	
	public function addStyles($styles = [])
	{
		foreach($styles as $style) {
			$this->styles[] = $this->checkForAbsolutePath($style, 'css');
		}
	}
	
	public function addScripts($scripts = [])
	{
		foreach($scripts as $script) {
			$this->scripts[] = $this->checkForAbsolutePath($script, 'js');
		}
	}
	
	public function setImage($url, $width, $height)
	{
		$this->image = new StdClass;
		$this->image->url = $url;
		$this->image->width = $width;
		$this->image->height = $height;
	}
	
	public function setFacebookId($facebookId)
	{
		$this->facebookId = $facebookId;
	}
	
	public function checkForAbsolutePath($asset, $directory)
	{
		return Support::isAbsolute($asset) ? $asset : asset($directory . '/' . $asset);
	}
}
