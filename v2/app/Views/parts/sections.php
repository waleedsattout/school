<h5 class="m-0 mt-1"><?php echo lang('General.section')?></h5>
<div role="radiogroup">
    <?php foreach ($sections as $key => $val): ?>
        <div class="radio-label">
            <md-radio aria-label="<?php echo $val ?>" id="sec<?php echo $val ?>" name="section" value="<?php echo $key ?>"
                touch-target=" wrapper">
            </md-radio>
            <label for="sec<?php echo $val ?>">
                <?php echo $val ?>
            </label>
        </div>
    <?php endforeach; ?>
</div>