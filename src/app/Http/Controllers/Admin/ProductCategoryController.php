<?php

namespace App\Http\Controllers\Admin;

use \stdClass;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\SubscriptionPlan;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;

class ProductCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-category-view|product-category-create|product-category-update|product-category-delete', ['only' => ['index']]);
        $this->middleware('permission:product-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-category-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Product Category';
        $info                     = new stdClass();
        $info->title              = 'Product Categories';
        $info->first_button_title = 'Add Product Category';
        $info->first_button_route = 'admin.product-categories.create';
        $info->route_index        = 'admin.product-categories.index';
        $info->description        = 'These all are Product Categories';

        $with_data = [];

        $data = ProductCategory::query();

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

        return view('admin.product-categories.index', compact('page_title', 'data', 'info'))->with($with_data);
    }


    public function create()
    {
        $page_title = 'Product Category Create';
        $info = new stdClass();
        $info->title = 'Product Categories';
        $info->first_button_title = 'All Product Category';
        $info->first_button_route = 'admin.product-categories.index';
        $info->form_route = 'admin.product-categories.store';

        return view('admin.product-categories.create', compact('page_title', 'info'));
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
                'storage/product-categories',
                ['png', 'jpg', 'jpeg', 'gif']
            );

            if (isset($file_response['result']) && !$file_response['result']) {

                return back()->with('warning', $file_response['message']);
            }

            $row->banner = $file_response['filename'];
        }
        $row->save();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product Category created successfully!');
    }

    public function show($id)
    {

        $page_title = 'Product Category Details';
        $info = new stdClass();
        $info->title = 'Product Categories Details';
        $info->first_button_title = 'Edit Product Category';
        $info->first_button_route = 'admin.product-categories.edit';
        $info->second_button_title = 'All Product Category';
        $info->second_button_route = 'admin.product-categories.index';
        $info->description = '';


        $data = ProductCategory::findOrFail($id);


        return view('admin.product-categories.show', compact('page_title', 'info', 'data'))->with('id', $id);
    }

    public function edit($id)
    {
        $page_title = 'Product Category Edit';
        $info = new stdClass();
        $info->title = 'Product Categories';
        $info->first_button_title = 'Add Product Category';
        $info->first_button_route = 'admin.product-categories.create';
        $info->second_button_title = 'All Product Category';
        $info->second_button_route = 'admin.product-categories.index';
        $info->form_route = 'admin.product-categories.update';
        $info->route_destroy = 'admin.product-categories.destroy';

        $data = ProductCategory::where('id', $id)->first();

        return view('admin.product-categories.edit', compact('page_title', 'info', 'data'))->with('id', $id);
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
        $row = ProductCategory::find($id);

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
                'storage/product-categories',
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

        return redirect()->route('admin.product-categories.show', $id)
            ->with('success', 'Product Category updated successfully!');
    }

    public function destroy($id)
    {

        $row = ProductCategory::where('id', $id)->first();

        if ($row == null || $row == '') {
            return back()->with('warning', 'Id not Found');
        }


        if ($row['banner'] != '') {
            FileManager::deleteFile($row['banner']);
        }

        $row->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Product Category deleted successfully!');
    }
}
