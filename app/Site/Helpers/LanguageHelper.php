<?php
namespace App\Site\Helpers;

use App\Site\Models\User;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Cookie;

class LanguageHelper
{
    public const CHANGE_LANGUAGE_QUERY = 'language';
    private const COOKIE_DURATION = 60 * 24 * 365;
    private const COOKIE_NAME = 'language';

    private $availableLanguages;
    private $defaultLanguage;
    private $determinedLanguage = null;
    private $isSupposedToSetCookie = false;

    public function __construct()
    {
        $this->availableLanguages = config('app.available_languages');
        $this->defaultLanguage = config('app.locale');
    }

    public function getAvailableLanguages()
    {
        return $this->availableLanguages;
    }

    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    public function getDeterminedLanguage()
    {
        return $this->determinedLanguage;
    }

    public function isSupposedToSetCookie()
    {
        return $this->isSupposedToSetCookie;
    }

    public function determineLanguage(Request $request)
    {
        if ($language = $this->isAskingToChangeLanguage($request)) {
            $this->isSupposedToSetCookie = true;

            if ($user = $request->user()) {
                $this->changeUserLanguage($user, $language);
            }

            return $this->setLanguage($language);
        } elseif ($user = $request->user() and $user->language) {
            return $this->setLanguage($user->language);
        } elseif ($language = $this->retrieveCookie()) {
            return $this->setLanguage($language);
        } elseif ($language = $this->getPreferredLanguage($request)) {
            return $this->setLanguage($language);
        }
        
        return $this->setLanguage($this->getDefaultLanguage());
    }

    public function getCookie()
    {
        return cookie(self::COOKIE_NAME, $this->getDeterminedLanguage(), self::COOKIE_DURATION);
    }

    public function setLanguage(string $language)
	{
        $this->checkAvailability($language);

        $this->determinedLanguage = $language;

	    app()->setLocale($language);
        config(['site.locale' => $language]);
        config(['site.locale_column_suffix' => '_' . $language]);
        switch($language) {
    	    case 'en':
    	        setlocale(LC_ALL, 'US');
    	        Carbon::setLocale('en');
    	    break;
    	    case 'pt':
    	    default:
    	        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    	        Carbon::setLocale('pt_BR');
    	    break;
    	}
	}

    private function changeUserLanguage(User $user, string $language)
    {
        $this->checkAvailability($language);
        
        $user->language = $language;
        $user->save();
    }

    private function checkAvailability(string $language)
    {
        if(!in_array($language, $this->getAvailableLanguages())) {
            throw new Exception('Language not available');
        }
    }

    private function isAskingToChangeLanguage(Request $request)
    {
        return $request->query(self::CHANGE_LANGUAGE_QUERY);
    }

    private function getPreferredLanguage(Request $request)
    {
        return $request->getPreferredLanguage($this->getAvailableLanguages());
    }

    private function retrieveCookie()
    {
        return Cookie::get(self::COOKIE_NAME);
    }
}