<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use \stdClass;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subscription-plan-view|subscription-plan-create|subscription-plan-update|subscription-plan-delete', ['only' => ['index']]);
        $this->middleware('permission:subscription-plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subscription-plan-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subscription-plan-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Subscription Plan';
        $info                     = new stdClass();
        $info->title              = 'Subscription Plans';
        $info->first_button_title = 'Add Subscription Plan';
        $info->first_button_route = 'admin.subscription-plans.create';
        $info->route_index        = 'admin.subscription-plans.index';
        $info->description        = 'These all are Subscription Plans';

        $with_data = [];

        $data = SubscriptionPlan::query();

        if (isset($request->search) && trim($request->search) != '') {

            $search_columns = ['id', 'title', 'slug'];

            $data = keywordBaseSearch(
                $searh_key     = $request->search,
                $columns_array = $search_columns,
                $model_query   = $data
            );
        }

        $data = $data->orderBy('id', 'DESC');
        $data = $data->paginate(15);

        return view('admin.subscription-plans.index', compact('page_title', 'data', 'info'))->with($with_data);
    }


    public function create()
    {
        $page_title = 'Subscription Plan Create';
        $info = new stdClass();
        $info->title = 'Subscription Plans';
        $info->first_button_title = 'All Subscription Plan';
        $info->first_button_route = 'admin.subscription-plans.index';
        $info->form_route = 'admin.subscription-plans.store';

        return view('admin.subscription-plans.create', compact('page_title', 'info'));
    }

    public function store(Request $request)
    {

        $validation_rules = [
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',

            'title' => 'nullable|string',

            'slug' => 'nullable|string',

            'price' => 'nullable|integer',

            'is_popular' => 'nullable|integer',

            'billing_cycle' => 'nullable|string|in:weekly,monthly,yearly',

            'description' => 'nullable|string',

        ];
        $this->validate($request, $validation_rules);
        $row = new SubscriptionPlan;

        $row->title = $request->title;

        $row->slug = $request->slug;

        $row->price = $request->price;

        $row->description = $request->description;

        $row->billing_cycle = $request->billing_cycle;

        $row->is_popular = $request->is_popular ? 1 : 0;

        if ($request->hasfile('banner')) {
            $file_response = FileManager::saveFile(
                $request->file('banner'),
                'storage/Subscription-Plans',
                ['png', 'jpg', 'jpeg', 'gif']
            );

            if (isset($file_response['result']) && !$file_response['result']) {

                return back()->with('warning', $file_response['message']);
            }

            $row->banner = $file_response['filename'];
        }
        $row->save();

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription Plan created successfully!');
    }

    public function show($id)
    {

        $page_title = 'Subscription Plan Details';
        $info = new stdClass();
        $info->title = 'Subscription Plans Details';
        $info->first_button_title = 'Edit Subscription Plan';
        $info->first_button_route = 'admin.subscription-plans.edit';
        $info->second_button_title = 'All Subscription Plan';
        $info->second_button_route = 'admin.subscription-plans.index';
        $info->description = '';


        $data = SubscriptionPlan::findOrFail($id);


        return view('admin.subscription-plans.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Subscription Plan Edit';
        $info = new stdClass();
        $info->title = 'Subscription Plans';
        $info->first_button_title = 'Add Subscription Plan';
        $info->first_button_route = 'admin.subscription-plans.create';
        $info->second_button_title = 'All Subscription Plan';
        $info->second_button_route = 'admin.subscription-plans.index';
        $info->form_route = 'admin.subscription-plans.update';
        $info->route_destroy = 'admin.subscription-plans.destroy';

        $data = SubscriptionPlan::where('id', $id)->first();

        return view('admin.subscription-plans.edit', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function update(Request $request, $id)
    {

        $validation_rules = [
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',

            'title' => 'nullable|string',

            'slug' => 'nullable|string',

            'price' => 'nullable|integer',

            'is_popular' => 'nullable|integer',

            'billing_cycle' => 'nullable|string|in:weekly,monthly,yearly',

            'description' => 'nullable|string',

        ];
        $this->validate($request, $validation_rules);
        $row = SubscriptionPlan::find($id);

        if ($row == null || $row == '') {
            return back()->with('warning', 'Id not Found');
        }


        $row->title = $request->title;

        $row->slug = $request->slug;

        $row->price = $request->price;

        $row->description = $request->description;

        $row->billing_cycle = $request->billing_cycle;

        $row->is_popular = $request->is_popular ? 1 : 0;

        if ($request->hasfile('banner')) {
            $file_response = FileManager::saveFile(
                $request->file('banner'),
                'storage/Subscription-Plans',
                ['png', 'jpg', 'jpeg', 'gif']
            );
            if (isset($file_response['result']) && !$file_response['result']) {

                return back()->with('warning', $file_response['message']);
            }

            $old_file = $row->banner;
            FileManager::deleteFile($old_file);

            $row->banner = $file_response['filename'];
        }
        $row->save();

        return redirect()->route('admin.subscription-plans.show', $id)
            ->with('success', 'Subscription Plan updated successfully!');
    }

    public function destroy($id)
    {

        $row = SubscriptionPlan::where('id', $id)->first();

        if ($row == null || $row == '') {
            return back()->with('warning', 'Id not Found');
        }


        if ($row['banner'] != '') {
            FileManager::deleteFile($row['banner']);
        }

        $row->delete();

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription Plan deleted successfully!');
    }
}
