<div class="d-none" id="result"></div>

<script>
    function del() {
        window.location = '<?php echo base_url($locale . '/classes/delete_class/') ?>' + '/' + getClassId();
    }

    let getClassId = () => document.querySelector(`[value="${cls_id.value}"]`).id

    function sendData() {
        app.showModal(`${app.baseUrl}/<?php echo $locale ?>/modals/edit_class/${getClassId()}`, "<?php echo lang('General.edit') . ' ' . flipWords(lang('Classes.Class'), lang('General.data')) ?>")
    }
</script>

<style>
    #cont {
        place-content: center;
    }
</style>

<md-list class="content" style="min-width: 20rem;">
    <md-list-item>
        <md-filled-button trailing-icon onclick="app.showModal(app.baseUrl+'/<?php echo $locale ?>/modals/add_class', 'إضافة صف','','', 'normal', 'addCls')">
            <?php echo lang('General.add') . ' ' . lang('Classes.class') ?>
        </md-filled-button>
    </md-list-item>
    <md-divider></md-divider>
    <md-list-item>
        <div class="d-flex align-items-center flex-column gap-2 pt-2">
            <input required name="cls_id" id="cls_id" list="classes" class="md-input" autocomplete="off">
            <md-outlined-button trailing-icon onclick="sendData()">
                <?php echo lang('General.edit') . ' ' . flipWords(lang('Classes.Class'), lang('General.data')) ?> </md-outlined-button>
        </div>
    </md-list-item>
</md-list>