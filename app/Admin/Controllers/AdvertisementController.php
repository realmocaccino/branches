<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\AdvertisementRequest;
use App\Admin\Models\Advertisement;
use App\Admin\Models\Advertiser;

class AdvertisementController extends BaseController
{
	protected $advertisement;
	protected $advertiser;
	protected $platforms;

	public function __construct(Advertisement $advertisement, Advertiser $advertiser)
	{
		parent::__construct();
		
		$this->advertisement = $advertisement;
		$this->advertiser = $advertiser;
		$this->platforms = [
			'' => 'Qualquer Plataforma',
			'desktop' => 'Somente Desktop',
			'mobile' => 'Somente Mobile'
		];
	}

	public function index()
	{
		$this->head->setTitle('Anúncios');
		
		return $this->view('advertisements.index')->with([
			'advertisements' => $this->advertisement->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhum anúncio encontrado'],
			'platforms' => $this->platforms
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Anúncio');
		
		return $this->view('advertisements.create', [
			'advertisers' => $this->advertiser->orderBy('name')->pluck('name', 'id')->all(),
			'platforms' => $this->platforms
		]);
	}
	
	public function store(AdvertisementRequest $request)
	{
		$this->advertisement->create($request->all());
		
		return redirect(route('advertisements.index'))->with('message', 'success|Anúncio criado com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Anúncio');
		
		return $this->view('advertisements.edit', [
			'advertisement' => $this->advertisement->find($id),
			'advertisers' => $this->advertiser->orderBy('name')->pluck('name', 'id')->all(),
			'platforms' => $this->platforms
		]);
	}
	
	public function update(AdvertisementRequest $request, $id)
	{
		$this->advertisement->find($id)->update($request->all());
		
		return redirect(route('advertisements.index'))->with('message', 'success|Anúncio atualizado com sucesso');
	}
	
	public function destroy($id)
	{
		$this->advertisement->destroy($id);
		
		return response()->json([
			'message' => 'Anúncio excluído com sucesso!',
		]);
	}
}
