<md-list class="content" style="min-width: 20rem;">
    <md-list-item>
        <md-filled-button trailing-icon onClick="app.showModal('<?php echo base_url($locale . '/modals/add_student', env('protocol')) ?>', '<?php echo lang('General.add') . ' ' . lang('Students.student') ?>', 'addstdcall()','', 'normal', 'ad_std')">
            <?php echo lang('General.add') . ' ' . lang('Students.student') ?>
        </md-filled-button>
    </md-list-item>
    <md-divider></md-divider>
    <md-list-item>
        <div class="d-flex align-items-center flex-column gap-2 pt-2">
            <md-outlined-select id="editData" name="std_id" list="students" type="text" autocomplete="true" label="<?php echo lang('Students.studentName') ?>">
            </md-outlined-select>
            <md-outlined-button trailing-icon onclick="editStd()">
                <?php echo lang('General.edit') . ' ' . flipWords(lang('Students.Student'), lang('General.data')) ?>
            </md-outlined-button>
        </div>
    </md-list-item>
</md-list>

<script>
    function addstdcall() {
        document.getElementById('ad_std').submit()
        document.getElementById('modalBody').remove()
    }

    function editStd(bool = true) {
        if (bool) {
            id = document.getElementById('editData').value;
            app.ajax('get',
                `<?php echo base_url($locale . '/modals/edit_student', env('protocol')) ?>/${id}`,
                (e) => {
                    app.waiting(document.getElementById('cont'));
                    document.getElementById('cont').innerHTML = e;
                    document.getElementById('cont').classList.add('add-std-container')
                    del = () => {
                        app.showModal('', '<?php echo lang('General.AreYouSure') ?>', (() => window.location = `<?php echo base_url($locale . '/students/delete_student/', env('protocol')) ?>/${id}`)(), '<?php echo lang('General.AreYouSure') ?>', 'confirm')
                    }
                    hideStd = () => app.ajax('get', `${app.baseUrl}/<?php echo $locale ?>/students/hideStudent/${id}`, () => location.reload())
                })
        } else {
            document.getElementById('form').method = 'post'
        }
    }

    document.getElementById('editData').menuPositioning = 'fixed'
</script>
<style>
    #cont {
        place-content: center;
    }
</style>