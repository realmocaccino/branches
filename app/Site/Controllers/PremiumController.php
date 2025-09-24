<?php
namespace App\Site\Controllers;

use App\Site\Models\Plan;
use App\Site\Repositories\UserRepository;

use Illuminate\Support\Facades\Auth;

class PremiumController extends BaseController
{
    protected $plan;
    protected $userRepository;

    public function __construct(Plan $plan, UserRepository $userRepository)
    {
        parent::__construct();

        $this->plan = $plan;
        $this->userRepository = $userRepository;
        $this->head->addScript('https://js.stripe.com/v3');
    }

    public function index()
	{
        $this->head->setTitle(trans('premium/index.title'));

		return $this->view('premium.index', [
            'plans' => $this->plan->all(),
            'premiumUsers' => $this->userRepository->getPremiumUsers(),
		    'user' => Auth::guard('site')->user()
		]);
	}

    public function checkout($planId)
    {
        $this->head->setTitle(trans('premium/checkout.title'));

        return $this->view('premium.checkout', [
            'plan' => $this->plan->findOrFail($planId)
        ]);
    }
}