<?php
namespace App\Site\Controllers;

use App\Site\Models\Contact;
use App\Site\Requests\ContactRequest;
use App\Site\Mails\ContactMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Mail};

class ContactController extends BaseController
{
	protected $contact;

	public function __construct(Request $request)
	{
		parent::__construct();
		
		$this->contact = Contact::findBySlugOrFail($request->contactPage);
	}
	
	public function index($page)
	{
		$this->head->setTitle($this->contact->title);
		$this->head->setDescription($this->contact->description);
		
		return $this->view('contact.index', [
			'slug' => $this->contact->slug,
			'description' => $this->contact->description,
			'email' => $this->contact->email,
			'user' => Auth::guard('site')->user()
		]);
	}
	
	public function send(ContactRequest $request)
	{
		Mail::to($this->contact->email)->send(new ContactMail($this->contact, $request));
	
		return redirect()->route('home')->with('alert', 'info|Mensagem enviada com sucesso.|false');
	}
}