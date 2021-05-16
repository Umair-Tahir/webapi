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
        <h1 class="m-0 text-dark">{{trans('lang.restaurant_plural')}}<small class="ml-3 mr-3">|</small><small>{{trans('lang.restaurant_desc')}}</small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> {{trans('lang.dashboard')}}</a></li>
          <li class="breadcrumb-itema ctive"><a href="{!! route('restaurants.index') !!}">{{trans('lang.restaurant_plural')}}</a>
          </li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="{!! route('restaurants.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.restaurant_table')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{!! route('restaurants.create') !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.restaurant_create')}}</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="row">
        @include('restaurants.show_fields')
        <!-- Back Field -->
        <div class="form-group col-12 text-right">
          <a href="{!! route('restaurants.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.back')}}</a>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h2 >Menu</h2>
    </div>
    <div class="card-body">
      <div class="row">
        <!-- starter -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="menu-block">
            <h3 class="menu-title">Starter</h3>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Aloo and Dal ki Tikki</a></h5>
                    <span class="dish-meta">Onion  /  Tomato</span>
                    <div class="dish-price">
                      <p>$10</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Cheese Balls</a></h5>
                    <span class="dish-meta">puffed corn  /  cheese-flavored
                                            <div class="dish-price">
                                        <p>$8</p>
                                    </div>
</span>
                  </div>

                </div>
              </div>
            </div>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Veg Crispy</a> </h5>
                    <span class="dish-meta">Ginger garlic /  Black pepper</span>
                    <div class="dish-price">
                      <p>$12</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.starter -->
        <!-- Soup -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="menu-block">
            <h3 class="menu-title">Soup</h3>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Minestrone</a></h5>
                    <span class="dish-meta"> beans  / onions celery / carrots</span>
                    <div class="dish-price">
                      <p>$15</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Tomato soup</a></h5>
                    <span class="dish-meta">Cheesiy   / Creamy  /  Sweet</span>
                    <div class="dish-price">
                      <p>$14</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Cream of broccoli</a> </h5>
                    <span class="dish-meta"> broccoli /  milk  / cream </span>
                    <div class="dish-price">
                      <p>$9</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.soup -->
        <!-- main course -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <div class="menu-block">
            <h3 class="menu-title">Main Course</h3>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Biryani</a></h5>
                    <span class="dish-meta"> Onion  /  Tomato</span>
                    <div class="dish-price">
                      <p>$14</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Paneer Butter Masala</a></h5>
                    <span class="dish-meta">Aloo Masala  /  Aloo Palak
</span>
                    <div class="dish-price">
                      <p>$11</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="menu-content">
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                  <div class="dish-img"><a href="#"><img src="{{url('images/avatar_default.png')}}" alt="" class="img-circle"></a></div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                  <div class="dish-content">
                    <h5 class="dish-title"><a href="#">Chole Bhature</a> </h5>
                    <span class="dish-meta"> Rice Soft Idli  /  Ragi idli  /  Oats Idli </span>
                    <div class="dish-price">
                      <p>$8</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.main Course -->
      </div>
      <div class="clearfix"></div>
    </div>
  </div>

</div>
@endsection
