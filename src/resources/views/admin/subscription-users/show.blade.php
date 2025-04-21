@extends('admin.layouts.master')

@section('title')
    {{$page_title}}
@endsection

@section('container')
        <div class="row">
            <div class="col-lg-12">
                <div class="trk-card">
                    <div class="trk-card__header d-flex justify-content-between">
                        <div class="trk-card__title">
                            <h5>{{$info->title}}</h5>
                        </div>
                        <div class="float-right">
                            @can('subscription-user-update')
                                <a href="{{ route($info->first_button_route,$id)}}" class="btn btn-primary">
                                    <i class="flaticon2-add"></i>
                                    {{$info->first_button_title}}
                                </a>
                            @endcan
                            <a href="{{ route($info->second_button_route) }}" class="btn btn-warning">
                                <i class="flaticon2-add"></i>
                                {{ $info->second_button_title }}
                            </a>
                        </div>
                    </div>
                    <div class="trk-card__body">
                        <div class="trk-card__body-text">
                            <ul class="crud-view mt-4">
                                <li class="crud-view__item">
    <span class="crud-view__item-title">Payment Method:</span>
    <span class="crud-view__item-content">{{ $data->payment_method}}</span>
</li>
<li class="crud-view__item">
    <span class="crud-view__item-title">Paid:</span>
    <span class="crud-view__item-content">{{ $data->paid}}</span>
</li>
<li class="crud-view__item">
    <span class="crud-view__item-title">Start Date:</span>
    <span class="crud-view__item-content">{{ date('d M Y',strtotime($data->start_date))}}</span>
</li>

<li class="crud-view__item">
    <span class="crud-view__item-title">End Date:</span>
    <span class="crud-view__item-content">{{ date('d M Y',strtotime($data->end_date))}}</span>
</li>

<li class="crud-view__item">
    <span class="crud-view__item-title">Payment Verified:</span>
    <span class="crud-view__item-content">{{ $data->payment_verified}}</span>
</li>

<li class="crud-view__item">
    <span class="crud-view__item-title">User:</span>
    <span class="crud-view__item-content">
                                        
                {{$data->user?->name*}}            
                
            </span>
</li><li class="crud-view__item">
    <span class="crud-view__item-title">Subscription Plan:</span>
    <span class="crud-view__item-content">
                                        
                {{$data->subscriptionPlan?->title*}}            
                
            </span>
</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
