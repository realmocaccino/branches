<?php
namespace App\Site\Controllers\Ajax;

use App\Site\Models\{Plan, Subscription};
use App\Site\Notifications\YouAreNowPremiumNotification;
use App\Site\Repositories\UserRepository;
use App\Site\Requests\PremiumRequest;

use Stripe\StripeClient;
use Illuminate\Http\Response;

class PremiumController extends BaseController
{
    protected $userRepository;
    private $stripe;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

	public function index()
	{
        return $this->view('premium.index', [
            'plans' => Plan::all(),
            'premiumUsers' => $this->userRepository->getPremiumUsers(),
            'user' => auth()->guard('site')->user()
        ]);
	}

    public function checkout($planId)
    {
        return $this->view('premium.checkout', [
            'plan' => Plan::findOrFail($planId)
        ]);
    }

    public function paymentIntent()
    {
        try {
            $jsonObj = json_decode(file_get_contents('php://input'));

            $plan = Plan::findOrFail($jsonObj->planId);

            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $plan->priceInCents(),
                'currency' => 'brl',
                'payment_method_types' => [
                    'card'
                ]
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'planId' => $plan->id
            ]);
        } catch (Error $e) {
            echo response()->json(['error' => $e->getMessage()], 500);
        }
    }
	
	public function subscribe(PremiumRequest $request)
	{
	    $plan = Plan::findOrFail($request->planId);
        $paymentIntent = $this->stripe->paymentIntents->retrieve($request->token);

        if(!$paymentIntent) {
            return response()->json([
                'message' => trans('premium/index.payment_not_found')
            ], Response::HTTP_BAD_REQUEST);
        }

        if($paymentIntent->status != 'succeeded') {
            return response()->json([
                'message' => trans('premium/index.payment_not_confirmed')
            ], Response::HTTP_BAD_REQUEST);
        }

        if($paymentIntent->amount < $plan->priceInCents()) {
            return response()->json([
                'message' => trans('premium/index.amount_not_enough')
            ], Response::HTTP_BAD_REQUEST);
        }

        $subscription = new Subscription();
        $subscription->plan_id = $plan->id;
        $subscription->paid = $plan->price;
        $subscription->expires_at = $plan->validity;
        $subscription->token = $request->token;
        $subscription->save();
        
        $request->user()->subscriptions()->save($subscription);
        $request->user()->notify(new YouAreNowPremiumNotification());
        
        $message = trans('premium/index.subscribed');
        
        return response()->json([
            'message' => $message
        ], Response::HTTP_OK);
	}
}