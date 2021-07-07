<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-<?php echo e(setting('theme_contrast')); ?>-<?php echo e(setting('theme_color')); ?> elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(url('dashboard')); ?>" class="brand-link" style="background-color: #ffc107 !important;">
        <img src="<?php echo e($app_logo); ?>" alt="<?php echo e(setting('app_name')); ?>" class="brand-image">
        <span class="brand-text font-weight-light"><br></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php echo $__env->make('layouts.menu',['icons'=>true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH C:\xampp\htdocs\eezlyapi\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>