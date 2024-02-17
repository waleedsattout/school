<div style="direction:rtl;text-align:right">
    <form id="ad_std" class="needs-validation" action="<?php echo base_url($locale . '/students/add_student') ?>" method="post" novalidate="">
        <div class="contact-row">
            <md-filled-text-field autofocus name="firstName" required label="<?php echo lang('General.firstName') ?>"></md-filled-text-field>
            <md-filled-text-field name="lastName" label="<?php echo lang('General.lastName') ?>" required></md-filled-text-field>
        </div>
        <div class="contact-row">
            <md-filled-text-field name="fatherName" required label="<?php echo lang('General.fatherName') ?>"></md-filled-text-field>
            <md-filled-text-field name="motherName" required label="<?php echo lang('General.motherName') ?>"></md-filled-text-field>
        </div>
        <div class="contact-row">
            <md-filled-text-field name="dob" required type="number" pattern="^[a-zA-Z]+$" label="<?php echo lang('General.dob') ?>"></md-filled-text-field>
        </div>
        <?php include __DIR__ . '/../parts/sections.php'; ?>
    </form>
</div>