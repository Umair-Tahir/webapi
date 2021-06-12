
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Name Field -->
<div class="form-group row ">
  {!! Form::label('name', trans("lang.extra_group_name"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.extra_group_name_placeholder")]) !!}
    <div class="form-text text-muted">
      {{ trans("lang.extra_group_name_help") }}
    </div>
  </div>
</div>
  <div class="form-group row">

    {!! Form::label('min', trans("lang.extra_group_min"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-3">
      {!! Form::number('min', null,  ['class' => 'form-control','step'=>'1','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57','placeholder'=>  trans("lang.extra_group_min_placeholder")]) !!}
      <div class="form-text text-muted">
        {{ trans("lang.extra_group_min_help") }}
      </div>
    </div>
    {!! Form::label('max', trans("lang.extra_group_max"), ['class' => 'col-2 control-label ']) !!}
    <div class="col-4">
      {!! Form::number('max', null,  ['class' => 'form-control','step'=>'1','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57','placeholder'=>  trans("lang.extra_group_max_placeholder")]) !!}
      <div class="form-text text-muted">
        {{ trans("lang.extra_group_max_help") }}
      </div>
    </div>
  </div>
</div>

<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
</div>

<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.extra_group')}}</button>
  <a href="{!! route('extraGroups.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
