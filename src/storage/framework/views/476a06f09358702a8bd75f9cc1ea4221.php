<?php $__env->startSection('content'); ?>
    <div class="m-auto bg-white p-4 w-fit rounded">
        <h1 class="text-2xl mb-2 text-center">Add product</h1>

        <form action="<?php echo e(route('product.store')); ?>" method="POST" class="flex flex-col gap-2 mb-5">
            <?php echo csrf_field(); ?>
            <input type="text" name="name" id="" placeholder="Name" value="<?php echo e(old('name')); ?>">
            <input type="text" name="description" id="" placeholder="Description" value="<?php echo e(old('description')); ?>">
            <button class="rounded bg-emerald-400 text-white py-2 px-3">Save</button>
        </form>

        <?php if(session()->has('success')): ?>
            <p class="mt-2 text-emerald-400"><?php echo e(session('success')); ?></p>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <p class="mt-2 text-rose-400"><?php echo e($e); ?></p>
        <?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalb1d4134143f55fc997e08cda2165deff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb1d4134143f55fc997e08cda2165deff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.bladewind.table','data' => ['hoverEffect' => 'false']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bladewind.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['hover_effect' => 'false']); ?>
             <?php $__env->slot('header', null, []); ?> 
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created at</th>
                <th>Updated at</th>
             <?php $__env->endSlot(); ?>

            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($p->_id); ?></td>
                    <td><?php echo e($p->name); ?></td>
                    <td><?php echo e($p->description); ?></td>
                    <td><?php echo e($p->created_at); ?></td>
                    <td><?php echo e($p->updated_at); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb1d4134143f55fc997e08cda2165deff)): ?>
<?php $attributes = $__attributesOriginalb1d4134143f55fc997e08cda2165deff; ?>
<?php unset($__attributesOriginalb1d4134143f55fc997e08cda2165deff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb1d4134143f55fc997e08cda2165deff)): ?>
<?php $component = $__componentOriginalb1d4134143f55fc997e08cda2165deff; ?>
<?php unset($__componentOriginalb1d4134143f55fc997e08cda2165deff); ?>
<?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/product/add.blade.php ENDPATH**/ ?>