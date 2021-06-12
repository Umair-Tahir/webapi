<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name Field -->
    <div class="form-group row ">
        {!! Form::label('name', trans("lang.extra_name"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.extra_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.extra_name_help") }}
            </div>
        </div>
    </div>
    <!-- Name Field -->
    <div class="form-group row ">
        {!! Form::label('french_name', 'French Name', ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::text('french_name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.extra_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.extra_name_help") }}
            </div>
        </div>
    </div>
    <!-- Image Field -->
    <div class="form-group row">
        {!! Form::label('image', trans("lang.extra_image"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            <div style="width: 100%" class="dropzone image" id="image" data-field="image">
                <input type="hidden" name="image">
            </div>
            <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.media_select')}}</a>
            <div class="form-text text-muted w-50">
                {{ trans("lang.extra_image_help") }}
            </div>
        </div>
    </div>
    @prepend('scripts')
        <script type="text/javascript">
            var var1567114747144268319ble = '';
            @if(isset($extra) && $extra->hasMedia('image'))
                var1567114747144268319ble = {
                name: "{!! $extra->getFirstMedia('image')->name !!}",
                size: "{!! $extra->getFirstMedia('image')->size !!}",
                type: "{!! $extra->getFirstMedia('image')->mime_type !!}",
                collection_name: "{!! $extra->getFirstMedia('image')->collection_name !!}"
            };
                    @endif
            var dz_var1567114747144268319ble = $(".dropzone.image").dropzone({
                    url: "{!!url('uploads/store')!!}",
                    addRemoveLinks: true,
                    maxFiles: 1,
                    init: function () {
                        @if(isset($extra) && $extra->hasMedia('image'))
                        dzInit(this, var1567114747144268319ble, '{!! url($extra->getFirstMediaUrl('image','thumb')) !!}')
                        @endif
                    },
                    accept: function (file, done) {
                        dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
                    },
                    sending: function (file, xhr, formData) {
                        dzSending(this, file, formData, '{!! csrf_token() !!}');
                    },
                    maxfilesexceeded: function (file) {
                        dz_var1567114747144268319ble[0].mockFile = '';
                        dzMaxfile(this, file);
                    },
                    complete: function (file) {
                        dzComplete(this, file, var1567114747144268319ble, dz_var1567114747144268319ble[0].mockFile);
                        dz_var1567114747144268319ble[0].mockFile = file;
                    },
                    removedfile: function (file) {
                        dzRemoveFile(
                            file, var1567114747144268319ble, '{!! url("extras/remove-media") !!}',
                            'image', '{!! isset($extra) ? $extra->id : 0 !!}', '{!! url("uplaods/clear") !!}', '{!! csrf_token() !!}'
                        );
                    }
                });
            dz_var1567114747144268319ble[0].mockFile = var1567114747144268319ble;
            dropzoneFields['image'] = dz_var1567114747144268319ble;
        </script>
@endprepend

<!-- Description Field -->
    <div class="form-group row ">
        {!! Form::label('description', trans("lang.extra_description"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
             trans("lang.extra_description_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.extra_description_help") }}</div>
        </div>
    </div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

    <!-- Price Field -->
    <div class="form-group row ">
        {!! Form::label('price', trans("lang.extra_price"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('price', null,  ['class' => 'form-control','step'=>"any",'placeholder'=>  trans("lang.extra_price_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.extra_price_help") }}
            </div>
        </div>
    </div>

    <!-- Food Id Field -->
    <div class="form-group row ">
        {!! Form::label('food_id', trans("lang.extra_food_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('food_id', $food, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.extra_food_id_help") }}</div>
        </div>
    </div>

    <!-- Extra Group Id Field -->
    <div class="form-group row ">
        {!! Form::label('extra_group_id', trans("lang.extra_extra_group_id"),['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::select('extra_group_id', $extraGroup, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.extra_extra_group_id_help") }}</div>
        </div>
    </div>

    <!-- Minimum limit Field -->
    <div class="form-group row ">
        {!! Form::label('min', trans("lang.extra_min"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('min', null,  ['class' => 'form-control','step'=>"1",'placeholder'=>  trans("lang.extra_min_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.extra_min_help") }}
            </div>
        </div>
    </div>

    <!-- Minimum limit Field -->
    <div class="form-group row ">
        {!! Form::label('max', trans("lang.extra_max"), ['class' => 'col-3 control-label text-right']) !!}
        <div class="col-9">
            {!! Form::number('max', null,  ['class' => 'form-control','step'=>"1",'placeholder'=>  trans("lang.extra_max_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.extra_max_help") }}
            </div>
        </div>
    </div>

    <!-- 'Boolean Featured Field' -->
    <div class="form-group row ">
        {!! Form::label('featured', trans("lang.extra_featured"),['class' => 'col-3 control-label text-right']) !!}
        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                {!! Form::hidden('featured', 0) !!}
                {!! Form::checkbox('featured', 1, null) !!}
            </label>
        </div>
    </div>

</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-{{setting('theme_color')}}"><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.extra')}}</button>
    <a href="{!! url()->previous() !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
