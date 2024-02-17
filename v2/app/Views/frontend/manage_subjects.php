<md-list class="content" style="min-width: 20rem;">
    <md-list-item>
        <md-filled-button trailing-icon onClick="app.showModal(app.baseUrl+'/<?php echo $locale ?>/modals/add_subject','<?php echo lang('General.add').' '. lang('Subjects.subject')?>', 'document.querySelector(`#addSub`).action = `<?php echo base_url($locale . '/subjects/add_subject') ?>`','','normal','addSub');">
            <?php echo lang('General.add').' '. lang('Subjects.subject')?>
        </md-filled-button>
    </md-list-item>
    <md-divider></md-divider>
    <md-list-item>
        <div class="d-flex align-items-center flex-column gap-2 pt-2">
            <input id="editSubject" class="md-input" name="std_id" list="subjects" type="text" autocomplete="true" placeholder="<?php echo lang('Subjects.subjectName')?>" />

            <md-outlined-button trailing-icon onClick="app.showModal(app.baseUrl+'/<?php echo $locale ?>/modals/edit_subject/' + document.querySelector(`[value='${document.getElementById('editSubject').value}'`).id , '<?php echo lang('General.edit') . ' ' . flipWords(lang('Subjects.Subject'), lang('General.data')) ?>', '','','normal','addSub');">
                <?php echo lang('General.edit') . ' ' . flipWords(lang('Subjects.Subject'), lang('General.data')) ?>
            </md-outlined-button>
        </div>
    </md-list-item>
</md-list>

<script>
    function del() {
        var id = document.querySelector(`[value='${document.getElementById('del').value}'`).id;
        window.location = '<?php echo base_url($locale . '/subjects/del_subject/') ?>' + '/' + id;
    }
</script>

<style>
    #cont {
        place-content: center;
    }
</style>