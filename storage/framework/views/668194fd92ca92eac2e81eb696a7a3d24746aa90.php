<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo app('translator')->getFromJson('Delete'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo app('translator')->getFromJson('Are you sure you want to delete it?'); ?></p>
            </div>
            <form id="deleteForm" action="" method="POST">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson('Delete'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->getFromJson('Close'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    (function () {
        $(".delete-model").on("click", function () {
            $('#deleteForm').attr('action', '<?php echo e(strtok(url()->full(),"?")."/"); ?>' + $(this).data('obj'));
            $('#deleteModal').modal('show');
        });
    })();
</script>
