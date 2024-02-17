<div style="direction:rtl;text-align:right">
    <form id="addCls" class="needs-validation" action="<?php echo $type == '0' ? base_url($locale. '/classes/add_class') : base_url($locale. '/classes/edit_class') ?>" method="post">
        <div class="contact-row">
            <md-filled-text-field name="id" id="id" required value="<?php echo $data['id'] ?>" label="id" autofocus></md-filled-text-field>
            <md-filled-text-field name="name" id="name" value="<?php echo $data['name'] ?>" required label="<?php echo lang('General.code') ?>"></md-filled-text-field>
        </div>
        <div class="contact-row">
            <md-filled-text-field name="arabic" id="arabic" value="<?php echo $data['arabic'] ?>" required label="<?php echo lang('General.className')?>"></md-filled-text-field>
            <md-filled-text-field name="sections" id="sections" value="<?php echo $data['sections'] ?>" required label="<?php echo lang('General.numberOfSections')?>"></md-filled-text-field>
        </div>
        <?php if ($type == '0') : ?>
            <input type="hidden" name="type" value="add">
        <?php else : ?>
            <input type="hidden" name="type" value="edit">
            <input class="d-none" name="id" value="<?php echo $data['id'] ?>">
            <md-filled-button type=button onclick="window.location =`${app.baseUrl}/classes/delete_class/<?php echo $data['id'] ?>`"><?php echo lang('General.delete') . ' ' . lang('Classes.Class')?></md-filled-button>
            <style>
                #addCls md-filled-button {
                    --md-filled-button-container-color: var(--md-sys-color-error);
                }
            </style>
        <?php endif; ?>
    </form>
</div>