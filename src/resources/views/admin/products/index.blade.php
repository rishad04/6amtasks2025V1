@extends('admin.layouts.master')

@section('title')
    {{ $page_title }}
@endsection
@section('container')
    <div class="trk-table">
        <div class="trk-table__wrapper">

            <div class=" trk-table__header d-flex justify-content-between">
                <div class="trk-table__title">
                    <h5>{{ $info->title }}</h5>
                    <p>{{ $info->description }}</p>
                </div>
                <div class="float-right">
                    @can('subscription-plan-create')
                        <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                            <i class="flaticon2-add"></i>
                            {{ $info->first_button_title }}
                        </a>
                    @endcan

                    @can('export-view')
                        <a href="{{ request()->fullUrlWithQuery(['export_table' => 1]) }}" class="btn btn-primary">
                            <i class="flaticon2-export"></i>
                            Export
                        </a>
                    @endcan
                </div>
            </div>

            <form action="{{ route(Route::currentRouteName()) }}" method="GET">
                <div class="trk-table__header d-flex flex-wrap justify-content-center pb-0 border-0">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search" name="search" value="{{ request()->search }}"
                            placeholder="Search..." required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-danger font-weight-bolder ml-4 form-control">Filter</button>
                    </div>
                </div>
            </form>

            <div class="trk-table__body">
                @if ($data->count() > 0)
                    <!--begin: Datatable-->
                    <table class="table" id="">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Banner</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $serial = 1;
                            @endphp

                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $serial }}
                                    <td>
                                        <div class="trk-item d-flex gap-2">
                                            <div class="trk-thumb thumb-md">
                                                <img src="@if ($row->banner != '') {{ asset($row->banner) }} @else {{ asset(avatarUrl()) }} @endif"
                                                    alt="avatar">
                                            </div>
                                        </div>

                                    </td>

                                    <td>{{ $row->title }}
                                    </td>
                                    <td>{{ $row->productCategory?->title }}
                                    </td>
                                    <td>{{ $row->price }}
                                    </td>
                                    <td>{{ $row->stock_quantity }} Pcs
                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-switch-md">
                                            <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                                onclick="toggleSwitchStatus(this,'subscription_plans');" class="form-check-input"
                                                @if ($row->is_active == 1) checked @endif>
                                        </div>

                                    </td>
                                    <td>
                                        <ul class="trk-action__list">
                                            <li class="trk-action">
                                                <a class="trk-action__item trk-action__item--success"
                                                    href="{{ route('admin.subscription-plans.show', $row->id) }}">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                            </li>
                                            @can('subscription-plan-update')
                                                <li class="trk-action">
                                                    <a class="trk-action__item trk-action__item--warning"
                                                        href="{{ route('admin.subscription-plans.edit', $row->id) }}">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('subscription-plan-delete')
                                                <li class="trk-action">
                                                    <a onclick="Delete(`{{ route('admin.subscription-plans.destroy', $row->id) }}`)"
                                                        class="trk-action__item trk-action__item--danger" href="#">
                                                        <i class="lni lni-trash-can"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>

                                    </td>
                                </tr>
                                @php
                                    $serial++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>

                    {{ $data->links() }}
                    <!--end: Datatable-->
                @else
                    <div class="alert alert-custom alert-notice alert-light-success fade show mb-5 text-center" role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-questions-circular-button"></i>
                        </div>
                        <div class="alert-text text-dark">
                            No Data Found..!
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-success">
                                <i class="flaticon2-add"></i>
                                Add Now
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('admin.components.modals.delete')
@endsection

@section('css')
@endsection
@section('js')
    @parent
    {{-- SCRIPT --}}
@endsection
