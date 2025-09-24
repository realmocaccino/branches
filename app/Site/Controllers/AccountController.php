<?php
namespace App\Site\Controllers;

use App\Site\Controllers\Traits\UserPagesTrait;
use App\Site\Helpers\Filter;
use App\Site\Models\Platform;
use App\Site\Requests\Account\{EditRequest, EditEmailRequest, UploadPictureRequest, UploadBackgroundRequest};
use App\Common\Factories\UserFactory;
use App\Common\Helpers\Authentication;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, View};

class AccountController extends BaseController
{
	protected $filter;
	protected $user;
	protected $userFactory;
	protected $isLoggedInUser;

	public function __construct(Filter $filter, UserFactory $userFactory)
	{
		parent::__construct();

		$this->filter = $filter;
		$this->userFactory = $userFactory;
		
		$this->middleware(function($request, $next) {
			$this->user = Auth::guard('site')->user();
			$this->isLoggedInUser = true;
			
			View::share('user', $this->user);
			View::share('isLoggedInUser', $this->isLoggedInUser);
			View::share('followsYou', false);
			View::share('totalCollections', $this->user->collections()->count());
			
			return $next($request);
		});
		
		$this->head->disableSearchIndexing();
	}
	
	public function editPage()
	{
		$this->head->setTitle(trans('account/edit/index.title'));
		
		return $this->view('account.edit.index', [
			'platforms' => Platform::orderBy('name')->get()
		]);
	}
	
	public function editEmailPage()
	{
		$this->head->setTitle(trans('account/edit/email.title'));
		
		return $this->view('account.edit.email');
	}
	
	public function deletePage()
	{
		$this->head->setTitle(trans('account/delete/index.title'));
		
		return $this->view('account.delete.index');
	}
	
	public function edit(EditRequest $request)
	{
		$this->userFactory->update($this->user, $request);
		
		return redirect()->route('account.index')->with('alert', 'success|Sua conta foi atualizada com sucesso.');
	}
	
	public function editEmail(EditEmailRequest $request)
	{
		$this->user->email = $request->email;
		$this->user->save();
	
		return redirect()->route('account.index')->with('alert', 'success|Email alterado com sucesso.');
	}
	
	public function delete(Request $request)
	{
		if($this->user->password) {
			$request->validate([
				'password' => 'required'
			]);
			
			if(!Hash::check($request->password, $this->user->password)) {
				return redirect()->back()->with('alert', 'warning|Senha incorreta.');
			}
		}
		
		$authentication = new Authentication('site');
		$authentication->logout();
		
		$this->user->delete();
	
		return redirect()->route('home')->with('alert', 'info|Sua conta foi excluída.|false');
	}
	
	public function picture()
	{
	    $this->head->setTitle(trans('account/picture/index.title_' . ($this->user->picture ? 'manage' : 'send')));
	
	    return $this->view('account.picture.index');
	}
	
	public function uploadPicture(UploadPictureRequest $request)
	{
		$this->user->uploadFile('picture', $request->picture);
	
		return redirect()->route('account.index')->with('alert', 'success|Foto enviada com sucesso.');
	}
	
	public function deletePicture()
	{
	    $this->user->deleteFile('picture');
	
	    return redirect()->route('account.picture.index');
	}
	
	public function background()
	{
	    $this->head->setTitle(trans('account/background/index.title_' . ($this->user->background ? 'manage' : 'send')));
	
	    return $this->view('account.background.index');
	}
	
	public function uploadBackground(UploadBackgroundRequest $request)
	{
		$this->user->uploadFile('background', $request->background);
	
		return redirect()->route('account.index');
	}
	
	public function deleteBackground()
	{
	    $this->user->deleteFile('background');
	
	    return redirect()->route('account.background.index');
	}

	use UserPagesTrait;
}