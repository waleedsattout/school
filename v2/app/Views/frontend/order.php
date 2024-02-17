<div class="drag-and-drop">
    <div>
        <h3 class="title">From</h3>
        <div class="drop-area">
            <div id="item-2" class="item">
                Your Item #2
            </div>
            <div id="item-3" class="item">
                Your Item #3
            </div>
            <div id="item-4" class="item">
                Your Item #4
            </div>
            <div id="item-5" class="item">
                Your Item #5
            </div>
            <div id="item-6" class="item">
                Your Item #6
            </div>
        </div>
    </div>
    <div class="drag-and-drop__divider">⇄</div>
    <div>
        <h3 class="title">To</h3>
        <div class="drop-area items">
            <div id="item-1" class="item">
                Your Item #1
            </div>
        </div>
    </div>
</div>
<script>
    let lis = document.querySelectorAll('.item');
    for (let li of lis) {
        li.setAttribute('draggable', 'true');
        li.ondragstart = (ev) => {
            ev.dataTransfer.setData("id", ev.target.id);
        }
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
        margin: auto;
        direction: rtl;
    }
    
    .drag-and-drop>div {
        border-radius: 0.75rem;
    }

    .drag-and-drop__divider {
        padding: 0.75rem;
        font-size: 1.25rem;
        align-self: center;
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
        border-top: 0;
        line-height: 1;
        cursor: move;
        transition: all 0.25s;
        background-color: #fff;
    }

    .item:hover {
        background-color: #eee;
    }
</style>