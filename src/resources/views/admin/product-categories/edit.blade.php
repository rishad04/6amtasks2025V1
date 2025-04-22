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
    
        <label class="form-label" for="banner">Banner 
                    </label>
                    <div class="admin__thumb-upload">
                <div class=" admin__thumb-edit">
                    <input 
                        type='file'
                        class="@error('banner') is-invalid @enderror" 
                        id="banner" 
                        name="banner" onchange="imagePreview(this,'image_preview_banner');"
                        accept=".png, .jpg, .jpeg" 
                                                
                    />
                    <label for="banner"></label>
                </div>
                
                                    <div class="admin__thumb-preview">
                        <div id="image_preview_banner" class="admin__thumb-profilepreview"
                            style="
                            background-image: url({{$data->banner!=""? asset($data->banner) : asset(avatarUrl()) }});">
                        </div>
                    </div>
                
                @error('banner')                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror                
            </div>

                
        

    </div>

</div>
<div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="title">Title </label>
            <input 
                type="text" 
                 
                                                                                    value="{{ $data->title}}" 
                                                                                    class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                name="title" 
                placeholder="Enter Title"
                
                
            >
            @error('title')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="slug">Slug </label>
            <input 
                type="text" 
                 
                                                                                    value="{{ $data->slug}}" 
                                                                                    class="form-control @error('slug') is-invalid @enderror" 
                id="slug" 
                name="slug" 
                placeholder="Enter Slug"
                
                
            >
            @error('slug')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
            <div class="form-group">
            <label class="form-label" for="price">Price </label>
            <input 
                type="number" 
                 
                                                                                    value="{{ $data->price}}" 
                                                                                    class="form-control @error('price') is-invalid @enderror" 
                id="price" 
                name="price" 
                placeholder="Enter Price"
                
                
            >
            @error('price')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>

<div class="col-md-6">
    <div class="form-group">
        <div class="form-check form-switch">
            <input 
            class="form-check-input @error('is_popular') is-invalid @enderror" 
            type="checkbox" 
            name="is_popular"
            id="is_popular"
             
                @if($data->is_popular == "1") checked @endif             
                        >
            <label class="form-check-label" for="is_popular">Is Popular </label>
            @error('is_popular')                <div class="invalid-feedback">{{ $message }}</div>
            @enderror        </div>
    </div>
</div>
<div class="col-md-6">

    <div class="form-group">
        <label class="form-label" for="billing_cycle">Billing Cycle </label>
        <select 
            class="form-select search-select @error('billing_cycle') is-invalid @enderror" 
            data-live-search="true"
            id="billing_cycle" 
            name="billing_cycle" 
            
            
        >
            <option value="">--Choose--</option>
                                                                
                            <option value="weekly" @if($data->billing_cycle=="weekly") selected @endif >Weekly</option>
                            
                            <option value="monthly" @if($data->billing_cycle=="monthly") selected @endif >Mothly</option>
                            
                            <option value="yearly" @if($data->billing_cycle=="yearly") selected @endif >Yearly</option>
                                                                </select>
        @error('billing_cycle')            <div class="invalid-feedback">{{ $message }}</div>
        @enderror        
    </div>

</div>
<div class="col-md-12">

    <div class="form-group">
        
        <label class="form-label" for="description">Description </label>
        {!!renderCKEditorHtml('description',0,$data->description)!!}        @error('description')            <div class="invalid-feedback">{{ $message }}</div>
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

    
        {!!renderCKEditorScript('description')!!}
        
        {{--SCRIPT--}}'
        
@endsection
