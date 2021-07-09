<?php if($customFields): ?>
    <h5 class="col-12 pb-4"><?php echo trans('lang.main_fields'); ?></h5>
<?php endif; ?>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name Field -->
    <div class="form-group row ">
        <?php echo Form::label('name', trans("lang.restaurant_name"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.restaurant_name_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_name_help")); ?>

            </div>
        </div>
    </div>

    <?php if(auth()->check() && auth()->user()->hasAnyRole('admin|manager')): ?>
    <!-- Users Field -->
    
        
        
            
            
        
    
    <!-- delivery_fee Field -->
    <div class="form-group row ">
        <?php echo Form::label('delivery_fee', trans("lang.restaurant_delivery_fee"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::number('delivery_fee', null,  ['class' => 'form-control','step'=>'any','placeholder'=>  trans("lang.restaurant_delivery_fee_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_delivery_fee_help")); ?>

            </div>
        </div>
    </div>

    <!-- delivery_time Field -->
    <div class="form-group row ">
        <?php echo Form::label('delivery_time',"Delivery Time(mins)", ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::number('delivery_time', null,  ['class' => 'form-control','step'=>'any','placeholder'=>  '30']); ?>

            <div class="form-text text-muted">
               Insert the Expected Delivery time in Minutes
            </div>
        </div>
    </div>

    <!-- delivery_range Field -->
    <div class="form-group row ">
        <?php echo Form::label('delivery_range', trans("lang.restaurant_delivery_range"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::number('delivery_range', null,  ['class' => 'form-control', 'step'=>'any','placeholder'=>  trans("lang.restaurant_delivery_range_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_delivery_range_help")); ?>

            </div>
        </div>
    </div>

    <!-- default_tax Field -->
    <div class="form-group row ">
        <?php echo Form::label('default_tax', trans("lang.restaurant_default_tax"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::number('default_tax', null,  ['class' => 'form-control', 'step'=>'any','placeholder'=>  trans("lang.restaurant_default_tax_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_default_tax_help")); ?>

            </div>
        </div>
    </div>

    <?php endif; ?>

    <!-- Phone Field -->
    <div class="form-group row ">
        <?php echo Form::label('phone', trans("lang.restaurant_phone"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('phone', null,  ['class' => 'form-control','placeholder'=>  trans("lang.restaurant_phone_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_phone_help")); ?>

            </div>
        </div>
    </div>

    <!-- Mobile Field -->
    <div class="form-group row ">
        <?php echo Form::label('mobile', trans("lang.restaurant_mobile"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('mobile', null,  ['class' => 'form-control','placeholder'=>  trans("lang.restaurant_mobile_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_mobile_help")); ?>

            </div>
        </div>
    </div>

    <!-- Address Field -->
    <div class="form-group row ">
        <?php echo Form::label('address', trans("lang.restaurant_address"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('address', null,  ['class' => 'form-control','placeholder'=>  trans("lang.restaurant_address_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_address_help")); ?>

            </div>
        </div>
    </div>

    <!-- Latitude Field -->
    <div class="form-group row ">
        <?php echo Form::label('latitude', trans("lang.restaurant_latitude"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('latitude', null,  ['class' => 'form-control','placeholder'=>  trans("lang.restaurant_latitude_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_latitude_help")); ?>

            </div>
        </div>
    </div>

    <!-- Longitude Field -->
    <div class="form-group row ">
        <?php echo Form::label('longitude', trans("lang.restaurant_longitude"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('longitude', null,  ['class' => 'form-control','placeholder'=>  trans("lang.restaurant_longitude_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.restaurant_longitude_help")); ?>

            </div>
        </div>
    </div>
    <!-- 'Boolean closed Field' -->
    <div class="form-group row ">
        <?php echo Form::label('closed', trans("lang.restaurant_closed"),['class' => 'col-3 control-label text-right']); ?>

        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                <?php echo Form::hidden('closed', 0); ?>

                <?php echo Form::checkbox('closed', 1, null); ?>

            </label>
        </div>
    </div>

    <!-- 'Boolean available_for_delivery Field' -->
    <div class="form-group row ">
        <?php echo Form::label('available_for_delivery', trans("lang.restaurant_available_for_delivery"),['class' => 'col-3 control-label text-right']); ?>

        <div class="checkbox icheck">
            <label class="col-9 ml-2 form-check-inline">
                <?php echo Form::hidden('available_for_delivery', 0); ?>

                <?php echo Form::checkbox('available_for_delivery', 1, null); ?>

            </label>
        </div>
    </div>

    <!-- Longitude Field -->
    <div class="form-group row ">
        <?php echo Form::label('opening_hour', 'Opening Hour', ['class' => 'col-2 control-label text-right']); ?>

        <div class="col-4">
            <?php echo Form::text('opening_hour', null,  ['id'=>'timePickerOpeningHour','class' => 'form-control timepickerHours','placeholder'=>  'Opening time','readonly'=>'readonly']); ?>

            <div class="form-text text-muted">
                Select Opening Hour
            </div>
        </div>
        <?php echo Form::label('closing_hour', 'Closing Time', ['class' => 'col-2 control-label text-right']); ?>

        <div class="col-4">
            <?php echo Form::text('closing_hour', null,  ['id'=>'timePickerClosingHour','class' => 'form-control timepickerHours','placeholder'=>  'Closing time','readonly'=>'readonly']); ?>

            <div class="form-text text-muted">
                Select Closing Hour
            </div>
        </div>
    </div>


</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

    <!-- Image Field -->
    <div class="form-group row">
        <?php echo Form::label('image', trans("lang.restaurant_image"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <div style="width: 100%" class="dropzone image" id="image" data-field="image">
                <input type="hidden" name="image">
            </div>
            <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-<?php echo e(setting('theme_color','primary')); ?> btn-sm float-right mt-1"><?php echo e(trans('lang.media_select')); ?></a>
            <div class="form-text text-muted w-50">
                <?php echo e(trans("lang.restaurant_image_help")); ?>

            </div>
        </div>
    </div>
    <?php $__env->startPrepend('scripts'); ?>
        <script type="text/javascript">
            var var15671147011688676454ble = '';
            <?php if(isset($restaurant) && $restaurant->hasMedia('image')): ?>
                var15671147011688676454ble = {
                name: "<?php echo $restaurant->getFirstMedia('image')->name; ?>",
                size: "<?php echo $restaurant->getFirstMedia('image')->size; ?>",
                type: "<?php echo $restaurant->getFirstMedia('image')->mime_type; ?>",
                collection_name: "<?php echo $restaurant->getFirstMedia('image')->collection_name; ?>"
            };
                    <?php endif; ?>
            var dz_var15671147011688676454ble = $(".dropzone.image").dropzone({
                    url: "<?php echo url('uploads/store'); ?>",
                    addRemoveLinks: true,
                    maxFiles: 1,
                    init: function () {
                        <?php if(isset($restaurant) && $restaurant->hasMedia('image')): ?>
                        dzInit(this, var15671147011688676454ble, '<?php echo url($restaurant->getFirstMediaUrl('image','thumb')); ?>')
                        <?php endif; ?>
                    },
                    accept: function (file, done) {
                        dzAccept(file, done, this.element, "<?php echo config('medialibrary.icons_folder'); ?>");
                    },
                    sending: function (file, xhr, formData) {
                        dzSending(this, file, formData, '<?php echo csrf_token(); ?>');
                    },
                    maxfilesexceeded: function (file) {
                        dz_var15671147011688676454ble[0].mockFile = '';
                        dzMaxfile(this, file);
                    },
                    complete: function (file) {
                        dzComplete(this, file, var15671147011688676454ble, dz_var15671147011688676454ble[0].mockFile);
                        dz_var15671147011688676454ble[0].mockFile = file;
                    },
                    removedfile: function (file) {
                        dzRemoveFile(
                            file, var15671147011688676454ble, '<?php echo url("restaurants/remove-media"); ?>',
                            'image', '<?php echo isset($restaurant) ? $restaurant->id : 0; ?>', '<?php echo url("uplaods/clear"); ?>', '<?php echo csrf_token(); ?>'
                        );
                    }
                });
            dz_var15671147011688676454ble[0].mockFile = var15671147011688676454ble;
            dropzoneFields['image'] = dz_var15671147011688676454ble;
        </script>
<?php $__env->stopPrepend(); ?>

<!-- Description Field -->
    <div class="form-group row ">
        <?php echo Form::label('description', trans("lang.restaurant_description"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::textarea('description', null, ['class' => 'form-control','placeholder'=>
             trans("lang.restaurant_description_placeholder")  ]); ?>

            <div class="form-text text-muted"><?php echo e(trans("lang.restaurant_description_help")); ?></div>
        </div>
    </div>
    <!-- Information Field -->
    <div class="form-group row ">
        <?php echo Form::label('information', trans("lang.restaurant_information"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::textarea('information', null, ['class' => 'form-control','placeholder'=>
             trans("lang.restaurant_information_placeholder")  ]); ?>

            <div class="form-text text-muted"><?php echo e(trans("lang.restaurant_information_help")); ?></div>
        </div>
    </div>

<!-- Information Field -->
    <div class="form-group row ">
        <?php echo Form::label('french_information', 'French Information', ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::textarea('french_information', null, ['class' => 'form-control','placeholder'=>
             trans("lang.restaurant_information_placeholder")  ]); ?>

            <div class="form-text text-muted"><?php echo e(trans("lang.restaurant_information_help")); ?></div>
        </div>
    </div>

</div>

<?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
<div class="col-12 custom-field-container">
    <h5 class="col-12 pb-4"><?php echo trans('lang.admin_area'); ?></h5>
    <div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
        <!-- Users Field -->
        <div class="form-group row ">
            <?php echo Form::label('users[]', trans("lang.restaurant_users"),['class' => 'col-3 control-label text-right']); ?>

            <div class="col-9">
                <?php echo Form::select('users[]', $user, $usersSelected, ['class' => 'select2 form-control' , 'multiple'=>'multiple']); ?>

                <div class="form-text text-muted"><?php echo e(trans("lang.restaurant_users_help")); ?></div>
            </div>
        </div>

        <!-- cuisines Field -->
        <div class="form-group row ">
            <?php echo Form::label('cuisines[]', trans("lang.restaurant_cuisines"),['class' => 'col-3 control-label text-right']); ?>

            <div class="col-9">
                <?php echo Form::select('cuisines[]', $cuisine, $cuisinesSelected, ['class' => 'select2 form-control' , 'multiple'=>'multiple']); ?>

                <div class="form-text text-muted"><?php echo e(trans("lang.restaurant_cuisines_help")); ?></div>
            </div>
        </div>

    </div>
    <div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
        <!-- admin_commission Field -->
        <div class="form-group row ">
            <?php echo Form::label('admin_commission', trans("lang.restaurant_admin_commission"), ['class' => 'col-3 control-label text-right']); ?>

            <div class="col-9">
                <?php echo Form::number('admin_commission', null,  ['class' => 'form-control', 'step'=>'any', 'placeholder'=>  trans("lang.restaurant_admin_commission_placeholder")]); ?>

                <div class="form-text text-muted">
                    <?php echo e(trans("lang.restaurant_admin_commission_help")); ?>

                </div>
            </div>
        </div>
        <!-- delivery_type Field -->
        <div class="form-group row ">
            <?php echo Form::label('deliveryTypes[]', trans("lang.restaurant_delivery_types"),['class' => 'col-3 control-label text-right']); ?>

            <div class="col-9">
                <?php echo Form::select('deliveryTypes[]', $deliveryType, $deliveryTypesSelected, ['class' => 'select2 form-control' , 'multiple'=>'multiple']); ?>

                <div class="form-text text-muted"><?php echo e(trans("lang.restaurant_delivery_types_help")); ?></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if($customFields): ?>
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4"><?php echo trans('lang.custom_field_plural'); ?></h5>
        <?php echo $customFields; ?>

    </div>
<?php endif; ?>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-<?php echo e(setting('theme_color')); ?>"><i class="fa fa-save"></i> <?php echo e(trans('lang.save')); ?> <?php echo e(trans('lang.restaurant')); ?></button>
    <a href="<?php echo route('restaurants.index'); ?>" class="btn btn-default"><i class="fa fa-undo"></i> <?php echo e(trans('lang.cancel')); ?></a>
</div>
<?php /**PATH C:\xampp\htdocs\eezlyapi\resources\views/restaurants/fields.blade.php ENDPATH**/ ?>