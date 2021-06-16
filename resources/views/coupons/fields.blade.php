
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Name Field -->
<div class="form-group row ">
  {!! Form::label('name', trans("lang.coupon_name"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.coupon_name_placeholder")]) !!}
    <div class="form-text text-muted">
      {{ trans("lang.coupon_name_help") }}
    </div>
  </div>
</div>

<!-- Description Field -->
<div class="form-group row ">
  {!! Form::label('description', trans("lang.coupon_description"), ['class' => 'col-3 control-label text-right']) !!}
  <div class="col-9">
    {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
     trans("lang.coupon_description_placeholder")  ]) !!}
    <div class="form-text text-muted">{{ trans("lang.coupon_description_help") }}</div>
  </div>
</div>

  <div class="form-group row ">
    {!! Form::label('starts_at', 'Start', ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-3">
      {!! Form::text('starts_at', old('starts_at'),  ['id'=>'timePickerOpeningHour','class' => 'form-control','placeholder'=>  trans('lang.coupon_starts_at')]) !!}
      <div class="form-text text-muted">
        Select Coupon Active Date
      </div>
    </div>
    {!! Form::label('expires_at', 'Expiry', ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-3">
      {!! Form::text('expires_at', old('expires_at'),  ['id'=>'timePickerClosingHour','class' => 'form-control','placeholder'=>  trans('lang.coupon_expires_at')]) !!}
      <div class="form-text text-muted">
        Select Coupon Expiry Date
      </div>
    </div>
  </div>
  <div class="form-group row ">
    {!! Form::label('active', trans("lang.coupon_active"),['class' => 'col-3 control-label text-right']) !!}
    <div class="checkbox icheck">
      <label class="col-9 ml-2 form-check-inline">
        {!! Form::hidden('active', 0) !!}
        {!! Form::checkbox('active', 1, null) !!}
      </label>
    </div>
  </div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
  <div class="form-group row ">
    {!! Form::label('code', trans("lang.coupon_code"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::text('code', null,  ['class' => 'form-control','style' => 'text-transform:uppercase','placeholder'=>  trans("lang.coupon_code_placeholder")]) !!}
      <div class="form-text text-muted">
        {{ trans("lang.coupon_code_help") }}
      </div>
    </div>
  </div>

  <div class="form-group row">

      {!! Form::label('max_uses', trans("lang.coupon_max_uses"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-3">
      {!! Form::number('max_uses', null,  ['class' => 'form-control','step'=>'1','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57','placeholder'=>  trans("lang.coupon_max_uses_placeholder")]) !!}
      <div class="form-text text-muted">
        {{ trans("lang.coupon_max_uses_help") }}
      </div>
    </div>
      {!! Form::label('max_uses_user', trans("lang.coupon_max_uses_user"), ['class' => 'col-2 control-label ']) !!}
    <div class="col-4">
      {!! Form::number('max_uses_user', null,  ['class' => 'form-control','step'=>'1','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57','placeholder'=>  trans("lang.coupon_max_uses_user_placeholder")]) !!}
      <div class="form-text text-muted">
        {{ trans("lang.coupon_max_uses_user_help") }}
      </div>
    </div>
  </div>
  <div class="form-group row ">
    {!! Form::label('type', trans("lang.coupon_type"),['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::select('type', array('' => trans('lang.coupon_type_placeholder')) + config('enums.coupon_types_array'), old('type'), ['class' => 'select2 form-control', 'id' => 'coupon_type']) !!}
      <div class="form-text text-muted">{{ trans("lang.coupon_type") }}</div>
    </div>
  </div>

  <div class="form-group row  coupon-type-1">
    {!! Form::label('discount_amount', trans("lang.coupon_discount_amount"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::number('discount_amount', null,  ['class' => 'form-control discount_amount_input', 'step'=>'any', 'placeholder'=>  trans("lang.coupon_discount_amount_placeholder")]) !!}
      <div class="form-text text-muted">
        {{ trans("lang.coupon_discount_amount_help") }}
      </div>
    </div>
  </div>

</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.coupon')}}</button>
  <a href="{!! route('coupons.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
