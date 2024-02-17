<hr>
<div style="direction:rtl;text-align:right">
    <div class="needs-validation" novalidate="">
        <div class="row g-3">
            <div class="d-flex justify-content-around">
                <div class="col-2 text-center">
                    <label class="form-label"> id </label>
                </div>
                <div class="col-2 text-center">
                    <label class="form-label"><?php echo lang('General.code') ?></label>
                </div>
                <div class="col-2 text-center">
                    <label class="form-label"><?php echo lang('General.name')?></label>
                </div>
            </div>
            <?php
            foreach ($classes as $class) : ?>
                <div class="d-flex justify-content-around">
                    <div class="col-2 text-center">
                        <p>
                            <?php echo $class->class_id ?>
                        </p>
                    </div>
                    <div class="col-2 text-center">
                        <p>
                            <?php echo $class->name ?>
                        </p>
                    </div>
                    <div class="col-2 text-center">
                        <p>
                            <?php echo $class->arabic ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>