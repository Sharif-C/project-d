<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('warehouse.delete')); ?>" method="POST" class="bg-indigo-500 p-2 rounded m-auto">
        <?php echo csrf_field(); ?>
        <input type="text" name="name" placeholder="Warehouse name" required>
        <button class="p-2 bg-emerald-500 text-white rounded">Save</button>
    </form>
<?php $__env->stopSection(); ?>
 
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/warehouse/delete.blade.php ENDPATH**/ ?>