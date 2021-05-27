<div class="card">
    <div class="card-header">
        <h2 class="m-0 text-dark" >Menu</h2>
        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
            <li class="nav-item">
                <a class="nav-link btn-default" href="{!! route('foods.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.food_table')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-outline-success active" href="{!!  route('foods.create',['restaurant_id' => $restaurant->id]) !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.food_add')}}</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="row">
            @if(!empty($menu))
            @foreach($menu as $item)
            <!-- Menu section -->
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="menu-block">
                    <h3 class="menu-title">{{$item['category']}}</h3>
                    @foreach($item['foods'] as $food)
                    <!--Single food-->
                    <div class="menu-content">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-11">
                                <div class="dish-img"><a href="{{ route('foods.show', $food->id) }}"><img src="{{($food->getHasMediaAttribute())  ? $food->getFirstMediaUrl('image', 'icon') : url('images/image_default.png')}}" alt="" class="img-circle"></a></div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-11">
                                <div class="dish-content">
                                    <h5 class="dish-title"><a href="{{ route('foods.show', $food->id) }}">{{$food->name}}</a></h5>
                                    <span class="dish-meta ellipsis">{!!$food->description!!}</span>
                                    <div class="dish-price">
                                        <p>{!! getPrice($food->price) !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                @can('foods.edit')
                                    <a data-toggle="tooltip" data-placement="bottom" title="{{trans('lang.food_edit')}}" href="{{route('foods.edit', ['id'=>$food->id,'restaurant_id' => $restaurant->id]) }}" class='btn btn-link'>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                    @can('foods.destroy')
                                        {!! Form::open(['route' => ['foods.destroy', $food->id], 'method' => 'delete']) !!}
                                        {!! Form::button('<i class="fa fa-trash"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-link text-danger',
                                        'onclick' => "return confirm('Are you sure?')"
                                        ]) !!}
                                        {!! Form::close() !!}
                                    @endcan
                            </div>
                        </div>
                    </div>
                    <!--Single food end-->
                        @endforeach
                </div>
            </div>
            <!-- /.Menu section -->
            @endforeach
            @else
                <p>No Food Items available for the restaurant. Please add foods to see menu.</p>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
</div>