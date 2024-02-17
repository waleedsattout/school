<?php
helper('convert_ar');
if ($status == '1') : ?>
    <div style="overflow: auto">
        <div style="width: fit-content; font-size: 11px">
            <div class="d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between">
                    <p>
                        مديرية التربية في محافظة ريف دمشق
                    </p>
                    <p>
                        محصلة الطالب للفصل
                        <?php echo ($sem == '1') ? 'الأول' : "الثاني"; ?>
                    </p>
                    <p>
                        للعام الدراسي
                    </p>
                    <p>
                        المادة:
                        <?php echo $sub ?>
                    </p>


                </div>
                <div class="d-flex justify-content-between">
                    <p>
                        ثانوية المهنية التجارية في ببيلا
                    </p>
                    <p>
                        الصف:
                        <?php echo $Class ?>
                    </p>
                    <p>
                        الاختصاص: التجاري

                    </p>
                    <p>
                        الشعبة:
                        <?php echo $sec 
                        ?>
                    </p>
                    <p>
                        الدرجة العظمى:
                        <?php echo to_ar_num($subData['max']) ?>
                    </p>
                </div>
            </div>

            <style>
                #cont p {
                    margin-bottom: 5px;
                }

                .failed {
                    background-color: #ffdad2 !important;
                    color: #3d0700;
                }

                th {
                    font-weight: 400;
                    white-space: nowrap;
                    padding: 1px !important;
                }

                .b-none {
                    border: none !important;
                }

                table,
                td,
                tr {
                    border-color: black;
                }

                .c1 {
                    width: 28px;
                }

                .c2 {
                    width: 150px;
                    white-space: nowrap;
                }

                .c3 {
                    width: 60px;
                }

                .c4 {
                    width: 68px;
                }

                .c5 {
                    width: 172px;
                }

                .c6 {
                    width: 196px
                }

                .no-wrap {
                    white-space: nowrap;
                }
            </style>
            <table class="table table-bordered table-responsive w-100 m-auto mb-0">
                <tbody>
                    <tr>
                        <th rowspan="3" class="c2"> الاسم والشهرة</th>
                        <th class="c4" rowspan="2">شفهي</th>
                        <th class="c4" rowspan="2">وظائف</th>
                        <th class="c4" rowspan="2">مذاكرة</th>
                        <th rowspan="2" class="c2">درجة أعمال الطالب</th>
                        <th class="c4 " rowspan="2">الامتحان</th>
                        <th rowspan="3" class="c4">المجموع</th>
                        <th colspan="2" class="c2">المحصلة النهائية رقماً/كتابة</th>
                    </tr>
                    <tr style="direction: rtl;">
                        <th colspan="2">(درجة أعمال الطالب + الامتحان)\
                            <?php echo to_ar_num(2) ?>
                        </th>
                    </tr>
                    <tr>
                        <th class="c3">
                            <?php echo to_ar_num(25) ?>٪
                        </th>
                        <th class="c3">
                            <?php echo to_ar_num(25) ?>٪
                        </th>
                        <th class="c3">
                            <?php echo to_ar_num(50) ?>٪
                        </th>
                        <th class="c2">شفهي + وظائف + مذاكرة</th>
                        <th class="c3">
                            <?php echo to_ar_num(100) ?>٪
                        </th>
                        <th class="c3">رقماً</th>
                        <th class="c5">كتابة</th>
                    </tr>
                    <?php
                    foreach ($moh as $name => $sub) : ?>
                        <tr>
                            <?php
                            $semester = explode('-', $sub)[$sem - 1];
                            $fields = explode(',', $semester);
                            ?>
                            <th>
                                <?php echo $name ?>
                            </th>
                            <th>
                                <?php echo to_ar_num($fields[0]) ?>
                            </th>
                            <th>
                                <?php echo to_ar_num($fields[1]) ?>
                            </th>
                            <th>
                                <?php echo to_ar_num($fields[2]) ?>
                            </th>
                            <th>
                                <?php echo to_ar_num((int) $fields[0] + (int) $fields[1] + (int) $fields[2]) ?>
                            </th>

                            <th>

                                <?php echo to_ar_num($fields[3]) ?>
                            </th>
                            <th>
                                <?php echo to_ar_num((int) $fields[0] + (int) $fields[1] + (int) $fields[2] + (int) $fields[3]) ?>
                            </th>
                            <th>
                                <?php echo to_ar_num(ceil(((int) $fields[0] + (int) $fields[1] + (int) $fields[2] + (int) $fields[3]) / 2)) ?>
                            </th>
                            <th>
                                <?php echo convert(ceil(((int) $fields[0] + (int) $fields[1] + (int) $fields[2] + (int) $fields[3]) / 2)) ?>
                            </th>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <p style="text-align:right" class="w-30">
                    المدرس:
                </p>
                <p style="text-align:right" class="w-30">
                    المدقق:
                </p>
                <p style="text-align:right" class="w-30">
                    الموجه:
                </p>
            </div>
            <script>
                function myPrint() {
                    cont = document.getElementById('cont');

                    temp = cont.style;
                    cont.style = '';
                    document.body.classList.remove('background');

                    fade = document.createElement('div');
                    fade.classList = 'd-print-none modal-backdrop fade show';
                    fade.id = 'fade_del';
                    document.body.appendChild(fade);

                    window.print();

                    document.getElementById('fade_del').remove();
                    document.body.classList.add('background');
                    cont.style = temp;
                }
            </script>
        </div>
    </div>
    <style>
        #pad {
            border-radius: 4px;
            direction: ltr;
            rotate: 270deg;
            margin: 0.5rem;
            box-shadow: var(--md-sys-elevation-1);
            background: var(--md-sys-color-tertiary-container);
            --md-slider-active-track-color: var(--md-sys-color-tertiary);
            --md-slider-handle-color: var(--md-sys-color-tertiary);
        }
    </style>
    <div class="d-print-none" style="position: fixed;right: calc(8px - 5rem);bottom: 9rem;">
        <md-slider step="10" id="pad" labeled></md-slider>
    </div>
    <script>
        pad = document.getElementById("pad");
        pad.onchange = (e) => {
            var style = document.getElementById("style");
            if (style)
                style.remove();
            style = (function() {
                var style = document.createElement("style");
                style.id = "style";
                style.appendChild(document.createTextNode(""));
                document.body.appendChild(style);
                return style;
            })();
            style.sheet.insertRule(`th{padding:${e.target.value}px !important}`);
        };
    </script>
<?php else : ?>
    <div class="content p-2 m-auto" id='adsum' style="text-align:right">
        <md-list class="content" style="min-width: 20rem;">
            <md-list-item role="presentation" md-list-item="" tabindex="-1">
                <p class="p-3 pe-0 on-surface-text m-0" style="text-align: right;"> محصلة مادة: </p>
                <input id="send" name="std_id" list="subjects" class="md-input" autocomplete="off">
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
                    <md-outlined-button class="d-block m-auto" style="width: fit-content;" trailing-icon="" onclick="send()" role="presentation">
                        أرسل </md-outlined-button>
                </md-list-item>
        </md-list>
    </div>

    <script>
        function send() {
            var secs = document.querySelectorAll("[name='section']"),
                sec;

            for (let index = 0; index < secs.length; index++)
                if (secs[index].checked)
                    sec = secs[index];
            var sems = document.querySelectorAll("[name='class']"),
                sem;

            for (let index = 0; index < sems.length; index++)
                if (sems[index].checked)
                    sem = sems[index];


            window.location += '/' + document.querySelector(`[value="${document.getElementById('send').value}"]`).id + '/' + sec.value + '/' + sem.value[1];
        }
    </script>
<?php endif; ?>