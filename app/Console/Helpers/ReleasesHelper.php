<?php
namespace App\Console\Helpers;

class ReleasesHelper
{
    private const VALID_PATTERN = '/^(January|February|March|April|May|June|July|August|September|October|November|December) \d{1,2}, \d{4}$/';
    private const VALID_STATUS = 'Confirmed';

	public function isValid($dateString, $status)
    {
        return preg_match(self::VALID_PATTERN, $dateString) and $status === self::VALID_STATUS;
    }

    private const VALID_STEAM_PATTERN = '/^\d{1,2}\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec),\s\d{4}$/';
    private const VALID_STEAM_PATTERN_ALTERNATIVE = '/^(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s\d{1,2},\s\d{4}$/';

    public function isValidForSteam($dateString)
    {
        return preg_match(self::VALID_STEAM_PATTERN, $dateString) or preg_match(self::VALID_STEAM_PATTERN_ALTERNATIVE, $dateString);
    }
}