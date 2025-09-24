<?php
namespace App\Console\Helpers;

use App\Console\Dictionaries\SteamDictionary;

class SteamTagsHelper
{
    private const RELEVANT_TAGS_PASSING_POSITION_PERCENTAGE = 0.70;
    private const RELEVANT_TAGS_PASSING_SCORE_DIVISOR = 1.4;

    public static function filterIrrelevantTagsByScore($tags)
    {
        $topScore = reset($tags);
        $passingScore = $topScore / self::RELEVANT_TAGS_PASSING_SCORE_DIVISOR;

        return array_keys(array_filter($tags, function ($value) use ($passingScore) {
            return ($value >= $passingScore);
        }));
    }

    public static function filterIrrelevantTagsByPosition($tags)
    {
        $relevantLength = ceil(count($tags) * self::RELEVANT_TAGS_PASSING_POSITION_PERCENTAGE);

        return array_slice($tags, 0, $relevantLength);
    }

    public static function matchClassification($classification)
    {
        return array_search($classification, SteamDictionary::CLASSIFICATIONS);
    }

    public static function matchCharacteristics($tags)
    {
        return array_flip(array_intersect(SteamDictionary::CHARACTERISTICS, $tags));
    }

    public static function matchCollections($tags)
    {
        return array_flip(array_intersect(SteamDictionary::COLLECTIONS, $tags));
    }

    public static function matchGenres($tags)
    {
        return array_flip(array_intersect(SteamDictionary::GENRES, $tags));
    }

    public static function matchModes($modeString)
    {
        return array_keys(array_filter(SteamDictionary::MODES, function($mode) use ($modeString) {
            return strstr($modeString, $mode);
        }));
    }

    public static function matchThemes($tags)
    {
        return array_flip(array_intersect(SteamDictionary::THEMES, $tags));
    }

    public static function matchPlatforms($tags)
    {
        return array_flip(array_intersect(SteamDictionary::PLATFORMS, $tags));
    }
}