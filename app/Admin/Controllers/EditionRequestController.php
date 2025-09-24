<?php
namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Site\Models\User;
use App\Admin\Models\{Contribution, EditionRequest};
use App\Admin\Notifications\{EditionRequestApprovedNotification, EditionRequestDiscardedNotification};
use App\Common\Helpers\Support;

class EditionRequestController extends BaseController
{
	protected const DEFAULT_NAMESPACE = 'App\\Admin\\Models\\';

	protected $editionRequest;
	protected $entity;

	public function __construct(Request $request)
	{
		parent::__construct();
		
		$this->editionRequest = EditionRequest::find($request->id);
		$this->entity = $this->getEntity($this->editionRequest);
	}
	
	public function index()
	{
		$this->head->setTitle('Solicitações de Edição');
		
		return $this->view('editionRequests.index')->with([
			'editionRequests' => EditionRequest::latest()->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma solicitação de edição encontrada']
		]);
	}
	
	public function viewRequest($id)
	{
		$this->head->setTitle('Visualização de Solicitação de Edição');
		
		$changes = Support::arrayDiffAssocMulti(array_intersect_key($this->entity->getAllAttributes(), $this->editionRequest->request), $this->editionRequest->request);

		$formattedChanges = [];
		
		foreach($changes as $field => $change) {
			$entityField = $this->entity[$field];
            $nameColumn = Schema::hasColumn($field, 'name_pt') ? 'name_pt' : 'name';

			if(is_object($entityField)) {
				if(get_class($entityField) == 'Illuminate\Support\Carbon') {
					$formattedChanges[$field]['from'] = $entityField->format('d/m/Y');
				} else {
					$formattedChanges[$field]['from'] = $entityField->pluck($nameColumn)->implode(',');
				}
			} elseif($entityField) {
				$formattedChanges[$field]['from'] = $entityField;
			}
		
			if(is_array($change)) {
				$formattedChanges[$field]['to'] = Support::getModelInstanceByTableName($field)->find($this->editionRequest->request[$field])->pluck($nameColumn)->implode(',');
			} else {
				$formattedChanges[$field]['to'] = $change;
			}
		}
		
		return $this->view('editionRequests.view')->with([
			'editionRequest' => $this->editionRequest,
			'entity' => $this->entity,
			'changes' => $formattedChanges
		]);
	}
	
	public function approve($id)
	{
		$this->entity->update($this->editionRequest->request);
		if($this->editionRequest->model_name == 'Game') $this->entity->syncRelationships((object) $this->editionRequest->request, false);
		
		$contribution = new Contribution();
		$contribution->user_id = $this->editionRequest->user_id;
		$contribution->game_id = $this->editionRequest->entity_id;
		$contribution->status = 1;
		$contribution->type = 'game_edition';
		$contribution->save();
		
		$this->editionRequest->delete();
		
		$user = User::find($this->editionRequest->user->id);
		$user->increment('total_contributions');
		$user->notify(new EditionRequestApprovedNotification($this->entity->name));
		
		return redirect()->route('editionRequests.index')->with([
			'message' => 'Solicitação de edição aprovada!',
		]);
	}
	
	public function discard($id)
	{
		$this->editionRequest->destroy($id);
		
		$user = User::find($this->editionRequest->user->id);
		$user->notify(new EditionRequestDiscardedNotification($this->entity->name));
		
		return redirect()->route('editionRequests.index')->with([
			'message' => 'Solicitação de edição descartada!',
		]);
	}

	private function getEntity($editionRequest)
	{
		if($editionRequest) {
			$className = self::DEFAULT_NAMESPACE . $editionRequest->model_name;
			
			return $className::find($editionRequest->entity_id);
		}

		return null;
	}
}