@extends('layouts.app')
@section('css_custom')
  <link rel="stylesheet" href="{{asset('css/menu-custom.css')}}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{trans('lang.food_plural')}}<small class="ml-3 mr-3">|</small><small>{{trans('lang.food_desc')}}</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
          <li class="breadcrumb-itema ctive"><a href="{!! route('foods.index') !!}">{{trans('lang.food_plural')}}</a>
          </li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  @include('flash::message')
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="{!! route('foods.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.food_table')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{!! route('foods.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.food_create')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active " href="{!! route('foods.edit',$food->id) !!}"><i class="fa fa-edit mr-2"></i>{{trans('lang.food_edit')}}</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="row">
        @include('foods.show_fields')

        <!-- Back Field -->
        <div class="form-group col-12 text-right">
          <a href="{!! route('restaurants.show',$food->restaurant_id) !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.back')}}</a>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  @include('foods.food_extras')
</div>
@endsection
