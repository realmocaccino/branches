<?php
namespace App\Admin\Controllers;

use Illuminate\Http\Request;

use App\Admin\Models\Contribution;

class ContributionController extends BaseController
{
	protected $contribution;

	public function __construct(Contribution $contribution)
	{
		parent::__construct();
		
		$this->contribution = $contribution;
	}
	
	public function index()
	{
		$this->head->setTitle('Contribuições');
		
		return $this->view('contributions.index')->with([
			'contributions' => $this->contribution->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma contribuição encontrada']
		]);
	}
	
	public function destroy($id)
	{
		$this->contribution->destroy($id);
		
		return response()->json([
			'message' => 'Contribuição excluída com sucesso!',
		]);
	}
}
