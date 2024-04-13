<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => false,
    // should the table with displayed with a drop-shadow effect
    'has_shadow' => false,
    'hasShadow' => false,
    // should the table have a border on all four sides
    'has_border' => false,
    // should the table have row dividers
    'divided' => true,
    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => 'regular',
    // should rows light up on hover
    'hover_effect' => true,
    'hoverEffect' => true,
    // should the rows be tighter together
    'compact' => false,
    // provide a table name you can access via css
    'name' => 'tbl-'.uniqid(),
    'data' => null,
    'exclude_columns' => null,
    'include_columns' => null,
    'action_icons' => null,
    'actions_title' => 'actions',
    'column_aliases' => [],
    'searchable' => false,
    'search_placeholder' => 'Search table below...',
    'uppercasing' => true,
    'no_data_message' => 'No records to display',
    'message_as_empty_state' => false,
    // parameters expected by the empty state component ---------------
    'image' => asset('vendor/bladewind/images/empty-state.svg'),
    'heading' => '',
    'button_label' => '',
    'show_image' => true,
    'onclick' => '',
    //------------------ end empty state parameters -------------------
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => false,
    // should the table with displayed with a drop-shadow effect
    'has_shadow' => false,
    'hasShadow' => false,
    // should the table have a border on all four sides
    'has_border' => false,
    // should the table have row dividers
    'divided' => true,
    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => 'regular',
    // should rows light up on hover
    'hover_effect' => true,
    'hoverEffect' => true,
    // should the rows be tighter together
    'compact' => false,
    // provide a table name you can access via css
    'name' => 'tbl-'.uniqid(),
    'data' => null,
    'exclude_columns' => null,
    'include_columns' => null,
    'action_icons' => null,
    'actions_title' => 'actions',
    'column_aliases' => [],
    'searchable' => false,
    'search_placeholder' => 'Search table below...',
    'uppercasing' => true,
    'no_data_message' => 'No records to display',
    'message_as_empty_state' => false,
    // parameters expected by the empty state component ---------------
    'image' => asset('vendor/bladewind/images/empty-state.svg'),
    'heading' => '',
    'button_label' => '',
    'show_image' => true,
    'onclick' => '',
    //------------------ end empty state parameters -------------------
]); ?>
<?php foreach (array_filter(([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => false,
    // should the table with displayed with a drop-shadow effect
    'has_shadow' => false,
    'hasShadow' => false,
    // should the table have a border on all four sides
    'has_border' => false,
    // should the table have row dividers
    'divided' => true,
    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => 'regular',
    // should rows light up on hover
    'hover_effect' => true,
    'hoverEffect' => true,
    // should the rows be tighter together
    'compact' => false,
    // provide a table name you can access via css
    'name' => 'tbl-'.uniqid(),
    'data' => null,
    'exclude_columns' => null,
    'include_columns' => null,
    'action_icons' => null,
    'actions_title' => 'actions',
    'column_aliases' => [],
    'searchable' => false,
    'search_placeholder' => 'Search table below...',
    'uppercasing' => true,
    'no_data_message' => 'No records to display',
    'message_as_empty_state' => false,
    // parameters expected by the empty state component ---------------
    'image' => asset('vendor/bladewind/images/empty-state.svg'),
    'heading' => '',
    'button_label' => '',
    'show_image' => true,
    'onclick' => '',
    //------------------ end empty state parameters -------------------
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    // reset variables for Laravel 8 support
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    $hover_effect = filter_var($hover_effect, FILTER_VALIDATE_BOOLEAN);
    $hoverEffect = filter_var($hoverEffect, FILTER_VALIDATE_BOOLEAN);
    $striped = filter_var($striped, FILTER_VALIDATE_BOOLEAN);
    $compact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
    $divided = filter_var($divided, FILTER_VALIDATE_BOOLEAN);
    $searchable = filter_var($searchable, FILTER_VALIDATE_BOOLEAN);
    $uppercasing = filter_var($uppercasing, FILTER_VALIDATE_BOOLEAN);
    $message_as_empty_state = filter_var($message_as_empty_state, FILTER_VALIDATE_BOOLEAN);
    if ($hasShadow) $has_shadow = $hasShadow;
    if (!$hoverEffect) $hover_effect = $hoverEffect;
    $exclude_columns = !empty($exclude_columns) ? explode(',', str_replace(' ','', $exclude_columns)) : [];
    $action_icons = (!empty($action_icons)) ? ((is_array($action_icons)) ?
        $action_icons : json_decode(str_replace('&quot;', '"', $action_icons), true)) : [];
    $column_aliases = (!empty($column_aliases)) ? ((is_array($column_aliases)) ?
        $column_aliases : json_decode(str_replace('&quot;', '"', $column_aliases), true)) : [];
    $icons_array = [];

    if (!is_null($data)) {
        $data = (!is_array($data)) ? json_decode(str_replace('&quot;', '"', $data), true) : $data;
        $total_records = count($data);
        $table_headings = ($total_records > 0) ? array_keys((array) $data[0]) : [];

        if(!empty($exclude_columns)) {
            $table_headings = array_filter($table_headings,
            function($column) use ( $exclude_columns) {
                if(!in_array($column, $exclude_columns)) return $column;
            });
        }

        if( !empty($include_columns) ) {
            $table_headings = explode(',', str_replace(' ','', $include_columns));
        }

        // build action icons
        foreach ($action_icons as $action) {
            $action_array = explode('|',$action);
            $temp = [];
            foreach($action_array as $action){
                $hmm = explode(':', $action);
                $temp[trim($hmm[0])] = trim($hmm[1]);
            }
            $icons_array[] = $temp;
        }

        if(!function_exists('build_click')){
            function build_click($click, $row_data){
                return preg_replace_callback('/{\w+}/', function ($matches) use ($row_data) {
                    foreach($matches as $match) {
                        return $row_data[str_replace('}', '', str_replace('{', '', $match))];
                    }
                }, $click);
            }
        }
    }
?>
<div class="<?php if($has_border): ?> border border-gray-200 dark:border-dark-700/60 dark:px-[1px] <?php endif; ?> max-w-full">
    <div class="w-full">
        <?php if($searchable): ?>
            <div class="bw-table-filter-bar">
                <?php if (isset($component)) { $__componentOriginal399ab5ed63addab89395df8c37031002 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399ab5ed63addab89395df8c37031002 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'bladewind::components.input','data' => ['name' => 'bw-search-'.e($name).'','placeholder' => ''.e($search_placeholder).'','onkeyup' => 'filterTable(this.value, \'table.'.e($name).'\')','addClearing' => 'false','class' => '!mb-0 focus:!border-slate-300 !pl-11','clearable' => 'true','prefixIsIcon' => 'true','prefix' => 'magnifying-glass']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bladewind::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bw-search-'.e($name).'','placeholder' => ''.e($search_placeholder).'','onkeyup' => 'filterTable(this.value, \'table.'.e($name).'\')','add_clearing' => 'false','class' => '!mb-0 focus:!border-slate-300 !pl-11','clearable' => 'true','prefix_is_icon' => 'true','prefix' => 'magnifying-glass']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal399ab5ed63addab89395df8c37031002)): ?>
<?php $attributes = $__attributesOriginal399ab5ed63addab89395df8c37031002; ?>
<?php unset($__attributesOriginal399ab5ed63addab89395df8c37031002); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal399ab5ed63addab89395df8c37031002)): ?>
<?php $component = $__componentOriginal399ab5ed63addab89395df8c37031002; ?>
<?php unset($__componentOriginal399ab5ed63addab89395df8c37031002); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <table class="bw-table w-full <?php echo e($name); ?> <?php if($has_shadow): ?> shadow-2xl shadow-gray-200 dark:shadow-xl dark:shadow-dark-900 <?php endif; ?>
            <?php if($divided): ?> divided <?php if($divider=='thin'): ?> thin <?php endif; ?> <?php endif; ?>  <?php if($striped): ?> striped <?php endif; ?>
            <?php if($hover_effect): ?> with-hover-effect <?php endif; ?> <?php if($compact): ?> compact <?php endif; ?> <?php if($uppercasing): ?> uppercase-headers <?php endif; ?>">
            <?php if(is_null($data)): ?>
                <thead>
                <tr class="bg-gray-200 dark:bg-dark-800"><?php echo e($header); ?></tr>
                </thead>
                <tbody><?php echo e($slot); ?></tbody>
            <?php else: ?>

                <thead>
                <tr class="bg-gray-200 dark:bg-dark-800">
                    <?php
                        // if there are no records, build the headings with $column_headings if the array exists
                        $table_headings = ($total_records>0) ? $table_headings : (($column_aliases) ?? []);
                    ?>
                    <?php $__currentLoopData = $table_headings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e(str_replace('_',' ', $column_aliases[$th] ?? $th )); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if( !empty($action_icons)): ?>
                        <th class="!text-right"><?php echo e($actions_title); ?></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <?php if($total_records > 0): ?>
                    <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <?php $__currentLoopData = $table_headings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td><?php echo $row[$th]; ?></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if( !empty($icons_array) ): ?>
                                <td class="text-right space-x-2 actions">
                                    <?php $__currentLoopData = $icons_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($icon['icon'])): ?>
                                            <?php if(!empty($icon['tip'])): ?>
                                                <a data-tooltip="<?php echo e($icon['tip']); ?>" data-inverted=""
                                                   data-position="top center"> <?php endif; ?>
                                                    <?php if (isset($component)) { $__componentOriginalb4077406ec1be740458fd4823e4ae997 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb4077406ec1be740458fd4823e4ae997 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'bladewind::components.button.circle','data' => ['size' => 'tiny','icon' => ''.e($icon['icon']).'','color' => ''.e($icon['color'] ?? '').'','onclick' => ''.build_click($icon['click'], $row) ?? 'void(0)'.'','type' => ''.isset($icon['color']) ? 'primary' : 'secondary'.'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bladewind::button.circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'tiny','icon' => ''.e($icon['icon']).'','color' => ''.e($icon['color'] ?? '').'','onclick' => ''.build_click($icon['click'], $row) ?? 'void(0)'.'','type' => ''.isset($icon['color']) ? 'primary' : 'secondary'.'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb4077406ec1be740458fd4823e4ae997)): ?>
