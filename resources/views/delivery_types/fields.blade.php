
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Name deliveryTypes -->
<div class="form-group row ">
  {!! Form::label('name', trans("lang.delivery_type_name"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.delivery_type_name_placeholder")]) !!}
    <div class="form-text text-muted">
      {{ trans("lang.delivery_type_name_help") }}
    </div>
  </div>
</div>

<!-- Description delivery Types -->
<div class="form-group row ">
  {!! Form::label('description', trans("lang.delivery_type_description"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
     trans("lang.delivery_type_description_placeholder")  ]) !!}
    <div class="form-text text-muted">{{ trans("lang.delivery_type_description_help") }}</div>
  </div>
</div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">


</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.delivery_type')}}</button>
  <a href="{!! route('deliveryTypes.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
