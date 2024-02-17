<div class="drag-and-drop">
    <div style="display: flex; justify-content:space-around">
        <?php
        $i = 0;
        foreach ($classes as $class) : ?>
            <div id="item-<?php echo $i ?>" cls="<?php echo $class->name ?>" class="item">
                <?php
                if ($locale == 'en')
                    echo $class->english;
                else
                    echo $class->arabic
                ?>
            </div>
        <?php
            $i++;
        endforeach; ?>
    </div>
    <div style="display: flex;justify-content: space-around;">
        <?php
        $i = 0;
        foreach ($classes as $class) : ?>
            <div id="order-<?php echo $i ?>">
            </div>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path opacity="0.5" d="M20 12.75C20.4142 12.75 20.75 12.4142 20.75 12C20.75 11.5858 20.4142 11.25 20 11.25V12.75ZM20 11.25H4V12.75H20V11.25Z" fill="#1C274C"></path>
                    <path d="M10 6L4 12L10 18" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        <?php
            $i++;
        endforeach; ?>
    </div>
</div>
<script>
    let lis = document.querySelectorAll('.item');
    for (let li of lis) {
        li.setAttribute('draggable', 'true');
        li.ondragstart = (ev) => ev.dataTransfer.setData("id", ev.target.id);
    }

    let containers = document.querySelectorAll('.drop-area')
    for (let container of containers) {
        container.ondragover = e => {
            if (e.target.classList.contains('drop-area'))
                e.target.classList.add('surface-3')
            e.preventDefault()
        };
        container.ondragleave = e => {
            if (e.target.classList.contains('drop-area'))
                e.target.classList.remove('surface-3')
            e.preventDefault()
        };
        container.ondrop = ev => {
            if (ev.target.classList.contains('drop-area')) {
                ev.target.appendChild(document.getElementById(ev.dataTransfer.getData("id")));
                ev.target.classList.remove('surface-3')
            }
        }
    }
</script>

<style>
    .drop-area {
        background: var(--md-sys-color-surface-container);
        height: 75%;
        transition: all 0.25s;
        border: 1px solid #ccc;
        padding-bottom: 40px;
        border-top: 1px solid #ccc;

    }

    .surface-3 {
        background-color: var(--md-sys-color-surface-3);
    }

    .drag-and-drop {
        display: flex;
        padding: 3.5rem;
        height: 100%;
        flex-direction: column;
        margin: auto;
        direction: rtl;
        width: 100%;
    }

    .drag-and-drop>div {
        border-radius: 0.75rem;
        width: 100%;
        margin: auto;
        height: 25%;
    }

    .title {
        padding: 1rem 1.25rem;
        font-size: 1.25rem;
        background: #ddd;
        margin: 0;
    }

    .item {
        padding: 1rem 1.25rem;
        border: 1px solid #ccc;
        line-height: 1;
        cursor: move;
        transition: all 0.25s;
        background-color: #fff;
        height: fit-content;
    }

    .item:hover {
        background-color: #eee;
    }
</style>