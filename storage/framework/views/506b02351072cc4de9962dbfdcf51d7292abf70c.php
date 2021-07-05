<?php if($customFields): ?>
<h5 class="col-12 pb-4"><?php echo trans('lang.main_fields'); ?></h5>
<?php endif; ?>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
<!-- Restaurant Id Field -->
<div class="form-group row ">
  <?php echo Form::label('restaurant_id', trans("lang.restaurants_payout_restaurant_id"),['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <?php echo Form::select('restaurant_id', $restaurant, null, ['class' => 'select2 form-control']); ?>

    <div class="form-text text-muted"><?php echo e(trans("lang.restaurants_payout_restaurant_id_help")); ?></div>
  </div>
</div>


<!-- Method Field -->
<div class="form-group row ">
  <?php echo Form::label('method', trans("lang.restaurants_payout_method"),['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
      <?php echo Form::select('method', ['Bank' => trans('lang.bank'),'Cash'=> trans('lang.cash')], null, ['class' => 'select2 form-control']); ?>

    <div class="form-text text-muted"><?php echo e(trans("lang.restaurants_payout_method_help")); ?></div>
  </div>
</div>


<!-- Amount Field -->
<div class="form-group row ">
  <?php echo Form::label('amount', trans("lang.restaurants_payout_amount"), ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
      <?php echo Form::number('amount', null,  ['class' => 'form-control','step'=>"any",'placeholder'=>  trans("lang.restaurants_payout_amount_placeholder")]); ?>

    <div class="form-text text-muted">
      <?php echo e(trans("lang.restaurants_payout_amount_help")); ?>

    </div>
  </div>
</div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

<!-- Note Field -->
<div class="form-group row ">
  <?php echo Form::label('note', trans("lang.restaurants_payout_note"), ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <?php echo Form::textarea('note', null, ['class' => 'form-control','placeholder'=>
     trans("lang.restaurants_payout_note_placeholder")  ]); ?>

    <div class="form-text text-muted"><?php echo e(trans("lang.restaurants_payout_note_help")); ?></div>
  </div>
</div>
</div>
<?php if($customFields): ?>
<div class="clearfix"></div>
<div class="col-12 custom-field-container">
  <h5 class="col-12 pb-4"><?php echo trans('lang.custom_field_plural'); ?></h5>
  <?php echo $customFields; ?>

</div>
<?php endif; ?>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-<?php echo e(setting('theme_color')); ?>" ><i class="fa fa-save"></i> <?php echo e(trans('lang.save')); ?> <?php echo e(trans('lang.restaurants_payout')); ?></button>
  <a href="<?php echo route('restaurantsPayouts.index'); ?>" class="btn btn-default"><i class="fa fa-undo"></i> <?php echo e(trans('lang.cancel')); ?></a>
</div>
<?php /**PATH C:\xampp\htdocs\eezlyapi\resources\views/restaurants_payouts/fields.blade.php ENDPATH**/ ?>