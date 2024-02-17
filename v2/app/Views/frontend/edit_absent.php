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
                        var fin = `${row.children[1].children[0].value},${row.children[2].children[0].value}-${row.children[3].children[0].value},${row.children[4].children[0].value}`;
                        arr[stds[i].getAttribute('std')] = fin;
                    }
                    app.post(`${app.baseUrl}/students/edit_absent/`, {
                        data: JSON.stringify(arr),
                    });
                }
            }, false)
        })
    }

    window.addEventListener('load', () => {
        let classes = ['std_name', 'f1m1', 'f1m2', 'f2m1', 'f2m2']
        let widthes = [211, 158, 158, 158, 158]
        let tds = document.querySelector('tr').children
        let i = 0;
        for (let e of classes) {
            document.querySelector('.' + e).style.width = tds[i].clientWidth + 1 + 'px';
            i++;
        }
        if (window.innerWidth < 768)
            document.querySelector('.table-top').style.width = "fit-content"
        else
            document.querySelector('.table-top').style.maxWidth = document.querySelector('tbody tr').clientWidth + 1 + 'px'
        document.querySelector('.std_name').style.width = document.querySelector('td').clientWidth + 'px'
    })
</script>
<form class="content needs-validation" novalidate="" onsubmit="return false;">
    <table classs="row g-3">
        <thead style="position: relative;">
            <div class="table-top" style="width: fit-content;">
                <div class="std_name"><?php echo lang('Students.studentName') ?></div>
                <div class="f1"><?php echo lang('General.firstSem') ?></div>
                <div class="f2"><?php echo lang('General.secondSem') ?></div>
                <div class="f1m1"><?php echo lang('General.excused') ?></div>
                <div class="f1m2"><?php echo lang('General.unexcused') ?></div>
                <div class="f2m1"><?php echo lang('General.excused') ?></div>
                <div class="f2m2"><?php echo lang('General.unexcused') ?></div>
            </div>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            foreach ($data as $key => $data1) :
                $b1 = explode(',', explode('-', $data1["absent"])[0])[0];
                $b2 = explode(',', explode('-', $data1["absent"])[0])[1];
                $b3 = explode(',', explode('-', $data1["absent"])[1])[0];
                $b4 = explode(',', explode('-', $data1["absent"])[1])[1];
            ?>
                <tr id="r-<?php echo $i ?>">
                    <td std="<?php echo $key ?>">
                        <?php echo $data1["name"] ?>
                    </td>
                    <td>
                        <input type="number" step="1" min="0" max="25" class="form-control" name="test1" value="<?php echo $b1 ?>" required>
                    </td>
                    <td>
                        <input type="number" step="1" min="0" max="16" class="form-control" name="test2" value="<?php echo $b2 ?>" required="">

                    </td>
                    <td>
                        <input type="number" step="1" min="0" max="25" class="form-control" name="test3" value="<?php echo $b3 ?>" required="">

                    </td>
                    <td>
                        <input type="number" step="1" min="0" max="16" class="form-control" name="test4" value="<?php echo $b4 ?>" required="">
                    </td>
                </tr>
            <?php $i++;
            endforeach; ?>
        </tbody>
    </table>

    <button id="rows" rows="<?php echo count($data) ?>" class="btn btn-primary btn-lg mt-4" onClick="collect_data()" style="display: block;margin: auto;"><?php echo lang('General.send') ?></button>
</form>
<style>
    .table-top {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "f2 f2 f1 f1 std_name"
            "f2m2 f2m1 f1m2 f1m1 std_name";
        direction: ltr;
    }

    .table-top * {
        border-inline-end: 1px solid var(--md-sys-color-outline-variant);
        padding: 0.95rem 16px;
        line-height: 1.5;
        border-block-start: 1px solid var(--md-sys-color-outline-variant);
        border-inline-start: 1px solid var(--md-sys-color-outline-variant);
        background-color: var(--md-sys-color-surface-container);
        text-shadow: 0 1px 1px var(--md-sys-color-surface-container-lowest);
        color: var(--md-sys-color-on-surface);
        font-size: 1.25em;
        text-wrap: nowrap;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
    }

    table {
        background: var(--md-sys-color-background);
    }

    .std_name {
        grid-area: std_name;
        border-start-end-radius: 1.25rem;
    }

    .f1 {
        grid-area: f1;
    }

    .f2 {
        grid-area: f2;
        border-start-start-radius: 1.25rem;
    }

    .f1m1 {
        grid-area: f1m1;
    }

    .f1m2 {
        grid-area: f1m2;
    }

    .f2m1 {
        grid-area: f2m1;
    }

    .f2m2 {
        grid-area: f2m2;
    }


    td {
        padding: 8px 16px;
        line-height: 1.5;
        border-block-start: 1px solid var(--md-sys-color-outline-variant);
        border-inline-start: 1px solid var(--md-sys-color-outline-variant);
        border-inline-end: 1px solid var(--md-sys-color-outline-variant);
    }

    .needs-validation {
        padding: 2.5rem;
        margin: 2.5rem auto;
        width: fit-content;
    }

    th,
    input {
        width: fit-content;
        min-width: 75px;
    }
</style>