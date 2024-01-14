<?php $__env->startSection('content'); ?>
    <attribute-group label="<?php echo e(__('Attribute Group Name')); ?>"
                     add="<?php echo e(__('Add')); ?>"
                     save="<?php echo e(__('Save')); ?>"
                     delete_label="<?php echo e(__('Delete')); ?>"
                     delete_confirm="<?php echo e(__('Do you want to delete it ?')); ?>"
                     edit_label="<?php echo e(__('Attribute Group Edit')); ?>"
                     update_group_action="<?php echo e(action('Admin\AttributeGroupController@update',$attributeGroup->id)); ?>"
                     store_group_attribute_action="<?php echo e(action('Admin\AttributeController@store')); ?>"
                     update_group_attribute_action="<?php echo e(action('Admin\AttributeController@update', '')); ?>"
                     :attribute_group="<?php echo e($attributeGroup); ?>"
                     attributes_label="<?php echo e(__('Attributes')); ?>"
                     attribute="<?php echo e(__('Attribute')); ?>"
                     add_attribute="<?php echo e(__('Add') . ' ' . __('New Attribute')); ?>">
    </attribute-group>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>