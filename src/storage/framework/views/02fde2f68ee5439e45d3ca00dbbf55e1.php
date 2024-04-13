<?php $__env->startSection('content'); ?>
    <div class="m-auto bg-white p-4 w-fit rounded">
        <h1 class="text-2xl mb-2 text-center">Add serial number</h1>

        <form action="<?php echo e(route('product.store-serial-number')); ?>" method="POST" class="flex flex-col gap-2">
            <?php echo csrf_field(); ?>
            <select name="product_id" id="">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->_id); ?>"><?php echo e($p->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="text" name="serial_number" id="" placeholder="Serial number">
            <input type="text" name="warehouse_id" id="" placeholder="Warehouse ID">
            <button class="rounded bg-emerald-400 text-white py-2 px-3">Save</button>
        </form>

        <?php if(session()->has('success')): ?>
            <p class="mt-2 text-emerald-400"><?php echo e(session('success')); ?></p>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <p class="mt-2 text-rose-400"><?php echo e($e); ?></p>
        <?php endif; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/product/add-serial-number.blade.php ENDPATH**/ ?>