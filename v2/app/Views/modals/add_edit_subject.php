<div style="direction:rtl;text-align:right">
    <form id="addSub" class="needs-validation" action="<?php echo $type == 'add' ? base_url($locale . '/subjects/add_subject') : base_url($locale . '/subjects/edit_subject') ?>" method="post">
        <div class="contact-row">
            <md-filled-text-field id="name" value="<?php echo $data['name'] ?>" name="name" required label="<?php echo lang('General.englishSubjectName')?>" autofocus></md-filled-text-field>
            <md-filled-text-field id="arabic" value="<?php echo $data['arabic'] ?>" name="arabic" required label="<?php echo lang('General.arabicSubjectName')?>"></md-filled-text-field>
        </div>
        <div class="contact-row">
            <md-filled-text-field id="min" value="<?php echo $data['min'] ?>" name="min" required label="<?php echo lang('General.minMark')?>"></md-filled-text-field>
            <md-filled-text-field id="max" value="<?php echo $data['max'] ?>" name="max" required label="<?php echo lang('General.maxMark')?>"></md-filled-text-field>
        </div>
        <div class="contact-row">
            <md-filled-text-field id="tutor" value="<?php echo $data['tutor'] ?>" name="tutor" required type="text" label="<?php echo lang('General.tutor')?>"></md-filled-text-field>
        </div>
        <?php if ($type == 'add') : ?>
            <input type="hidden" name="type" value="add">
        <?php else : ?>
            <input type="hidden" name="type" value="edit">
            <input class="d-none" name="id" value="<?php echo $data['id'] ?>">
            <md-filled-button type=button onclick="window.location =`${app.baseUrl}/subjects/delete_subject/<?php echo $data['id'] ?>`"><?php echo lang('General.delete') . ' ' . lang('Subjects.Subject') ?></md-filled-button>
            <style>
                #addSub md-filled-button {
                    --md-filled-button-container-color: var(--md-sys-color-error);
                }
            </style>
        <?php endif; ?>
    </form>
</div>