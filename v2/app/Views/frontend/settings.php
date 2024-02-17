<style>
    @media screen and (max-width: 667px) {
        body {
            height: calc(100vh - 3.5rem);
        }
    }

    @media screen and (min-width: 668px) {
        body {
            height: 100vh;
        }
    }

    body {
        display: flex;
        flex-flow: column;
        gap: 0;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 1rem 0;
    }

    #cont {
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 2rem;
        width: calc(100% - 2rem);
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        height: -webkit-fill-available;
    }

    .form-container {
        padding: 2.5rem;
        border-radius: 1.25rem;
        background-color: var(--md-sys-color-secondary-container);
    }

    .form-group {
        margin-bottom: .75rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--md-sys-color-on-secondary-container);
        width: 50%;
        margin-top: auto;
        text-align: right;
    }

    .form-group input {
        max-width: 50%;
        height: 2.5rem;
        padding-top: 0;
        padding-bottom: 0;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--md-sys-color-on-secondary-container);
    }

    .btn-submit {
        background-color: var(--md-sys-color-secondary);
        color: var(--md-sys-color-on-secondary);
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .container {
        width: calc(100% - 2rem);
        margin: auto;
        border-radius: 2rem;
        border-top-right-radius: 0;
        border-top-left-radius: 0;
    }
</style>
<script>
    window.addEventListener('load', e => {
        document.getElementById('cont').classList = 'surface p-4';
    })

    function send() {
        let year = `${document.querySelectorAll('[name="year"]')[0].value}-${document.querySelectorAll('[name="year"]')[1].value}`;
        let actualAttendance1 = document.getElementById('actualAttendance1').value;
        let actualAttendance2 = document.getElementById('actualAttendance2').value;
        let showFasel2 = document.getElementById('showFasel2').selected === true ? 1 : 0;

        classesOrder = [];
        let classes = document.querySelectorAll('#classesOrder')
        classes.forEach(e => classesOrder.push(e.value));

        app.post(`${app.baseUrl}/settings`, {
            year: year,
            actualAttendance1: actualAttendance1,
            actualAttendance2: actualAttendance2,
            showFasel2: showFasel2,
            classesOrder: classesOrder.join('-')
        });
    }
</script>

<?php $classesOrder; ?>

<div class="form-container">
    <div class="form-group">
        <label for="name"><?php echo lang('General.year') ?>:</label>
        <input class="md-input w-20" type="text" id="year" name="year" value="<?php echo explode('-', $year)[0] ?>">
        <span style="width: 10%;">-</span>
        <input class="md-input w-20" type="text" id="year" name="year" value="<?php echo explode('-', $year)[1] ?>">
    </div>
    <div class="form-group">
        <label for="actualAttendance1"><?php echo lang('General.actualAttendance') ?>، <?php echo lang('General.firstSem') ?>:</label>
        <input class="md-input w-20 ms-auto " type="number" id="actualAttendance1" name="actualAttendance1" value="<?php echo $actualAttendance1 ?>">
    </div>
    <div class="form-group">
        <label for="actualAttendance2"><?php echo lang('General.actualAttendance') ?>، <?php echo lang('General.secondSem') ?>:</label>
        <input class="md-input w-20 ms-auto " type="number" id="actualAttendance2" name="actualAttendance2" value="<?php echo $actualAttendance2 ?>">
    </div>
    <div class="form-group">
        <label for="showFasel2"> <?php echo lang('General.showMarks') . ' ' . lang('General.secondSem') ?>:</label>
        <md-switch class="ms-auto" id="showFasel2" <?php echo $showFasel2 == 1 ? 'selected' : '' ?>></md-switch>
    </div>
    <div class="form-group">
        <label for="classesOrder"><?php echo flipWords(lang('Classes.classes'), lang('General.order')) ?>:</label>
        <?php foreach ($classesOrder as $class => $value) : ?>
            <input class="md-input w-10 ms-auto " type="text" id="classesOrder" name="classesOrder" value="<?php echo $class ?>">
        <?php endforeach; ?>
    </div>
    <button onclick="send()" class="btn-submit mt-3" style="margin-bottom: -1rem;"><?php echo lang('General.send') ?></button>
    <md-divider style="margin: 1.75rem 0 1rem;"></md-divider>
    <md-filled-button style="--md-filled-button-container-color: var(--md-sys-color-error);" onclick="location.href = app.baseUrl+'/migrate_students_data'">
        <?php echo lang('General.migrateDataFromOldToNewDatabase') ?>
    </md-filled-button>
</div>