<?php $attributes = $__attributesOriginalb4077406ec1be740458fd4823e4ae997; ?>
<?php unset($__attributesOriginalb4077406ec1be740458fd4823e4ae997); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb4077406ec1be740458fd4823e4ae997)): ?>
<?php $component = $__componentOriginalb4077406ec1be740458fd4823e4ae997; ?>
<?php unset($__componentOriginalb4077406ec1be740458fd4823e4ae997); ?>
<?php endif; ?>
                                                    <?php if(!empty($icon['tip'])): ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo e(count($table_headings)); ?>" class="text-center">
                                <?php if($message_as_empty_state): ?>
                                    <?php if (isset($component)) { $__componentOriginalf281e3dc0c95fa53b3a01b5aa409f51b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf281e3dc0c95fa53b3a01b5aa409f51b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'bladewind::components.empty-state','data' => ['message' => $no_data_message,'buttonLabel' => $button_label,'onclick' => $onclick,'image' => $image,'showImage' => $show_image,'heading' => $heading]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bladewind::empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($no_data_message),'button_label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($button_label),'onclick' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($onclick),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($image),'show_image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($show_image),'heading' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($heading)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf281e3dc0c95fa53b3a01b5aa409f51b)): ?>
<?php $attributes = $__attributesOriginalf281e3dc0c95fa53b3a01b5aa409f51b; ?>
<?php unset($__attributesOriginalf281e3dc0c95fa53b3a01b5aa409f51b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf281e3dc0c95fa53b3a01b5aa409f51b)): ?>
<?php $component = $__componentOriginalf281e3dc0c95fa53b3a01b5aa409f51b; ?>
<?php unset($__componentOriginalf281e3dc0c95fa53b3a01b5aa409f51b); ?>
<?php endif; ?>
                                <?php else: ?>
                                    <?php echo e($no_data_message); ?>

                                <?php endif; ?>
                                <script>changeCss('.<?php echo e($name); ?>', 'with-hover-effect', 'remove');</script>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                <?php endif; ?>
        </table>
    </div>
</div><?php /**PATH /var/www/html/resources/views/components/bladewind/table.blade.php ENDPATH**/ ?>