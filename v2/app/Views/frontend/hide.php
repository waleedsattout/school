<style>
    div[method] {
        margin: 3rem auto;
        padding: 2rem 3rem;
        width: fit-content;
        background: var(--md-sys-color-surface);
        border-radius: 3rem;
    }

    label {
        display: flex;
        align-items: center;
    }

    body {
        direction: rtl;
        text-align: right;
        background-color: var(--md-sys-color-surface-container);
    }

    md-filled-button {
        margin: auto;
        display: block;
        width: fit-content;
    }
</style>


<div method=post>
    <md-list id='list'>
        <md-list-item>
            <label onclick="sAll()">
                <md-checkbox id=all touch-target='wrapper'></md-checkbox>
                <?php echo lang('General.selectAll')?></label>
        </md-list-item>
        <md-divider></md-divider>
    </md-list>
    <md-filled-button onclick="send()"><?php echo lang('General.send')?></md-filled-button>
</div>
<script>
    function sAll() {
        const selectAll = document.getElementById('all');
        const options = document.querySelectorAll('[option]');
        selectAll.addEventListener('change', function() {
            for (let i = 0; i < options.length; i++) {
                options[i].checked = this.checked;
                options[i].addEventListener('change', function() {
                    let checkedCount = 0;
                    for (let j = 0; j < options.length; j++) {
                        if (options[j].checked) {
                            checkedCount++;
                        }
                    }
                    if (checkedCount === options.length) {
                        selectAll.checked = true;
                        selectAll.indeterminate = false;
                    } else if (checkedCount === 0) {
                        selectAll.checked = false;
                        selectAll.indeterminate = false;
                    } else {
                        selectAll.checked = false;
                        selectAll.indeterminate = true;
                    }
                });
            }
        });
    }

    var data = (<?php echo json_encode($stds) ?>);
    async function insertStudents() {
        for await (let student of data) {
            let mdcheckbox = document.createElement('md-checkbox')
            mdcheckbox.setAttribute('option', '')
            mdcheckbox.setAttribute('name', student.id)
            if (student.hide == 1)
                mdcheckbox.setAttribute('checked', '')
            mdcheckbox.setAttribute('touch-target', 'wrapper')

            let list = document.createElement('md-list-item')
            let label = document.createElement('label')
            list.appendChild(label)
            label.appendChild(mdcheckbox)
            label.innerHTML += student.firstName + ' ' + student.fatherName + ' ' + student.lastName
            document.getElementById('list').appendChild(list)
        }
    }
    insertStudents()

    function send() {
        let stds = document.querySelectorAll('md-checkbox')
        let selectAllBox = true;
        let data = {}
        for (let i of stds) {
            if (selectAllBox) {
                selectAllBox = false
                continue;
            }
            let id = i.getAttribute('name');
            data[id] = +i.checked
        }
        app.post(`${app.baseUrl}/students/hideStudent`, {
            data: JSON.stringify(data),
        });
    }
</script>