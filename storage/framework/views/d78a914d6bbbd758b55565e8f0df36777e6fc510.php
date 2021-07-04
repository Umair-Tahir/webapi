<!-- Id Field -->
<div class="form-group row col-6">
  <?php echo Form::label('id', 'Id:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->id; ?></p>
  </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
  <?php echo Form::label('name', 'Name:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->name; ?></p>
  </div>
</div>

<!-- Description Field -->
<div class="form-group row col-6">
  <?php echo Form::label('description', 'Description:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <?php echo $restaurant->description; ?>

  </div>
</div>

<!-- Address Field -->
<div class="form-group row col-6">
  <?php echo Form::label('address', 'Address:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->address; ?></p>
  </div>
</div>

<!-- Latitude Field -->
<div class="form-group row col-6">
  <?php echo Form::label('latitude', 'Latitude:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->latitude; ?></p>
  </div>
</div>

<!-- Longitude Field -->
<div class="form-group row col-6">
  <?php echo Form::label('longitude', 'Longitude:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->longitude; ?></p>
  </div>
</div>

<!-- Phone Field -->
<div class="form-group row col-6">
  <?php echo Form::label('phone', 'Phone:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->phone; ?></p>
  </div>
</div>

<!-- Mobile Field -->
<div class="form-group row col-6">
  <?php echo Form::label('mobile', 'Mobile:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->mobile; ?></p>
  </div>
</div>

<!-- Information Field -->
<div class="form-group row col-6">
  <?php echo Form::label('information', 'Information:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->information; ?></p>
  </div>
</div>

<!-- Created At Field -->
<div class="form-group row col-6">
  <?php echo Form::label('created_at', 'Created At:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->created_at; ?></p>
  </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
  <?php echo Form::label('updated_at', 'Updated At:', ['class' => 'col-3 control-label text-right']); ?>

  <div class="col-9">
    <p><?php echo $restaurant->updated_at; ?></p>
  </div>
</div>

<?php /**PATH C:\xampp\htdocs\webapi\resources\views/restaurants/show_fields.blade.php ENDPATH**/ ?>