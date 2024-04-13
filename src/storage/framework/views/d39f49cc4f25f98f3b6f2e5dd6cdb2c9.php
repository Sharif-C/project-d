<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
        <link href="<?php echo e(asset('vendor/bladewind/css/animate.min.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('vendor/bladewind/css/bladewind-ui.min.css')); ?>" rel="stylesheet" />
        <script src="<?php echo e(asset('vendor/bladewind/js/helpers.js')); ?>"></script>

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased">
        <div class="h-[100vh] bg-gray-100 py-4">
            <!-- Page Content -->
            <main class="h-[100vh]">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/main.blade.php ENDPATH**/ ?>