<?php $__env->startSection('css_custom'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/menu-custom.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"><?php echo e(trans('lang.restaurant_plural')); ?><small class="ml-3 mr-3">|</small><small><?php echo e(trans('lang.restaurant_desc')); ?></small></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('lang.dashboard')); ?></a></li>
          <li class="breadcrumb-itema ctive"><a href="<?php echo route('restaurants.index'); ?>"><?php echo e(trans('lang.restaurant_plural')); ?></a>
          </li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
  <div class="clearfix"></div>
  <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo route('restaurants.index'); ?>"><i class="fa fa-list mr-2"></i><?php echo e(trans('lang.restaurant_table')); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?php echo route('restaurants.create'); ?>"><i class="fa fa-plus mr-2"></i><?php echo e(trans('lang.restaurant_create')); ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active " href="<?php echo route('restaurants.edit',$restaurant->id); ?>"><i class="fa fa-edit mr-2"></i><?php echo e(trans('lang.restaurant_edit')); ?></a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="row">
        <?php echo $__env->make('restaurants.show_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Back Field -->
        <div class="form-group col-12 text-right">
          <a href="<?php echo route('restaurants.index'); ?>" class="btn btn-default"><i class="fa fa-undo"></i> <?php echo e(trans('lang.back')); ?></a>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <?php echo $__env->make('restaurants.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webapi\resources\views/restaurants/show.blade.php ENDPATH**/ ?>