<!-- Id Field -->
<div class="form-group row col-6">
  {!! Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $extra->id !!}</p>
  </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
  {!! Form::label('name', 'Name:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $extra->name !!}</p>
  </div>
</div>


<!-- Description Field -->
<div class="form-group row col-6">
  {!! Form::label('description', 'Description:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! $extra->description !!}
  </div>
</div>

<!-- Price Field -->
<div class="form-group row col-6">
  {!! Form::label('price', 'Price:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $extra->price !!}</p>
  </div>
</div>

<!-- Food Id Field -->
<div class="form-group row col-6">
  {!! Form::label('food_id', 'Food Id:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $extra->food_id !!}</p>
  </div>
</div>

<!-- Created At Field -->
<div class="form-group row col-6">
  {!! Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $extra->created_at !!}</p>
  </div>
</div>


<!-- Minimum Field -->
<div class="form-group row col-6">
  {!! Form::label('min', 'Minimum Limit:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $extra->min !!}</p>
  </div>
</div>

<!-- Maximum Field -->
<div class="form-group row col-6">
  {!! Form::label('max', 'Maximum Limit:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! $extra->max !!}</p>
  </div>
</div>

<!-- Is featured Field -->
<div class="form-group row col-6">
  {!! Form::label('featured', 'Is featured:', ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    <p>{!! ($extra->featured) ? 'True'  : 'False' !!}</p>
  </div>
</div>


