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
                    @can('subscription-user-create')
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
                                <th>User Info</th>
                                <th>Plan Info</th>
                                <th>Subscription Period</th>
                                <th>Payment Info</th>
                                <th>status</th>
                                <th>Subscribe</th>
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
                                    </td>

                                    <td>
                                        <div>
                                            {{ $row->user?->name }}
                                        </div>
                                        <div>
                                            <a href="#" class="link-color">
                                                {{ $row->user?->email }}
                                            </a>
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                            Title: {{ $row->subscriptionPlan?->title }}
                                        </div>
                                        <div>
                                            <a href="#" class="link-color">
                                                Cycle: {{ $row->subscriptionPlan?->billing_cycle }}
                                            </a>
                                        </div>
                                    </td>

                                    <td>

                                        <div>Start Date: {{ $row->start_date }}</div>
                                        <div>End Date: {{ $row->end_date }}</div>

                                    </td>

                                    <td>
                                        <div>
                                            paid: {{ $row->paid }} Tk
                                        </div>
                                        <div>
                                            <a href="#" class="link-color">
                                                Method: {{ $row->payment_method }}
                                            </a>
                                        </div>
                                        <div>
                                            <a href="#" class="link-color">
                                                Verified : {{ $row->payment_verified == 1 ? 'Yes' : 'No' }}
                                            </a>
                                        </div>
                                    </td>

                                    <td>
                                        {{ $row->is_active ? 'Subscribed' : 'Unsubscribed' }}

                                    </td>
                                    <td>
                                        <div class="form-check form-switch form-switch-md">
                                            <input type="checkbox" name="is_active" value="{{ $row->id }}"
                                                onclick="toggleSwitchStatus(this,'subscription_users');" class="form-check-input"
                                                @if ($row->is_active == 1) checked @endif>
                                        </div>

                                    </td>
                                    <td>
                                        <ul class="trk-action__list">
                                            <li class="trk-action">
                                                <a class="trk-action__item trk-action__item--success"
                                                    href="{{ route('admin.subscription-users.show', $row->id) }}">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                            </li>
                                            @can('subscription-user-update')
                                                <li class="trk-action">
                                                    <a class="trk-action__item trk-action__item--warning"
                                                        href="{{ route('admin.subscription-users.edit', $row->id) }}">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('subscription-user-delete')
                                                <li class="trk-action">
                                                    <a onclick="Delete(`{{ route('admin.subscription-users.destroy', $row->id) }}`)"
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
