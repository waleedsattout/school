<form onsubmit="return false;" class="content needs-validation">
    <table>
        <thead style="position: relative;">
            <tr>
                <th><?php echo lang('Students.studentName') ?></th>
                <th><?php echo lang('General.firstSem') ?></th>
                <th><?php echo lang('General.secondSem') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            foreach ($data as $key => $data1) :
                $b1 = explode('-', $data1["behav"])[0];
                $b2 = explode('-', $data1["behav"])[1];
            ?>
                <tr id="r-<?php echo $i ?>">
                    <td std="<?php echo $key ?>">
                        <?php echo $data1["name"] ?>
                    </td>
                    <td>
                        <input type="number" step="1" min="0" max="200" class="form-control" name="test1" id="test1" value="<?php echo $b1 ?>" required="">
                    </td>
                    <td>
                        <input type="number" step="1" min="0" max="200" class="form-control" name="test2" id="test2" value="<?php echo $b2 ?>" required="">
                    </td>
                </tr>
            <?php $i++;
            endforeach; ?>
        </tbody>
    </table>
    <button id="rows" rows="<?php echo count($data) ?>" class="btn btn-lg mt-4" onClick="collect_data()" style="display: block; background: var(--md-sys-color-secondary);color: var(--md-sys-color-on-secondary);margin: auto;"><?php echo lang('General.send') ?></button>
</form>
<style>
    thead tr {
        position: absolute;
        display: flex;
        left: 0;
        right: 0;
        top: -47px;
    }

    tr td:last-of-type,
    tr th:last-of-type {
        border-inline-end: 1px solid var(--md-sys-color-outline-variant);
    }

    th,
    td {
        padding: 8px 16px;
        line-height: 1.5;
        border-block-start: 1px solid var(--md-sys-color-outline-variant);
        border-inline-start: 1px solid var(--md-sys-color-outline-variant);
    }

    tr:last-of-type td:last-of-type {
        border-end-end-radius: 28px;
    }

    tr:last-of-type td:first-of-type {
        border-end-start-radius: 28px;
    }

    tr th:last-of-type {
        border-start-end-radius: 28px;
    }

    tr th:first-of-type {
        border-start-start-radius: 28px;
    }

    tr:last-of-type td,
    tr:last-of-type th {
        border-block-end: 1px solid var(--md-sys-color-outline-variant);
    }

    th {
        background-color: var(--md-sys-color-surface-container);
        text-shadow: 0 1px 1px var(--md-sys-color-surface-container-lowest);
        color: var(--md-sys-color-on-surface);
        font-size: 1.25em;
        text-wrap: nowrap;
    }

    .needs-validation {
        padding: 2.5rem;
        margin: 2.5rem auto;
        padding-top: 90px;
        text-wrap: nowrap;
        overflow: auto;
        width: fit-content;
    }

    table {
        background-color: var(--md-sys-color-background);
    }

    th,
    input {
        width: fit-content;
        min-width: 125px;
    }
</style>
<script>
    function collect_data() {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    form.classList.add('was-validated')
                    var rows = +document.getElementById('rows').getAttribute('rows');
                    var stds = document.querySelectorAll(`[std]`);
                    var arr = {};
                    for (var i = 0; i < rows; i++) {
                        var row = document.getElementById(`r-${i}`);
                        var fin = `${row.children[1].children[0].value}-${row.children[2].children[0].value}`;
                        arr[stds[i].getAttribute('std')] = fin;
                    }
                    app.post(`${app.baseUrl}/public/students/edit_behav/`, {
                        data: JSON.stringify(arr),
                    });
                }
            }, false)
        })
    }
    window.addEventListener('load', () => {
        let counter = 0;
        let th = document.querySelectorAll('.content th')
        for (let td of document.querySelector('.content  tbody tr').children) {
            th[counter].style.width = td.clientWidth + counter++ + 'px'
        }
    })
</script>