<?php

namespace App\Http\Controllers\Admin;

use Hash;
use \stdClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Services\MockStripeService;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\SelfCoder\FileManager;
use App\Exports\SubscriptionUserExport;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class SubscriptionUserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subscription-user-view|subscription-user-create|subscription-user-update|subscription-user-delete', ['only' => ['index']]);
        $this->middleware('permission:subscription-user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subscription-user-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subscription-user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Subscription User';
        $info                     = new stdClass();
        $info->title              = 'Subscription Users';
        $info->first_button_title = 'Add Subscription User';
        $info->first_button_route = 'admin.subscription-users.create';
        $info->route_index        = 'admin.subscription-users.index';
        $info->description        = 'These all are Subscription Users';


        $with_data = [];

        $data = SubscriptionUser::query();


        if (isset($request->search) && trim($request->search) != '') {
            $search_columns = ['id', 'payment_method', 'paid', 'start_date', 'end_date', 'payment_verified'];
            $data = keywordBaseSearch(
                $searh_key = $request->search,
                $columns_array = $search_columns,
                $model_query = $data
            );
        }

        $data = $data->orderBy('id', 'DESC');
        $data = $data->paginate(15);

        return view('admin.subscription-users.index', compact('page_title', 'data', 'info'))->with($with_data);
    }


    public function create()
    {
        $page_title = 'Subscription User Create';
        $info = new stdClass();
        $info->title = 'Subscription Users';
        $info->first_button_title = 'All Subscription User';
        $info->first_button_route = 'admin.subscription-users.index';
        $info->form_route = 'admin.subscription-users.store';

        return view('admin.subscription-users.create', compact('page_title', 'info'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validation_rules = [
            'payment_method'   => 'required|string',

            // 'paid'             => 'nullable|integer',

            // 'start_date'       => 'required|date',

            // 'end_date'         => 'required|date',

            'payment_verified' => 'required',

            'user_id'          => 'required|integer',

            'plan_id'          => 'required|integer',

        ];

        $this->validate($request, $validation_rules);


        $plan = SubscriptionPlan::where('id', $request->plan_id)->first();

        if ($plan) {

            // Determine number of days based on the billing cycle
            switch ($plan->billing_cycle) {
                case 'weekly':
                    $billingCycleDays = 7;
                    break;
                case 'monthly':
                    $billingCycleDays = 30;
                    break;
                case 'yearly':
                    $billingCycleDays = 365;
                    break;
                default:
                    $billingCycleDays = 0; // You might want to handle this case more explicitly
                    break;
            }
        }
        // dd(today()->addDays($billingCycleDays));
        $row                   = new SubscriptionUser;

        $row->user_id          = $request->user_id;

        $row->plan_id          = $request->plan_id;

        $row->start_date       = today();

        $row->end_date        = today()->addDays($billingCycleDays);

        $row->payment_method   = $request->payment_method;

        $row->paid             = $plan->price;

        $row->payment_verified = $request->payment_verified == 'on' ? 1 : 0;

        $row->save();

        return redirect()->route('admin.subscription-users.index')
            ->with('success', 'Subscription User created successfully!');
    }

    public function show($id)
    {

        $data = SubscriptionUser::find($id);

        if (!$data) {
            return back()->with('warning', 'No Subscription Story Found');
        }
        // If the request is not for JSON, return the view with the data
        $page_title = 'Subscription User Details';
        $info = new stdClass();
        $info->title = 'Subscription Users Details';
        $info->first_button_title = 'Edit Subscription User';
        $info->first_button_route = 'admin.subscription-users.edit';
        $info->second_button_title = 'All Subscription Users';
        $info->second_button_route = 'admin.subscription-users.index';
        $info->description = '';

        return view('admin.subscription-users.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Subscription User Edit';
        $info = new stdClass();
        $info->title = 'Subscription Users';
        $info->first_button_title = 'Add Subscription User';
        $info->first_button_route = 'admin.subscription-users.create';
        $info->second_button_title = 'All Subscription User';
        $info->second_button_route = 'admin.subscription-users.index';
        $info->form_route = 'admin.subscription-users.update';
        $info->route_destroy = 'admin.subscription-users.destroy';

        $data = SubscriptionUser::where('id', $id)->first();

        return view('admin.subscription-users.edit', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function update(Request $request, $id)
    {

        $validation_rules = [
            'payment_method' => 'required|string',

            'paid' => 'required|integer',

            'start_date' => 'required|date',

            'end_date' => 'required|date',

            'payment_verified' => 'required|integer',

            'user_id' => 'nullable|integer',

            'plan_id' => 'nullable|integer',

        ];
        $this->validate($request, $validation_rules);
        $row = SubscriptionUser::find($id);

        if ($row == null || $row == '') {
            return back()->with('warning', 'Id not Found');
        }


        $row->payment_method = $request->payment_method;

        $row->paid = $request->paid;

        $row->start_date = $request->start_date;

        $row->end_date = $request->end_date;

        $row->user_id = $request->user_id;

        $row->plan_id = $request->plan_id;

        $row->payment_verified = $request->payment_verified ? 1 : 0;

        $row->save();

        return redirect()->route('admin.subscription-users.show', $id)
            ->with('success', 'Subscription User updated successfully!');
    }

    public function destroy($id)
    {

        $row = SubscriptionUser::where('id', $id)->first();

        if ($row == null || $row == '') {
            return back()->with('warning', 'Id not Found');
        }



        $row->delete();

        return redirect()->route('admin.subscription-users.index')
            ->with('success', 'Subscription User deleted successfully!');
    }

    public function subscribe(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id', // Ensuring the subscription plan exists
        ]);

        $plan = SubscriptionPlan::find($request->plan_id);

        $user = auth()->user(); // Assuming the user is authenticated

        if (!$user) {
            return apiResponse(false, 'User not authenticated');
        }

        // Check if the user already has this plan active
        $existingActive = SubscriptionUser::where('user_id', $user->id)
            ->where('plan_id', $plan->id)
            ->where('is_active', 1)
            ->first();

        if ($existingActive) {
            return apiResponse(false, 'Already subscribed to this plan and it is active.', null, 409);
        }

        // 2. Prevent downgrade
        $currentActivePlan = SubscriptionUser::where('user_id', $user->id)
            ->where('is_active', 1)
            ->orderByDesc('created_at') // Assuming latest is the current one
            ->first();

        if ($currentActivePlan) {
            $currentPlan = SubscriptionPlan::find($currentActivePlan->plan_id);

            if ($currentPlan && $currentPlan->level > $plan->level) {
                return apiResponse(false, 'Downgrade to this plan is not allowed.', null, 403);
            }
        }

        // 3. Deactivate other active subscriptions
        SubscriptionUser::where('user_id', $user->id)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

        // Simulating subscription creation with a mock Stripe API
        $result = MockStripeService::createSubscription($user, $plan);

        $subscription = SubscriptionUser::create([
            'user_id'          => $user->id,
            'plan_id'          => $plan->id,
            'is_active'        => $result['payment_status'] == 'success' ? 1 : 0,
            'payment_status'   => $result['payment_status'] == 'success' ? 'Paid' : 'Unpaid',
            'payment_method'   => $result['payment_status'] == 'success' ? 'Stripe MOCK' : 'Not Found',
            'payment_verified' => $result['payment_status'] == 'success' ? 1 : 0,
            'paid'             => $result['payment_status'] == 'success' ? $plan->price : 0,
            'status'           => $result['payment_status'] == 'success' ? 'Subscribed' : 'Unsubscribed',
            'start_date'       => now(),
            'end_date'         => match ($plan->billing_cycle) {
                'weekly'  => now()->addDays(7),
                'monthly' => now()->addMonths(1),
                'yearly'  => now()->addYear(),
                default   => now()->addMonths(1),
            }
        ]);

        if ($result['payment_status'] == 'success') {
            return apiResponse(true, 'Subsribed Successfully!', $subscription, 200);
        } else {
            return apiResponse(false, 'Payment failed!');
        }
    }


    public function subscriptionShowFrontend($id)
    {
        $data = SubscriptionUser::with('user', 'subscriptionPlan')->find($id);

        if (!$data) {
            return apiResponse(false, 'No Data Found', null, 200);
        }

        return apiResponse(true, 'Successfull!', $data, 200);
    }

    public function cancelSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscription_users,id'
        ]);

        $subscription = SubscriptionUser::where('id', $request->subscription_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$subscription) {
            return apiResponse(false, 'Subscription not found or unauthorized.', null, 404);
        }

        if (!$subscription->is_active) {
            return apiResponse(false, 'Subscription is already cancelled.', null, 400);
        }

        $subscription->update([
            'is_active'  => 0,
            'status'     => 'Subcription Cancelled',
            'user_unsubscribed_at'  => now(),
        ]);

        return response()->json(['message' => 'Subscription cancelled successfully.']);
    }
}
