function fillM3Options(value = 0, displayText = "text", textContent = "display", id) {
    sdf = document.getElementById(id);
    options = new MdSelectOption();
    options.value = value;
    options.displayText = displayText;
    options.textContent = textContent;
    sdf.appendChild(options)
}

function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

var app = new App()

window.onload = () => {
    app.seedStd()
}