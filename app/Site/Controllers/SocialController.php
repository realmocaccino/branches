<?php
namespace App\Site\Controllers;

use App\Site\Models\User;
use App\Common\Factories\UserFactory;
use App\Common\Helpers\Redirect;
use App\Common\Helpers\Authentication;

use Laravel\Socialite\Facades\Socialite;

class SocialController extends BaseController
{
	protected $exceptURLSToRedirect = [
		'login',
		'cadastro',
		'logout'
	];
	private $userFactory;

	public function __construct(UserFactory $userFactory)
	{
		parent::__construct();

		$this->userFactory = $userFactory;
	}

    public function redirectToProvider($provider)
    {
    	$this->handleRedirectSession();
    	
    	switch($provider) {
			case 'facebook':
			case 'twitter':
				$redirect = Socialite::driver($provider)->redirect();
			break;
			case 'google':
				$redirect = Socialite::driver($provider)->stateless()->redirect();
			break;
		}
    	
        return $redirect;
    }
	
    public function handleProviderCallback($provider)
    {
        switch($provider) {
			case 'facebook':
			case 'twitter':
				$socialite = Socialite::driver($provider)->user();
			break;
			case 'google':
				$socialite = Socialite::driver($provider)->stateless()->user();
			break;
		}

    	$user = User::whereEmail($socialite->email)->first();

    	if(!$user) {
    		if($socialite->name and $socialite->email) {
				$user = $this->userFactory->register([
					'name' => $socialite->name,
					'email' => $socialite->email
				]);
				
				switch($provider) {
					case 'facebook':
					case 'google':
						$picture = str_replace('normal', 'large', $socialite->avatar);
					break;
					case 'twitter':
						$picture = str_replace('_normal', '', $socialite->avatar);
					break;
				}
				$user->uploadFile('picture', $picture);
			
				$message = 'success|Sua conta foi criada com sucesso.';
			} else {
				return redirect()->route('register.index', [
					'name' => $socialite->name,
					'email' => $socialite->email
				])->with('alert', 'info|Complete o cadastro com seus dados|true');
			}
		}

        $authentication = new Authentication('site');
		$authentication->login($user, true);
		
		return $authentication->redirect('home')->with('alert', $message ?? null);
    }

	private function handleRedirectSession()
	{
		if(!in_array(url()->previous(), $this->exceptURLSToRedirect) and !Redirect::checkIfThereIsIntendedURL('site')) Redirect::putSession('site', url()->previous());
	}
}
