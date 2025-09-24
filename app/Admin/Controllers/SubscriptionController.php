<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\SubscriptionRequest;
use App\Admin\Models\Subscription;
use App\Admin\Models\{Plan, User};

class SubscriptionController extends BaseController
{
	protected $subscription;
    protected $plans;
	protected $users;

	public function __construct(Subscription $subscription, Plan $plan, User $user)
	{
		parent::__construct();
		
		$this->subscription = $subscription;
        $this->plans = $plan->orderBy('name')->pluck('name', 'id')->all();
		$this->users = $user->orderBy('name')->pluck('name', 'id')->all();
	}

	public function index($relationship = null, $column = null, $value = null)
	{
		$this->head->setTitle('Assinaturas');
		
		$subscriptions = $this->subscription->filter($relationship, $column, $value);
		
		return $this->view('subscriptions.index')->with([
			'subscriptions' => $subscriptions->paginate(config('admin.per_page'))->appends(request()->query()),
			'no_data' => ['class' => 'info', 'text' => 'Nenhuma assinatura encontrada']
		]);
	}
	
	public function create()
	{
		$this->head->setTitle('Criar Assinatura');
		
		return $this->view('subscriptions.create', [
            'plans' => $this->plans,
			'users' => $this->users
		]);
	}
	
	public function store(SubscriptionRequest $request)
	{
		$this->subscription->create($request->all());
		
		return redirect(route('subscriptions.index'))->with('message', 'success|Assinatura criada com sucesso');
	}
	
	public function edit($id)
	{
		$this->head->setTitle('Editar Assinatura');
		
		return $this->view('subscriptions.edit', [
			'subscription' => $this->subscription->find($id),
            'plans' => $this->plans,
			'users' => $this->users
		]);
	}
	
	public function update(SubscriptionRequest $request, $id)
	{
		$this->subscription->find($id)->update($request->all());
		
		return redirect(route('subscriptions.index'))->with('message', 'success|Assinatura atualizada com sucesso');
	}
	
	public function destroy($id)
	{
		$this->subscription->destroy($id);
		
		return response()->json([
			'message' => 'Assinatura excluída com sucesso!',
		]);
	}
}