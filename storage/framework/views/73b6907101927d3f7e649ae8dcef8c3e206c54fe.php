<div class="card">
    <div class="card-header">
        <h2 class="m-0 text-dark" >Menu</h2>
        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
            <li class="nav-item">
                <a class="nav-link btn-default" href="<?php echo route('foods.index'); ?>"><i class="fa fa-list mr-2"></i><?php echo e(trans('lang.food_table')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-outline-success active" href="<?php echo route('foods.create',['restaurant_id' => $restaurant->id]); ?>"><i class="fa fa-plus mr-2"></i><?php echo e(trans('lang.food_add')); ?></a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if(!empty($menu)): ?>
            <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Menu section -->
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="menu-block">
                    <h3 class="menu-title"><?php echo e($item['category']); ?></h3>
                    <?php $__currentLoopData = $item['foods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $food): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--Single food-->
                    <div class="menu-content">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-11">
                                <div class="dish-img"><a href="<?php echo e(route('foods.show', $food->id)); ?>"><img src="<?php echo e(($food->getHasMediaAttribute())  ? $food->getFirstMediaUrl('image', 'icon') : url('images/image_default.png')); ?>" alt="" class="img-circle"></a></div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-11">
                                <div class="dish-content">
                                    <h5 class="dish-title"><a href="<?php echo e(route('foods.show', $food->id)); ?>"><?php echo e($food->name); ?></a></h5>
                                    <span class="dish-meta ellipsis"><?php echo $food->description; ?></span>
                                    <div class="dish-price">
                                        <p><?php echo getPrice($food->price); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('foods.edit')): ?>
                                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('lang.food_edit')); ?>" href="<?php echo e(route('foods.edit', ['id'=>$food->id,'restaurant_id' => $restaurant->id])); ?>" class='btn btn-link'>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('foods.destroy')): ?>
                                        <?php echo Form::open(['route' => ['foods.destroy', $food->id], 'method' => 'delete']); ?>

                                        <?php echo Form::button('<i class="fa fa-trash"></i>', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-link text-danger',
                                        'onclick' => "return confirm('Are you sure?')"
                                        ]); ?>

                                        <?php echo Form::close(); ?>

                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!--Single food end-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <!-- /.Menu section -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p>No Food Items available for the restaurant. Please add foods to see menu.</p>
            <?php endif; ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\webapi\resources\views/restaurants/menu.blade.php ENDPATH**/ ?>