{{-- Extends layout --}}
@extends('admin.layouts.master')

@section('title')
{{ $info->title }}
@endsection

{{-- Content --}}
@section('container')
    <div class="row">
        <div class="col-lg-12">
            <div class="trk-card">
                <div class="trk-card__wrapper">
                    {{-- Card Header Start --}}
                    <div class=" trk-table__header d-flex justify-content-between">
                        <div class="trk-table__title">
                            <h5>{{ $info->title }}</h5>
                        </div>
                        <div class="float-right">
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                                <i class="flaticon2-add"></i>

                                {{ $info->first_button_title }}
                            </a>
                            <a href="{{ route($info->second_button_route) }}" class="btn btn-warning">

                                <i class="flaticon2-add"></i>

                                {{ $info->second_button_title }}
                            </a>
                        </div>
                    </div>
                    {{-- Card Header End --}}

                    {{-- Card Body Start --}}
                    <div class="trk-card__body">
                        <form class="form" action="{{ route($info->form_route, $id) }}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row g-4">

                                    <div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="payment_method">Payment Method  <span>&#x002A;</span> </label>
            <input 
                type="text" 
                 
                                                                                    value="{{ $data->payment_method}}" 
                                                                                    class="form-control @error('payment_method') is-invalid @enderror" 
                id="payment_method" 
                name="payment_method" 
                placeholder="Enter Payment Method"
                required
                
            >
            @error('payment_method')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="paid">Paid  <span>&#x002A;</span> </label>
            <input 
                type="number" 
                 
                                                                                    value="{{ $data->paid}}" 
                                                                                    class="form-control @error('paid') is-invalid @enderror" 
                id="paid" 
                name="paid" 
                placeholder="Enter Paid"
                required
                
            >
            @error('paid')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
    <div class="form-group">
        <label class="form-label" for="start_date">Start Date  <span>&#x002A;</span> </label>
        <input 
        type="date" 
        class="form-control flatpickr @error('start_date') is-invalid @enderror" 
        id="start_date" 
        name="start_date"
        placeholder="Select Date"
                value="{{$data->start_date}}"
                required
        >
        @error('start_date')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label class="form-label" for="end_date">End Date  <span>&#x002A;</span> </label>
        <input 
        type="date" 
        class="form-control flatpickr @error('end_date') is-invalid @enderror" 
        id="end_date" 
        name="end_date"
        placeholder="Select Date"
                value="{{$data->end_date}}"
                required
        >
        @error('end_date')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <div class="form-check form-switch">
            <input 
            class="form-check-input @error('payment_verified') is-invalid @enderror" 
            type="checkbox" 
            name="payment_verified"
            id="payment_verified"
             
                @if($data->payment_verified == "1") checked @endif             
             
            required
                        >
            <label class="form-check-label" for="payment_verified">Payment Verified  <span>&#x002A;</span> </label>
            @error('payment_verified')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>
</div>
<div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="user_id">User </label>
        <select 
            class="form-select search-select @error('user_id') is-invalid @enderror" 
            data-live-search="true"
            id="user_id" 
            name="user_id" 
            
            
        >
            <option value="">--Choose--</option>
                            @foreach(activeModelData('App\Models\User') as $row)                                    
                    <option value="{{$row->id}}" @if($data->user_id==$row->id) selected @endif >{{$row->name*}}</option>
                                                    @endforeach                    </select>
        @error('user_id')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror        
    </div>

</div>
<div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="plan_id">Subscription Plan </label>
        <select 
            class="form-select search-select @error('plan_id') is-invalid @enderror" 
            data-live-search="true"
            id="plan_id" 
            name="plan_id" 
            
            
        >
            <option value="">--Choose--</option>
                            @foreach(activeModelData('App\Models\SubscriptionPlan') as $row)                                    
                    <option value="{{$row->id}}" @if($data->plan_id==$row->id) selected @endif >{{$row->title*}}</option>
                                                    @endforeach                    </select>
        @error('plan_id')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror        
    </div>

</div>


                            </div>
                            <div class="row">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('button.update') }}</button>
                                    <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- Card Body End --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

    @parent

@endsection

@section('js')

    @parent

    
        {{--SCRIPT--}}'
        
@endsection
