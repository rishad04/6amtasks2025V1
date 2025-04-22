<?php

namespace App\Http\Controllers\Admin;

use \stdClass;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-view|product-create|product-update|product-delete', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Products';
        $info                     = new stdClass();
        $info->title              = 'Products';
        $info->first_button_title = 'Add Products';
        $info->first_button_route = 'admin.products.index';
        $info->route_index        = 'admin.products.index';
        $info->description        = 'These all are Products';

        $with_data = [];

        $data = Product::query();

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

        return view('admin.products.index', compact('page_title', 'data', 'info'))->with($with_data);
    }


    public function create()
    {
        $page_title = 'Products Create';
        $info = new stdClass();
        $info->title = 'Products';
        $info->first_button_title = 'All Products';
        $info->first_button_route = 'admin.products.index';
        $info->form_route = 'admin.products.store';

        return view('admin.products.create', compact('page_title', 'info'));
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
                'storage/Products',
                ['png', 'jpg', 'jpeg', 'gif']
            );

            if (isset($file_response['result']) && !$file_response['result']) {

                return back()->with('warning', $file_response['message']);
            }

            $row->banner = $file_response['filename'];
        }
        $row->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Products created successfully!');
    }

    public function show($id)
    {

        $page_title = 'Products Details';
        $info = new stdClass();
        $info->title = 'Products Details';
        $info->first_button_title = 'Edit Products';
        $info->first_button_route = 'admin.products.edit';
        $info->second_button_title = 'All Products';
        $info->second_button_route = 'admin.products.index';
        $info->description = '';


        $data = Product::findOrFail($id);


        return view('admin.products.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Products Edit';
        $info = new stdClass();
        $info->title = 'Products';
        $info->first_button_title = 'Add Products';
        $info->first_button_route = 'admin.products.create';
        $info->second_button_title = 'All Products';
        $info->second_button_route = 'admin.products.index';
        $info->form_route = 'admin.products.update';
        $info->route_destroy = 'admin.products.destroy';

        $data = Product::where('id', $id)->first();

        return view('admin.products.edit', compact('page_title', 'info', 'data'))->with('id', $id);
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
        $row = Product::find($id);

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
                'storage/Products',
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

        return redirect()->route('admin.products.show', $id)
            ->with('success', 'Products updated successfully!');
    }

    public function destroy($id)
    {

        $row = Product::where('id', $id)->first();

        if ($row == null || $row == '') {
            return back()->with('warning', 'Id not Found');
        }


        if ($row['banner'] != '') {
            FileManager::deleteFile($row['banner']);
        }

        $row->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Products deleted successfully!');
    }
}
