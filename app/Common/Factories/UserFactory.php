<?php
namespace App\Common\Factories;

use App\Site\Models\User;
use App\Site\Mails\AccountConfirmationMail;
use App\Site\Notifications\WelcomeNotification;
use App\Site\Scopes\ActiveScope;
use App\Common\Helpers\Support;

use Exception;
use Illuminate\Support\Facades\Mail;

class UserFactory
{
	protected $user;
	protected $status = true;

	public function publishable($status = true)
    {
        $this->status = $status;

        return $this;
    }

	public function register($data)
	{
		$this->user = new User;

		$this->setName($data['name']);
		$this->setEmail($data['email']);
		$this->user->newsletter = 1;
		$this->setLastAccess();
		$this->setIp();
		if(isset($data['password']) and $data['password']) {
			$this->setPassword($data['password']);
		}
		$this->user->slug = Support::createUserSlug($data['name']);
		$this->user->status = 1;
		$this->user->save();
		
		$this->user->notify(new WelcomeNotification());
		
		return $this->user;
	}
	
	public function registerWithConfirmation($data)
	{
		$this->user = new User;

		$this->setName($data['name']);
		$this->setEmail($data['email']);
		$this->user->newsletter = 1;
		$this->setLastAccess();
		$this->setIp();
		if(isset($data['password']) and $data['password']) {
			$this->setPassword($data['password']);
		}
		$this->user->status = 0;
		$this->user->token = str_random(40);
		$this->user->save();
		
		Mail::to($this->user)->send(new AccountConfirmationMail($this->user));
		
		return $this->user;
	}

	public function confirm($token)
	{
		$this->user = User::whereToken($token)->withoutGlobalScope(ActiveScope::class)->firstOrFail();
		$this->user->slug = Support::createUserSlug($this->user->name);
		$this->user->status = 1;
		$this->user->token = null;
		$this->user->save();
		
		$this->user->notify(new WelcomeNotification());
		
		return $this->user;
	}

	public function update(User $user, $data)
	{
		$this->user = $user;

		$this->setName($data->name);
		$this->user->slug = $data->slug;
		$this->setBio($data->bio);
		$this->setPlatform($data->platform);
		$this->setLanguage($data->language);
		$this->setMode($data->mode);
		if($data->password) {
			$this->setPassword($data->password);
		}
		$this->user->newsletter = $data->newsletter;
		$this->user->save();

		return $this->user;
	}

	protected function setName($name)
	{
		$this->user->name = $name;
	}

	protected function setEmail($email)
	{
		$this->user->email = $email;
	}

	protected function setBio($bio)
	{
		$this->user->bio = $bio;
	}

	protected function setPassword($password)
	{
		$this->user->password = bcrypt($password);
	}

	protected function setPlatform($platformId)
	{
		$this->user->platform_id = $platformId;
	}

	protected function setLanguage($language)
	{
		if(!in_array($language, config('app.available_languages'))) {
            throw new Exception('Language not available');
        }

		$this->user->language = $language;
	}

	protected function setMode($mode)
	{
		$this->user->mode = $mode;
	}

	protected function setLastAccess()
	{
		$this->user->last_access = now();
	}

	protected function setIp()
	{
		$this->user->ip = request()->ip();
	}
}
