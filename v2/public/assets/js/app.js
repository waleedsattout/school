class App {
    #alerContainer;
    baseUrl;
    #modal;
    #contPlaceHolder;
    toasts = new Array();
    constructor(url = "http://localhost") {
        this.baseUrl = url;
        this.#alerContainer = document.createElement("div");
        this.#alerContainer.classList = "toast-container position-fixed top-0 end-0 p-3";
        this.#contPlaceHolder = `<div class="placeHolder"><div class="post"><div class="line"></div><div class="line"></div><div class="line"></div></div></div>`;
        this.waiting(document.body);
        window.students = [];
    }
    async seedStd() {
        if (document.getElementById('editData')) {
            removeAllChildNodes(document.getElementById('editData'))
            await this.ajax(
                "get", this.baseUrl + "/get/students?JWT=" + window.localStorage['jwt'],
                (e) => {
                    window.students = JSON.parse(e);
                    for (let i = 0; i < students.length; i++) {
                        setTimeout(() => {
                            const e = students[i];
                            fillM3Options(e.id, `${e.firstName} ${e.fatherName} ${e.lastName}`, `${e.firstName} ${e.fatherName} ${e.lastName}`, 'editData')
                            if (i == students.length - 1) if (document.getElementById('loader')) document.getElementById('loader').remove()
                        }, i * 25);
                    }
                })
        } else {
            // this.fireAlert('error', 'حدث خطا')
            return;
        }
        // this.fireAlert('success', 'تم تحديث قائمة الطالبات')
    }

    /**
     * add waiting style to an element until it loads.
     * @param {Node} ele the element you want to place holder it.
     */
    waiting(ele) {
        let loader = document.createElement('div');
        loader.id = 'loader';
        /*
        0 -> body 
        1 -> cont, for placeholder 
        2 -> default 
        */
        let state = (ele.tagName == 'BODY') ? 0 : (ele.id == 'cont') ? 1 : 2;

        switch (state) {
            case 0:
                let load = document.createElement('md-circular-progress')
                load.setAttribute('indeterminate', '')
                loader.appendChild(load)
                ele.appendChild(loader);
                document.getElementById("hide").remove();
                window.addEventListener("load", () => {
                    loader.remove();
                    /* NOTE: old code
                    let menu = document.querySelector('menu.menu');
                    let start = 0, end = 0;
                    var down = (e) => {
                    start = e.clientY || e.changedTouches[0].pageY;
                    if (start - e.target.getBoundingClientRect().top > 20) return;
                    if (e.target.tagName == "INPUT") return;
                    document.body.classList.add('noreload');
                    const up = (event) => {
                    end = event.clientY || event.changedTouches[0].pageY;
                    let delta = start - end;
                    if (delta > 0) menu.style.height = '410px'
                    else if (delta == 0);
                    else menu.style.height = '64px';
                    document.onmouseup = document.onmousemove = document.ontouchend = document.ontouchmove = {};
                    document.body.classList.remove('noreload');
                    start = end;
                    };
                    const move = (event) => {
                    menu.style.height = window.innerHeight - (event.clientY || event.changedTouches[0].pageY) + 'px'
                    };
                    document.onmouseup = document.ontouchend = up;
                    document.onmousemove = document.ontouchmove = move;
                    }
                    menu.ontouchstart = down;
                    menu.onmousedown = down
                     */
                });
                break;
            case 1:
                ele.style.position = 'relative';
                loader = this.#contPlaceHolder;
                this.appendChild(ele, loader, 'afterbegin');
                ele.addEventListener("load", () => {
                    loader.remove();
                    ele.style.position = '';
                })
                break;

            default:
                //fixMe:
                ele.addEventListener("load", () => { loader.remove() })
                break;
        }
    }

    /**
     * convert string of an html to dom.
     * @param {string} htmlString an html string you want to convert
     * @return a dom element you can append
     */
    toDom(htmlString) {
        return new XMLSerializer().serializeToString(new DOMParser().parseFromString(htmlString, "text/html"));
    }

    /**
     * append element of string of an html to elementToAppendTo.
     * @param {string} htmlString an html string you want to convert
     * @param {string} elementToAppendTo 
     * @param {string} position beforebegin | afterbegin | beforeend | afterend  
     */
    appendChild(elementToAppendTo, htmlString, position = 'beforeend') {
        elementToAppendTo.insertAdjacentHTML(position, this.toDom(htmlString))
    }
    /**
     * @param {string} url url to get its content
     * @param {string} type large | small
     * @param {string} title title of the modal
     */
    showModal(url = '', title = 'title', callback, content = '', type = 'normal', id = 'modalBody') {
        if (document.getElementById('dialog'))
            document.getElementById('dialog').remove()
        if (type == 'normal') {
            this.#modal = `
        <md-dialog id="dialog">
            <span slot="headline">
                <md-icon-button onclick="document.getElementById('dialog').remove()" form="form" value="close" aria-label="Close dialog"><md-icon>✗</md-icon></md-icon-button>
                <span class="headline">${title}</span>
            </span>
            <div slot="content" id="modalBody">${content}</div>
            <div slot="actions">
                <md-text-button form="${id}" value="reset" type="reset">محو الكل</md-text-button>
                <div style="flex: 1"></div>
                <md-text-button form="${id}" onclick="document.getElementById('dialog').remove()" value="cancel">إلغاء الأمر</md-text-button>
                <md-text-button form="${id}" onclick="${callback}" id="subm" value="save">إرسال</md-text-button>
            </div>
        </md-dialog>`;
        } else if (type == 'confirm')
            this.#modal = `
            <md-dialog id="dialog">
                <div slot="headline">${title}</div>
                <div id="form" slot="content" method="post" action="javascript:void(0);">${content}</div>
                <div slot="actions">
                    <md-text-button form="form" id="subm" onclick="${callback}" >موافق</md-text-button>
                    <md-filled-tonal-button onclick="document.getElementById('dialog').remove()" form="form" value="cancel"
                        autofocus>إلغاء الأمر</md-filled-tonal-button>
                </div>
            </md-dialog>`;
        this.appendChild(document.body, this.#modal);
        if (url != '') {
            this.ajax('get', url, (e) => { document.getElementById('modalBody').innerHTML = e; })
        }
        document.getElementById('dialog').show()
    }

    /**
     * sends a request to the specified url from a form. this will change the window location.
     * @param {string} path the path to send the post request to
     * @param {object} params the parameters to add to the url
     * @param {string} [method=post] the method to use on the form
    */
    post(path, params, method = 'post') {
        const form = document.createElement('form');
        form.method = method;
        form.action = path;

        for (const key in params) {
            if (params.hasOwnProperty(key)) {
                const hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = key;
                hiddenField.value = params[key];

                form.appendChild(hiddenField);
            }
        }
        document.body.appendChild(form);
        form.submit();
    }

    /**
     * flash message using custom style and bootstrap.
     * @param {string} type set it to success to flash message with primary color.
     * @param {string} message the message you want to blow.
     */
    fireAlert(type = "success", message = "message") {
        if (!document.querySelector('.toast-container')) {
            document.body.appendChild(this.#alerContainer);
        }
        let container = document.querySelector('.toast-container');
        let color = type == "success" ? 'primary' : 'error';
        let tempId = Date.now();
        container.innerHTML += `
        <div id="toast-${tempId}" class="toast d-flex fade toastContainer hide" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
            <style> #toast-${tempId} { --bg:var(--md-sys-color-${color}); opacity:1} </style>
            <button type="button" class="btn-close" onclick="app.reset('toast', 0, this.id)" data-bs-dismiss="toast" aria-label="Close"></button>
            <div class="toastMessageContainer">${message}</div>
        </div>
        `;
        // var toast = new bootstrap.Toast(document.getElementById('toast-' + tempId));
        // toast.show();
        this.toasts.push(tempId);
        this.reset("toast", 5, tempId);
        return tempId;
    }

    /**
     * send ajax 
     * @param {string} method POST || GET
     * @param {string} url the distination you want to achive.
     * @param {function} callback function to deal with the callback text.
     */
    async ajax(method = "post", url, callback) {
        if (!url) {
            this.fireAlert('error', 'يرجى التحقق من الرابط')
            throw new Error("invalid or empty Url!");
        }
        fetch(url, { 'method': method }).then((response) => {
            if (!response.ok) {
                this.fireAlert('error', 'حدث شيء خاطئ')
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            //         let id = this.fireAlert('success', 'جار التحميل')
            //          this.reset("toast", 1, id);
            return response.text();
        })
            .then((response) => {
                callback(response);
            });
    }

    /**
     * delete fasel 2 from Certificate.
     */
    deleteFasel2() {
        document.querySelectorAll(".r3 *").forEach((i) => (i.innerText = " "));
        document.querySelectorAll(".headr11").forEach((i) => (i.innerText = " "));
        document.querySelectorAll(".headr12").forEach((i) => (i.innerText = " "));
        document.querySelectorAll(".headr13").forEach((i) => (i.innerText = " "));
        document.querySelectorAll(".r4 *").forEach((i) => (i.innerText = " "));
        document.querySelectorAll(".numblank2").forEach((i) => (i.innerText = " "));
        document.querySelectorAll(".wrblank2").forEach((i) => (i.innerText = " "));
    }

    reset(ele = 'toast', time, id = '', bool = false) {
        if (ele == "toast") {
            if (bool) {
                setTimeout(() => {
                    this.toasts.forEach((e) => {
                        document.getElementById('toast-' + e).classList.add('opacity-0');
                        setTimeout(() => {
                            document.getElementById('toast-' + e).remove();
                        }, 150);
                    });
                }, 1000);
                this.toasts = [];
            } else {
                setTimeout(() => {
                    if (id != '') {
                        let index = this.toasts.indexOf(id);
                        document.getElementById('toast-' + id).classList.add('opacity-0');
                        setTimeout(() => {
                            let toas = document.getElementById('toast-' + id)
                            if (toas)
                                toas.remove();
                        }, 150);
                        this.toasts[index] = '';
                    } else {
                        document.getElementById("toast-" + this.toasts[0]).remove();
                        this.toasts[0] = '';
                    }
                    this.toasts = this.toasts.filter(e => e === 0 ? true : e);
                }, time * 1000);
            }
        } else if (ele == "modal") {
            document.getElementById('modal').remove();
        }
    }

    bootstrapValidation() {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    }

    /**
     * 
     */
    change_class(cls) {
        this.ajax('get', app.baseUrl + '/classes/change_class/' + cls, async (e) => {
            await app.ajax(
                "get", app.baseUrl + "/get/classes?JWT=" + window.localStorage['jwt'],
                (e) => { window.classes = JSON.parse(e); this.seed("classes", JSON.parse(e)); })
            await app.ajax(
                "get", app.baseUrl + "/get/subjects?JWT=" + window.localStorage['jwt'],
                (e) => { window.subjects = JSON.parse(e); this.seed("subjects", JSON.parse(e)); })
            await app.ajax(
                "get", app.baseUrl + "/get/students?JWT=" + window.localStorage['jwt'],
                (e) => { window.students = JSON.parse(e); this.seed("students", JSON.parse(e)); app.seedStd() })

            let msg = document.querySelector(`[for="${cls}"]`).innerText;
            let id = this.fireAlert('success', msg);
            this.reset('toast', 5, id);
        })
        /* NOTE: old code
            this.ajax('get', app.baseUrl + '/classes/change_class/' + this.wlpGetId('class'), async (e) => {
            let msg = '';
            switch (e) {
                case 'c10': msg = 'تم تغيير الصف للصف العاشر.'; break;
                case 'c11': msg = 'تم تغيير الصف للصف الحادي عشر.'; break;
                case 'c12': msg = 'تم تغيير الصف للصف الثاني عشر.'; break;
                default:
                    msg = 'حدثت مشكلة أثناء تغيير الصف.';
            }
            let id = this.fireAlert('success', msg);
            this.reset('toast', 5, id);
            await app.ajax(
                "get", app.baseUrl + "/get/classes?JWT=" + window.localStorage['jwt'],
                (e) => { window.classes = JSON.parse(e); this.seed("classes", JSON.parse(e)); })
            await app.ajax(
                "get", app.baseUrl + "/get/subjects?JWT=" + window.localStorage['jwt'],
                (e) => { window.subjects = JSON.parse(e); this.seed("subjects", JSON.parse(e)); })
            await app.ajax(
                "get", app.baseUrl + "/get/students?JWT=" + window.localStorage['jwt'],
                (e) => { window.students = JSON.parse(e); this.seed("students", JSON.parse(e)); })

            })
        */


        /*          
        this.ajax('GET', `${app.baseUrl}/modals/manage_student/${id}`, (e) => {
            document.getElementById('cont').innerHTML = e;
            if (window.innerWidth < 667) {
                document.querySelector('.mainMarks').parentElement.style = 'overflow-x:auto';
                document.querySelector('.mainMarks').style.width = '850px';
            }
        });
*/

        //need to reset students and class sections and so.
        //!error: not finished
        //todo:
    }

    /**
     * get id for value of input.
     * @param {string} Id of an element to reload its data.
     * @returns 
     */
    wlpGetId(Id) {
        return document.querySelector(`[value='${document.getElementById(Id).value}'`).id;
    }

    seed(id, data) {
        let target = document.getElementById(id);
        let options = '';
        let alert = '';
        data.forEach((e) => {
            if (id == 'students') { options += `<option id="${e.id}" value="${e.firstName} ${e.lastName}"></option>`; alert = 'الطلاب' }
            else if (id == 'subjects') { options += `<option id="${e.id}" value="${e.arabic}"></option>`; alert = 'المواد' }
            else if (id == 'classes') { options += `<option id="${e.name}" value="${e.arabic}"></option>`; alert = 'الصفوف' }
            else { this.fireAlert('error', 'حدث شيء خاطئ، يجب أن لا يكون الحقل فارغاً.'); return; }
        })
        target.innerHTML = options;
        let fid = this.fireAlert('success', 'تم تحديث قائمة ' + alert);
        this.reset("toast", 3, fid);
    }
}