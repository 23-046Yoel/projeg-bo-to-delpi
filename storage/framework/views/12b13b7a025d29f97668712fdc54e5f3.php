<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['active']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['active']); ?>
<?php foreach (array_filter((['active']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
$classes = ($active ?? false)
            ? 'flex items-center w-full px-8 py-4 text-sm font-bold text-gray-900 bg-gold/5 border-r-4 border-gold group transition-all duration-300'
            : 'flex items-center w-full px-8 py-4 text-sm font-semibold text-gray-600 hover:text-gray-900 hover:bg-gold/5 border-r-4 border-transparent hover:border-gold/20 group transition-all duration-300';
?>

<a <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <?php echo e($slot); ?>

</a>
    <?php /**PATH C:\laragon\www\projeg Bo To Delpi\resources\views/components/nav-link.blade.php ENDPATH**/ ?>