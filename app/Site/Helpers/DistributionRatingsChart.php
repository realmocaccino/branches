<?php
namespace App\Site\Helpers;

use App\Common\Helpers\ScoreHelper;

class DistributionRatingsChart
{
	protected $ratings;
	
	public function __construct($ratings)
	{
		$this->ratings = $ratings;
	}
	
	public function build()
	{
		if($this->ratings->count()) {
			return view('site.helpers.distributionRatingsChart', [
				'bars' => $this->handleBars()
			])->render();
		}
		
		return null;
	}
	
	protected function handleBars()
	{
		$bars = [];
		$percentage = round(100 / $this->ratings->count(), 3);
		$totalWidth = 0;
		
		foreach(array_count_values($this->getRatingsAsClassesNames()) as $className => $total) {
			$width = floor($total * $percentage);
			$totalWidth += $width;
			
			$bars[$className] = ['width' => $width, 'total' => $total];
		}
		
		if($totalWidth < 100) {
			$equalRest = (100 - $totalWidth) / count($bars);
			
			foreach($bars as &$bar) {
				$bar['width'] += $equalRest;
			}
		}
		
		return $bars;
	}
	
	protected function getClassName($score) 
	{
		foreach(ScoreHelper::$ranges as $range) {
			if($score >= $range['startScore'] and $score <= $range['endScore']) return $range['className'];
		}
	}
	
	protected function getRatingsAsClassesNames()
	{
		$classesNames = [];
		
		foreach($this->ratings as $rating) {
			$classesNames[] = $this->getClassName($rating->score);
		}
		
		return $classesNames;
	}
}