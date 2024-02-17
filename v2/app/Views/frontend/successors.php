<div>
    <style>
        #cont {
            place-content: center;
            height: 37rem;
        }

        input {
            padding: 8px 16px;
            width: 100%;
            height: 3.5rem;
            border: 0;
            border-bottom: 1px solid var(--md-sys-color-on-surface);
            margin-left: 1rem;
            background: var(--md-sys-color-background);
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        input:focus {
            outline: none;
            transition: all 0.3s;
            background: var(--md-sys-color-surface-1);
        }

        .std {
            display: flex;
            justify-content: space-between;
            gap: 4px;
            height: fit-content;
        }

        .std,
        .students {
            width: calc(100% - 6rem);
            margin: 3rem;
        }

        .students {
            background-color: var(--md-sys-color-secondary-container);
            border-radius: 1rem;
            min-height: 7.5rem;
            padding: 16px;
            color: var(--md-sys-color-on-secondary-container);

            grid-auto-flow: column;
            grid-template-rows: repeat(5, 1fr);
            display: grid;
            overflow: auto;
        }

        .title {
            font-size: var(--md-sys-typescale-title-large-size);
        }

        p:not(.title) {
            font-size: var(--md-sys-typescale-title-medium-size);
        }

        .stds {
            margin: .5rem .7rem;
            display: grid;
            place-content: flex-start;
            white-space: nowrap;
        }
    </style>
    <div class="std">
        <input list="students" id="input" />
        <button class="btn btn-primary btn-lg" id="button">إضافة</button>
    </div>
    <p class="title"><?php echo lang('Students.failedStudentsNames') ?>:</p>
    <div class="students"></div>
    <button class="btn btn-primary btn-lg" id="send"><?php echo lang('General.send') ?></button>
</div>
<script>
    var input = document.getElementById("input");
    var button = document.getElementById("button");
    var list = document.querySelector('.students')
    var vals = data = []
    var datalist = document.getElementById("students");
    input.addEventListener("keypress", event => event.key === "Enter" ? insertParagraph() : '');

    function insertParagraph() {
        var datalist = document.getElementById("students");
        if (input.value) {
            let option = datalist.querySelector("[value='" + input.value + "']");
            if (option) {
                if (data.filter(e => e.id == option.id).length > 0) {
                    vals.push(app.fireAlert("error", "<?php echo lang('Students.youHaveEnteredThisNameBefore') ?>"))
                } else {
                    let paragraph = document.createElement("p");
                    paragraph.textContent = option.value;
                    paragraph.classList.add("stds");
                    paragraph.setAttribute("std", `${option.id}`)
                    paragraph.setAttribute("onclick", `removeStd(${option.id})`)
                    list.appendChild(paragraph);
                    data.push({
                        id: option.id,
                        value: option.value
                    })
                    datalist.removeChild(option);
                }
            } else {
                vals.push(app.fireAlert("error", "<?php echo lang('Students.thisNameDoesNotExist') ?>"))
            }
        } else {
            vals.push(app.fireAlert("error", "<?php echo lang('Students.enterNameFirst')?>"))
        }
        input.value = '';
        if (vals.length > 0) {
            vals.forEach(e => {
                setTimeout(() => {
                    document.getElementById("toast-" + e)?.remove();
                    vals = removeValue(vals, e)
                }, 1500);
            })
        }
    }

    function removeStd(id) {
        let std = data.filter(e => +e.id === id)
        if (std.length > 0) {
            let name = std[0].value;
            let id = std[0].id;
            data = data.filter(e => +e.id !== id);
            document.querySelector(`[std="${id}"]`).remove()
            app.fireAlert('success', '<?php echo lang('Students.studentHasBeenRemoved')?>' + name)
        }
    }

    function removeValue(arr, val) {
        let index = arr.findIndex(value => value === val);
        if (index !== -1) {
            let newArr = [...arr];
            newArr.splice(index, 1);
            return newArr;
        }
        return arr;
    }

    document.getElementById('send').onclick = e => {
        if (data.length > 0)
            app.post('/promote_students', {
                data: JSON.stringify(data)
            })
    }

    button.onclick = insertParagraph;
</script>