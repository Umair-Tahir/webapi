<?php $__env->startSection('content'); ?>
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?php echo e(__('auth.register_new_member')); ?></p>

        <form action="<?php echo e(url('/register')); ?>" method="post">
            <?php echo csrf_field(); ?>


            <div class="input-group mb-3">
                <input value="<?php echo e(old('name')); ?>" type="name" class="form-control <?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" placeholder="<?php echo e(__('auth.name')); ?>" aria-label="<?php echo e(__('auth.name')); ?>">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                <?php if($errors->has('name')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('name')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="input-group mb-3">
                <input value="<?php echo e(old('email')); ?>" type="email" class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" placeholder="<?php echo e(__('auth.email')); ?>" aria-label="<?php echo e(__('auth.email')); ?>">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                </div>
                <?php if($errors->has('email')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('email')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="input-group mb-3">
                <input value="<?php echo e(old('password')); ?>" type="password" class="form-control  <?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" placeholder="<?php echo e(__('auth.password')); ?>" aria-label="<?php echo e(__('auth.password')); ?>">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                <?php if($errors->has('password')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('password')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="input-group mb-3">
                <input value="<?php echo e(old('password_confirmation')); ?>" type="password" class="form-control  <?php echo e($errors->has('password_confirmation') ? ' is-invalid' : ''); ?>" name="password_confirmation" placeholder="<?php echo e(__('auth.password_confirmation')); ?>" aria-label="<?php echo e(__('auth.password_confirmation')); ?>">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                <?php if($errors->has('password_confirmation')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('password_confirmation')); ?>

                    </div>
                <?php endif; ?>
            </div>

            <div class="row mb-2">
                <div class="col-8">
                    <div class="checkbox icheck">
                        <label> <input type="checkbox" name="remember"> <?php echo e(__('auth.agree')); ?></label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block"><?php echo e(__('auth.register')); ?></button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mb-1 text-center">
            <a href="<?php echo e(url('/login')); ?>"><?php echo e(__('auth.already_member')); ?></a>
        </p>
    </div>
    <!-- /.login-card-body -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\eezlyapi\resources\views/auth/register.blade.php ENDPATH**/ ?>