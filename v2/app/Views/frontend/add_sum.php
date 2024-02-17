<div class="p-2 content m-auto" id='adsum' style="text-align:right;">
    <md-list style="min-width: 20rem;background: inherit;">
        <md-list-item role="presentation" md-list-item="" tabindex="-1">
            <label for="firstName" class="form-label"><?php echo lang('Subjects.Subject')?></label>
            <input id="editData" name="std_id" list="subjects" class="md-input" autocomplete="off">
            <md-divider></md-divider>
            <md-list-item role="presentation" md-list-item="" tabindex="-1">
                <div class="d-flex align-items-center flex-row gap-2 pt-2">
                    <div style="width: 50%;margin: 0 1.75rem 0.75rem;align-self: flex-start;">
                        <?php include __DIR__ . '/../parts/sections.php'; ?>
                    </div>
                    <div style="width: 50%;margin: 0 1.75rem 0.75rem;align-self: flex-start;">
                        <?php include __DIR__ . '/../parts/fasel.php'; ?>
                    </div>
                </div>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item role="presentation" md-list-item="" tabindex="-1">
                <md-outlined-button class="d-block m-auto" style="width: fit-content;" trailing-icon="" onClick="send()" role="presentation"><?php echo lang('Subjects.createMirror')?> </md-outlined-button>
            </md-list-item>
    </md-list>
</div>
<div class="d-none" id="result"></div>
<script>
    function send() {
        sec = function() {
            sections = document.querySelectorAll('[name="section"]');
            for (let i = 0; i < sections.length; i++)
                if (sections[i].checked)
                    return sections[i].value;
        }();
        sub = document.querySelector(`[value="${document.getElementById('editData').value}"]`).id;
        sem = document.getElementById('s1').checked ? '1' : (document.getElementById('s2').checked ? '2' : '');
        let locale = '<?php echo $locale ?>';
        console.log(`${app.baseUrl}/${locale}/modals/add_sum/${sub}/${sec}/${sem}`);
        app.ajax('get', `${app.baseUrl}/${locale}/modals/add_sum/${sub}/${sec}/${sem}`, (e) => {
            document.getElementById('result').innerHTML = e;
            document.getElementById('result').classList = 'd-block';
            app.bootstrapValidation()
            document.getElementById('adsum').style.marginTop = '3.5rem';
            document.getElementById('adsum').classList.remove('m-auto')
            document.getElementById('adsum').classList.add('mx-auto')
        })
    }

    function collect_data() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                event.preventDefault()
                if (!form.checkValidity()) {
                    event.stopPropagation()
                } else {
                    form.classList.add('was-validated')
                    var rows = +document.getElementById('rows').getAttribute('rows');
                    var stds = document.querySelectorAll(`[std]`);
                    var arr = {};
                    for (let i = 0; i < rows; i++) {
                        var row = document.getElementById(`r-${i}`);
                        var fin = `${row.children[1].children[0].value},${row.children[2].children[0].value},${row.children[3].children[0].value},${row.children[4].children[0].value}`;
                        arr[stds[i].getAttribute('std')] = fin;
                    }
                    // var sec = document.querySelector(`[value="${document.getElementById('section').value}"]`).value;
                    var sub = document.querySelector(`[value="${document.getElementById('editData').value}"]`).id;
                    var sem = document.getElementById('s1').checked ? '1' : (document.getElementById('s2').checked ? '2' : '');
                    app.post(`${app.baseUrl}/<?php echo $locale ?>/subjects/add_sum/`, {
                        data: JSON.stringify(arr),
                        sub: sub,
                        sem: sem,
                    });
                }
            }, false)
        })
    }
</script>