<?php
namespace App\Site\Helpers;

class AwardsHelper
{
    private $directory = 'Site/Controllers/Awards/';
    private $suffix = '.php';

    protected $year;
    protected $years;

    public function __construct($year)
    {
        $this->directory = app_path($this->directory);
        $this->year = $year;
        $this->years = $this->setYearsByCheckingFiles();
    }

    public function doesAwardFileExist()
    {
        return in_array($this->year, $this->years);
    }

    public function getAwards()
    {
        return require $this->directory . $this->year . $this->suffix;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getYears()
    {
        return $this->years;
    }

    private function setYearsByCheckingFiles()
    {
        return array_reverse(array_map(function($file) {
            return basename($file, $this->suffix);
        }, glob($this->directory . '/*' . $this->suffix)));
    }
}