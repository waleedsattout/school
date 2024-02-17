<?php
helper('convert_ar');
if ($Class != 'الثالث الثانوي التجاري') :
    function pCer($subData, $stdMarks, $start)
    {
        $i = $start;
        $max = $min = $sum1 = $sum2 = $fasel1 = $fasel2 = $term1 = $term2 = $amli1 = $amli2 = 0;
        $stdMarks = $stdMarks[0];
        foreach ($subData as $sub) : ?>
            <?php
            //marks for every subject [term1 amd term2]
            $marks = explode('-', $stdMarks[$sub['name']]);
            //marks for term1
            $term1 = explode(',', $marks[0]);
            $term2 = explode(',', $marks[1]);

            $amli1 = $term1[0] + $term1[1] + $term1[2];
            $amli2 = $term2[0] + $term2[1] + $term2[2];
            $fasel1 = ceil(($amli1 + $term1[3]) / 2);
            $sum1 += $fasel1;
            $fasel2 = ceil(($amli2 + $term2[3]) / 2);
            $sum2 += $fasel2;

            $max += (int) $sub['max'];
            $min += (int) $sub['min'];
            ?>
            <div class="headed-row<?php echo $i; ?> ctm-grid">
                <div class="mark">
                    <?php echo $sub['arabic'] ?>
                </div>
                <div class="r1">
                    <?php echo to_ar_num($sub['max']) ?>
                </div>
                <div class="r2 ctm-grid">
                    <div class="r21">
                        <?php echo to_ar_num($amli1); ?>
                    </div>
                    <div class="r22">
                        <?php echo to_ar_num($term1[3]); ?>
                    </div>
                    <div class="rr23">
                        <?php echo to_ar_num($amli1 + $term1[3]); ?>
                    </div>
                    <div class="r34 <?php if ($fasel1 < $sub['min'])
                                        echo 'failed' ?>">
                        <?php echo to_ar_num($fasel1); ?>
                    </div>
                    <div class="r25">
                        <?php echo convert($fasel1) ?>
                    </div>
                </div>
                <div class="r3 ctm-grid">
                    <div class="r31">
                        <?php echo to_ar_num($amli2); ?>
                    </div>
                    <div class="r32">
                        <?php echo to_ar_num($term2[3]); ?>
                    </div>
                    <div class="r33">
                        <?php echo to_ar_num($amli2 + $term2[3]); ?>
                    </div>
                    <div class="r43">
                        <?php echo to_ar_num($fasel2); ?>
                    </div>
                    <div class="r35">
                        <?php echo convert($fasel2) ?>
                    </div>
                </div>
                <div class="r4 ctm-grid">
                    <div class="r41">
                        <?php echo to_ar_num($fasel1 + $fasel2) ?>
                    </div>
                    <div class="r42">
                        <?php echo to_ar_num(ceil(($fasel1 + $fasel2) / 2)); ?>
                    </div>
                    <div class="r45">
                        <?php echo convert(ceil(($fasel1 + $fasel2) / 2)) ?>
                    </div>
                </div>
                <div class="min">
                    <?php echo to_ar_num($sub['min']) ?>
                </div>
                <div class="notes"></div>
            </div>
        <?php $i++;
        endforeach; ?>
        <div class="normal-row<?php echo $i; ?> ctm-grid">
            <div class="sumHead"> مجموع درجات
                <?php echo $sub['header'] ?>
            </div>
            <div class="maxHead">
                <?php echo to_ar_num($max) ?>
            </div>
            <div class="blank11 failed"></div>
            <div class="numblank1 <?php if ($sum1 < $min)
                                        echo 'failed' ?>">
                <?php echo to_ar_num($sum1) ?>
            </div>
            <div class="wrblan1">
                <?php echo convert($sum1) ?>
            </div>
            <div class="blank22 failed1"></div>
            <div class="numblank2">
                <?php echo to_ar_num($sum2); ?>
            </div>
            <div class="wrblank2">
                <?php echo convert($sum2) ?>
            </div>
            <div class="headr11">
                <?php echo to_ar_num($sum1 + $sum2) ?>
            </div>
            <div class="headr12">
                <?php echo to_ar_num(ceil(($sum1 + $sum2) / 2)) ?>
            </div>
            <div class="headr13">
                <?php echo convert(ceil(($sum1 + $sum2) / 2)) ?>
            </div>
            <div class="headr2">
                <?php echo to_ar_num($min) ?>
            </div>
            <div class="headr3"></div>
        </div>
    <?php
        return [$max, $min, $sum1, $sum2];
    }
    ?>
    <div class="cert ctm-grid" style="width: max-content;height:100%">
        <div class="text-top">
            <div class="d-flex justify-content-between" style="flex-direction: row;height: 100%;">
                <div style="flex-direction: column;width: 85%;align-items: self-start;align-content: flex-start;">
                    <p style="text-align: right;margin: 0;">
                        وزارة التربية
                        <br>
                        مديرية التربية في محافظة ريف دمشق
                        <br>
                        ثانوية المهنية التجارية في ببيلا
                    </p>
                    <tag-name>
                        <p class="ms-auto">
                            الطالبة:
                            <?php echo esc($stdData['firstName'] . ' ' . $stdData['lastName']) ?>
                        </p>
                        <p>
                            ابنة السيد:
                            <?php echo esc($stdData['fatherName']) ?>
                        </p>
                        <p> والدتها:
                            <?php echo esc($stdData['motherName']) ?>
                        </p>
                        <p>
                            من الصف:
                            <?php echo $Class; ?>
                        </p>
                    </tag-name>
                </div>

                <div class="d-flex flex-column justify-content-between" style="text-align: right;width:15%;align-content: start;    flex-direction: column;">
                    <pre style="font-family: inherit;">العام الدراسي   <?php echo to_ar_num(to_ar_num(explode('-', $year)[0])) ?> /   <?php echo to_ar_num(to_ar_num(explode('-', $year)[1])) ?> م</pre>
                    <p style="text-align: right;justify-content: center;">
                        الشعبة:
                        <?php echo $sh ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="header ctm-grid">
            <div class="notes">الملاحظات </div>
            <div class="min rotate">النهاية الصغرى </div>
            <div class="result ctm-grid">
                <div class="resultHeader">النتيجـــــــــــة </div>
                <div class="avg">المعدل العام </div>
                <div class="sumT">مجموع المحصلتين </div>
                <div class="num3">رقماً </div>
                <div class="writing3">كتابة </div>
            </div>
            <div class="sem2 ctm-grid">
                <div class="sem22">الفصــــل الثانــــــــي </div>
                <div class="avg2">المحصلة الثانية </div>
                <div class="sum2">المجموع</div>
                <div class="fin2">الامتحان</div>
                <div class="duringSem2">درجة اعمال الطالب</div>
                <div class="num2">رقماً </div>
                <div class="writing2">كتابة </div>
            </div>
            <div class="sem1 ctm-grid">
                <div class="sem12">الفصـــــــل الأول </div>
                <div class="avg1">المحصلة الأولى</div>
                <div class="sum1">المجموع</div>
                <div class="fin1">الامتحان</div>
                <div class="duringSem1">درجة اعمال الطالب</div>
                <div class="num1">رقماً </div>
                <div class="writing1">كتابة </div>
            </div>
            <div class="max rotate">النهاية العظمى</div>
            <div class="angle" style="position: relative;">
                <div style="position: absolute;top: 2%;left: 8%;border: none;outline:none">الفصول</div>
                <div style="position: absolute;bottom: 2%;right: 8%;border: none;outline:none">المواد</div>
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute;">
                    <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke" stroke="#000" stroke-width="2">
                    </line>
                </svg>
            </div>
        </div>

        <?php
        $dd1 = pCer($subData1, $stdMarks, 0);
        $dd2 = pCer($subData2, $stdMarks, $sec1);

        $max = $dd1[0] + $dd2[0];
        $min = $dd1[1] + $dd2[1];

        $fasel1 = $dd1[2] + $dd2[2];
        $fasel2 = $dd1[3] + $dd2[3];
        ?>

        <div class="normal-row0 ctm-grid">
            <div class="sumHead">المجموع العام</div>
            <div class="maxHead">
                <?php echo to_ar_num($max) ?>
            </div>
            <div class="blank11 failed1"></div>
            <div class="numblank1 <?php if ($fasel1 < $min)
                                        echo 'failed' ?>">
                <?php echo to_ar_num($fasel1) ?>
            </div>
            <div class="wrblan1">
                <?php echo convert($fasel1) ?>
            </div>
            <div class="blank22 failed1"></div>
            <div class="numblank2">
                <?php echo to_ar_num($fasel2) ?>
            </div>
            <div class="wrblank2">
                <?php echo convert($fasel2) ?>
            </div>
            <div class="headr11">
                <?php echo to_ar_num($fasel1 + $fasel2) ?>
            </div>
            <div class="headr12">
                <?php echo to_ar_num(ceil(($fasel1 + $fasel2) / 2)) ?>
            </div>
            <div class="headr13">
                <?php echo convert(ceil(($fasel1 + $fasel2) / 2)) ?>
            </div>
            <div class="headr2">
                <?php echo to_ar_num($min) ?>
            </div>
            <div class="headr3"></div>
        </div>
        <div class="normal-row1 ctm-grid">
            <div class="sumHead">السلوك</div>
            <div class="maxHead">
                <?php echo to_ar_num(200) ?>
            </div>
            <div class="blank11 failed1"></div>
            <div class="numblank1 <?php if (explode('-', $stdData['behav'])[0] < 140)
                                        echo 'failed' ?>">
                <?php echo to_ar_num(explode('-', $stdData['behav'])[0]) ?>
            </div>
            <div class="wrblan1">
                <?php echo convert(explode('-', $stdData['behav'])[0]) ?>
            </div>
            <div class="blank22 failed1"></div>
            <div class="numblank2">
                <?php echo to_ar_num(explode('-', $stdData['behav'])[1]) ?>
            </div>
            <div class="wrblank2">
                <?php echo convert(explode('-', $stdData['behav'])[1]) ?>
            </div>
            <div class="headr11">
                <?php echo to_ar_num(((int) explode('-', $stdData['behav'])[0] + (int) explode('-', $stdData['behav'])[1])) ?>
            </div>
            <div class="headr12">
                <?php echo to_ar_num(((int) explode('-', $stdData['behav'])[0] + (int) explode('-', $stdData['behav'])[1]) / 2) ?>
            </div>
            <div class="headr13">
                <?php echo convert((((int) explode('-', $stdData['behav'])[0] + (int) explode('-', $stdData['behav'])[1])) / 2) ?>
            </div>
            <div class="headr2">
                <?php echo to_ar_num(140) ?>
            </div>
            <div class="headr3"></div>
        </div>
        <div class="normal-row2 ctm-grid">
            <div class="sumHead">المجموع النهائي</div>
            <div class="maxHead">
                <?php echo to_ar_num($max + 200) ?>
            </div>
            <div class="blank11 failed1"></div>
            <div class="numblank1 <?php if ((explode('-', $stdData['behav'])[0] + $fasel1) < $min + 140)
                                        echo 'failed' ?>">
                <?php echo to_ar_num((int) explode('-', $stdData['behav'])[0] + $fasel1) ?>
            </div>
            <div class="wrblan1">
                <?php echo convert(((int) explode('-', $stdData['behav'])[0] + $fasel1)) ?>
            </div>
            <div class="blank22 failed1"></div>
            <div class="numblank2">
                <?php echo to_ar_num((int) explode('-', $stdData['behav'])[1] + $fasel2) ?>
            </div>
            <div class="wrblank2">
                <?php echo convert(((int) explode('-', $stdData['behav'])[1] + $fasel2)) ?>
            </div>
            <div class="headr11">
                <?php echo to_ar_num(((int) explode('-', $stdData['behav'])[0] + $fasel1) + ((int) explode('-', $stdData['behav'])[1] + $fasel2)) ?>
            </div>
            <div class="headr12">
                <?php echo to_ar_num(ceil((((int) explode('-', $stdData['behav'])[0] + $fasel1) + ((int) explode('-', $stdData['behav'])[1] + $fasel2)) / 2)) ?>
            </div>
            <div class="headr13">
                <?php echo convert(ceil((((int) explode('-', $stdData['behav'])[0] + $fasel1) + ((int) explode('-', $stdData['behav'])[1] + $fasel2)) / 2)) ?>
            </div>
            <div class="headr2">
                <?php echo to_ar_num($min + 140) ?>
            </div>
            <div class="headr3"></div>
        </div>

        <div class="table2 ctm-grid">
            <div class="t-1-1" style="position: relative;">
                <div style="position: absolute;top: 2%;left: 8%;border: none;outline: none;">الدوام</div>
                <div style="position: absolute;bottom: 2%;right: 8%;border: none;outline: none;">الفصول</div>
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute;border:none">
                    <line x1="0" y1="100" x2="100" y2="0" vector-effect="non-scaling-stroke" stroke="#000" stroke-width="2">
                    </line>
                </svg>
            </div>
            <div class="t-1-2">الدوام الفعلي</div>
            <div class="t-1-3">الغياب</div>
            <div class="t-1-3-1">مبرر</div>
            <div class="t-1-3-2">غير مبرر</div>
            <div class="t-1-4">النسبة المئوية</div>
            <div class="t-1-5">ملاحظات الولى وتوقيعه</div>
            <div class="finresult">النتيجـــــة النهائيـــــــة</div>
            <div class="management">مديرة الثانوية لمى النفوري</div>
            <div class="final1">
                <p class="x1" style="grid-area: x1;">نجاح إلى الصف: </p>
                <p class="x2" style="grid-area: x2;">الترتيب: <?php echo to_ar_num($stdData['rank']) ?></p>
                <p class="x3" style="grid-area: x3;">رسوب في الصف: </p>
            </div>
            <div class="final2"></div>
            <div class="per1"></div>
            <div class="per2"></div>
            <div class="per3"></div>
            <div class="d1">
                <?php echo to_ar_num($actualAttendance1) ?>
            </div>
            <div class="d2">
                <?php echo to_ar_num($actualAttendance2) ?>
            </div>
            <div class="d3">
                <?php echo to_ar_num($actualAttendance1 + $actualAttendance2) ?>
            </div>
            <div class="f1"><?php echo lang('General.firstSem') ?> </div>
            <div class="f2">الفصل الثاني </div>
            <div class="f3">المجموع </div>
            <div class="q1">
                <?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[0])[0]) ?>
            </div>
            <div class="q2">
                <?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[1])[0]) ?>
            </div>
            <div class="q3">
                <?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[0])[0] + explode(',', explode('-', $stdData['absent'])[1])[0]) ?>
            </div>
            <div class="qq1">
                <?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[0])[1]) ?>
            </div>
            <div class="qw2">
                <?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[1])[1]) ?>
            </div>
            <div class="qq3">
                <?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[0])[1] + explode(',', explode('-', $stdData['absent'])[1])[1]) ?>
            </div>
        </div>
        <div class="noBorder text-end">
            <div>توقيع الموجه:</div>
            <div>توقيع المدير:</div>
            <div>في
                <pre style="display: inline;">  /  /  <?php echo to_ar_num(explode('-', $year)[1]) ?></pre>
            </div>
            <div>توقيع الموجه:</div>
            <div>في
                <pre style="display: inline;">  /  /  <?php echo to_ar_num(explode('-', $year)[1]) ?></pre>
            </div>
        </div>
        <div class="heading1 rotate">
            <?php echo $subData1[0]['header'] ?>
        </div>
        <div class="heading2 rotate">
            <?php echo $subData2[0]['header'] ?>
        </div>
    </div>

    <script>
        function toEnglishDigits(str) {

            // convert persian digits [۰۱۲۳۴۵۶۷۸۹]
            var e = '۰'.charCodeAt(0);
            str = str.replace(/[۰-۹]/g, function(t) {
                return t.charCodeAt(0) - e;
            });

            // convert arabic indic digits [٠١٢٣٤٥٦٧٨٩]
            e = '٠'.charCodeAt(0);
            str = str.replace(/[٠-٩]/g, function(t) {
                return t.charCodeAt(0) - e;
            });
            return str;
        }
        (() => {
            let showFasel2 = <?php echo $showFasel2; ?>;
            if (showFasel2 == 0) {
                for (cls of ['.r31', '.r32', '.r33', '.r35', '.r43', '.numblank2', '.r41', '.r42', '.r45', '.headr11', '.headr12', '.headr13', '.headr1', '.wrblank2'])
                    for (let cell of document.querySelectorAll(cls)) {
                        cell.innerHTML = ''
                    }
            }
        })()
        document.getElementById("cont").classList.add("p-5");

        function myPrint() {
            let x = window.open();
            x.document.write("<link rel='stylesheet' href='<?php echo base_url('public/assets/css/certificate.css', env('protocol')) ?>'>");
            x.document.write("<link rel='stylesheet' href='<?php echo base_url('public/assets/css/certificate.css', env('protocol')) ?>'>");
            x.document.write(document.getElementById("cont").innerHTML);
            window.onload = e => x.print();
        }
    </script>

    <style>
        @media print {

            #toolbarContainer,
            md-fab {
                display: none;
            }
        }

        .r1,
        .r21,
        .r22,
        .r34,
        .r31,
        .r32,
        .r33,
        .r43,
        .r41,
        .r42,
        .maxHead,
        .numblank1,
        .numblank2,
        .headr11,
        .headr12,
        .min {
            font-size: 1.2cqw;
        }

        .cert {
            grid-template-rows: 3fr 3fr repeat(<?php if (session()->get("class") == "c10")
                                                    echo "16";
                                                else
                                                    echo 17; ?>, 1fr) 3fr 1fr;
            grid-template-areas:
                "text-top text-top"
                "header header"
                "headed-row0 heading1"
                "headed-row1 heading1"
                "headed-row2 heading1"
                "headed-row3 heading1"
                "headed-row4 heading1"
                "normal-row5 normal-row5"
                "headed-row5 heading2"
                "headed-row6 heading2"
                "headed-row7 heading2"
                "headed-row8 heading2"
                "headed-row9 heading2"
                "headed-row10 heading2"
                <?php if (session()->get('class') != 'c10')
                    echo '"headed-row11 heading2""normal-row12 normal-row12"';
                else
                    echo '"normal-row11 normal-row11"' ?>
                "normal-row0 normal-row0"
                "normal-row1 normal-row1"
                "normal-row2 normal-row2"
                "table2 table2"
                "noBorder noBorder"
        }
    </style>
<?php else : ?>
    <?php
    function pCer($subData, $stdMarks, $start)
    {
        $i = $start;
        $sumOfExam1 = $max = $min = $sumOfAmli1 = $sumOfAmli2 = $term1 = $term2 = $amli1 = $amli2 = 0;
        $stdMarks = $stdMarks[0];
        foreach ($subData as $sub) : ?>
            <?php
            //marks for every subject [term1 amd term2]
            $marks = explode('-', $stdMarks[$sub['name']]);
            //marks for term1
            $term1 = explode(',', $marks[0]);
            $term2 = explode(',', $marks[1]);

            $amli1 = $term1[0] + $term1[1] + $term1[2];
            $amli2 = $term2[0] + $term2[1] + $term2[2];

            $sumOfAmli1 += $amli1;
            $sumOfAmli2 += $amli2;
            $sumOfExam1 += $term1[3];
            $max += (int) $sub['max'];
            $min += (int) $sub['min'];
            ?>

            <tr>
                <td height="37">
                    <?php echo $sub['arabic'] ?>
                </td>
                <td>
                    <?php echo to_ar_num($sub['max']) ?>
                </td>
                <td class="<?php echo $amli1 < $sub['min'] ? 'failed' : ''; ?>">
                    <?php echo to_ar_num($amli1) ?>
                </td>
                <td colspan="3">
                    <?php echo convert($amli1) ?>
                </td>
                <td class="<?php echo $term1[3] < $sub['min'] ? 'failed' : ''; ?>">
                    <?php echo to_ar_num($term1[3]); ?>
                </td>
                <td colspan="3">
                    <?php echo convert($term1[3]); ?>
                </td>
                <td>
                    <?php echo to_ar_num($amli2) ?>
                </td>
                <td colspan="3">
                    <?php echo convert($amli2) ?>
                </td>
                <td>
                    <?php echo to_ar_num($amli1 + $amli2) ?>
                </td>
                <td>
                    <?php echo to_ar_num(ceil(($amli1 + $amli2) / 2)) ?>
                </td>
                <td colspan="3">
                    <?php echo convert(ceil(($amli1 + $amli2) / 2)) ?>
                </td>
                <td colspan="4"></td>
            </tr>
    <?php $i++;
        endforeach;
        return [$max, $min, $sumOfAmli1, $sumOfExam1, $sumOfAmli2];
    }
    ?>
    <style>
        @media print {

            #toolbarContainer,
            md-fab {
                display: none;
            }
        }

        tr:nth-last-child(-n+1) td {
            border: none !important
        }

        comment {
            display: none;
        }

        table {
            direction: rtl;
            width: max-content;
            border-collapse: collapse;
        }

        td {
            white-space: nowrap;
        }

        tr:nth-child(-n+4) td {
            text-align: right;
        }

        tr:not(:nth-child(-n+4)) td {
            border: 1px solid;
            text-align: center;
        }
    </style>
    <table>
        <colgroup width="150"></colgroup>
        <colgroup span="18" width="50"></colgroup>
        <colgroup span="4" width="65"></colgroup>
        <tbody>
            <tr>
                <td height="19">
                    وزارة التربية
                </td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td height="19" colspan="5">
                    مديرية التربية في محافظة ريف دمشق
                </td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3">
                    <pre style="font-family: inherit;">العام الدراسي   <?php echo to_ar_num(to_ar_num(explode('-', $year)[0])) ?> /   <?php echo to_ar_num(to_ar_num(explode('-', $year)[1])) ?> م</pre>
                </td>
            </tr>
            <tr>
                <td height="19" colspan="5">
                    ثانوية المهنية التجارية في ببيلا
                </td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td colspan="4"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td height="19">
                    الطالبة:
                    <?php echo esc($stdData['firstName'] . ' ' . $stdData['lastName']) ?>
                </td>
                <td colspan="3"> ابنة:
                    <?php echo esc($stdData['fatherName']) ?>
                </td>
                <td></td>
                <td colspan="2"> والدتها:
                    <?php echo esc($stdData['motherName']) ?>
                </td>
                <td></td>
                <td></td>
                <td colspan="6">
                    من الصف: الثالث الثانوي التجاري
                </td>
                <td></td>
                <td>
                    الشعبة:
                </td>
                <td>
                    <?php echo $sh ?>
                </td>
                <td></td>
                <td></td>
                <td colspan="2">
                    رقمه في السجل العام:
                </td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="2" height="74">
                    المواد الدرسية
                </td>
                <td rowspan="2">
                    النهاية العظمى
                </td>
                <td colspan="4">
                    درجة أعمال الفصل الأول
                </td>
                <td colspan="4">
                    امتحان الفصل الأول
                </td>
                <td colspan="4">
                    درجة أعمال الفصل الثاني
                </td>
                <td>
                    المجموع
                </td>
                <td colspan="4">
                    المحصلة
                </td>
                <td colspan="4" rowspan="2">
                    الملاحظات
                </td>
            </tr>
            <tr>
                <td>
                    رقماً
                </td>
                <td colspan="3">
                    كتابة
                </td>
                <td>
                    رقماً
                </td>
                <td colspan="3">
                    كتابة
                </td>
                <td>
                    رقماً
                </td>
                <td colspan="3">
                    كتابة
                </td>
                <td>
                    رقماً
                </td>
                <td>
                    رقماً
                </td>
                <td colspan="3">
                    كتابة
                </td>
            </tr>

            <?php
            $dd1 = pCer($subData1, $stdMarks, 0);
            $dd2 = pCer($subData2, $stdMarks, $sec1);

            $max = $dd1[0] + $dd2[0];
            $min = $dd1[1] + $dd2[1];

            $amli1 = $dd1[2] + $dd2[2];
            $exam1 = $dd1[3] + $dd2[3];
            $amli2 = $dd1[4] + $dd2[4];
            ?>
            <tr>
                <td height="37">
                    المجموع العام
                </td>
                <td>
                    <?php echo to_ar_num($max) ?>
                </td>
                <td>
                    <?php echo to_ar_num($amli1) ?>
                </td>
                <td colspan="3">
                    <?php echo convert($amli1) ?>
                </td>
                <td>
                    <?php echo to_ar_num($exam1) ?>
                </td>
                <td colspan="3">
                    <?php echo convert($exam1) ?>
                </td>
                <td>
                    <?php echo to_ar_num($amli2) ?>
                </td>
                <td colspan="3">
                    <?php echo convert($amli2) ?>
                </td>
                <td>
                    <?php echo to_ar_num($amli1 + $exam1 + $amli2) ?>
                </td>
                <td>
                    <?php echo to_ar_num(ceil(($amli1 + $exam1 + $amli2) / 3)) ?>
                </td>
                <td colspan="3">
                    <?php echo convert(ceil(($amli1 + $exam1 + $amli2) / 3)) ?>
                </td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td height="37">السلوك</td>
                <td>
                    <?php echo to_ar_num(200) ?>
                </td>
                <td class="<?php if (explode('-', $stdData['behav'])[0] < 140)
                                echo 'failed' ?>">
                    <?php echo to_ar_num(explode('-', $stdData['behav'])[0]) ?>
                </td>
                <td colspan="3">
                    <?php echo convert(explode('-', $stdData['behav'])[0]) ?>
                </td>
                <td>
                    <?php echo to_ar_num(explode('-', $stdData['behav'])[1]) ?>
                </td>
                <td colspan="3">
                    <?php echo convert(explode('-', $stdData['behav'])[1]) ?>
                </td>
                <td>
                    <?php echo to_ar_num(explode('-', $stdData['behav'])[1]) ?>
                </td>
                <td colspan="3">
                    <?php echo convert(explode('-', $stdData['behav'])[1]) ?>
                </td>
                <td>
                    <?php echo to_ar_num(explode('-', $stdData['behav'])[0] + explode('-', $stdData['behav'])[1]) ?>
                </td>
                <td>
                    <?php echo to_ar_num(ceil((explode('-', $stdData['behav'])[0] + explode('-', $stdData['behav'])[1])) / 2) ?>
                </td>
                <td colspan="3">
                    <?php echo convert(ceil((explode('-', $stdData['behav'])[0] + explode('-', $stdData['behav'])[1])) / 2) ?>
                </td>
                <td colspan="4">
                    متوسط درجات السلوك
                </td>
            </tr>
            <tr>
                <td height="37">
                    المجموع النهائي
                </td>
                <td>
                    <?php echo to_ar_num($max + 200) ?>
                </td>
                <td class="<?php if ((explode('-', $stdData['behav'])[0] + $amli1) < $min + 140)
                                echo 'failed' ?>">
                    <?php echo to_ar_num((int) explode('-', $stdData['behav'])[0] + $amli1) ?>
                </td>
                <td colspan="3">
                    <?php echo convert((int) explode('-', $stdData['behav'])[0] + $amli1) ?>
                </td>
                <td>
                    <?php echo to_ar_num($exam1 + explode('-', $stdData['behav'])[0]) ?>
                </td>
                <td colspan="3">
                    <?php echo convert($exam1 + explode('-', $stdData['behav'])[0]) ?>
                </td>
                <td>
                    <?php echo to_ar_num($amli2 + explode('-', $stdData['behav'])[1]) ?>
                </td>
                <td colspan="3">
                    <?php echo convert($amli2 + explode('-', $stdData['behav'])[1]) ?>
                </td>
                <td>
                    <b>
                        المعدل العام
                    </b>
                </td>
                <td>
                    <?php echo to_ar_num(ceil(($amli1 + $exam1 + $amli2) / 3) + ceil((explode('-', $stdData['behav'])[0] + explode('-', $stdData['behav'])[1])) / 2) ?>
                </td>
                <td colspan="3">
                    <?php echo convert(ceil(($amli1 + $exam1 + $amli2) / 3) + ceil((explode('-', $stdData['behav'])[0] + explode('-', $stdData['behav'])[1])) / 2) ?>
                </td>
                <td style="white-space: nowrap; font-size:14px">
                    الأول الثانوي
                </td>
                <td style="white-space: nowrap; font-size:14px">
                    الثاني الثانوي
                </td>
                <td style="white-space: nowrap; font-size:14px">
                    الثالث الثانوي
                </td>
                <td style="white-space: nowrap; font-size:14px">
                    المجموع \
                    <?php echo to_ar_num(3); ?>
                </td>
            </tr>
            <tr>
                <td rowspan="2" height="60">
                    الدوام
                </td>
                <td rowspan="2">
                    الدوام الفعلي
                </td>
                <td rowspan="2">
                    دوام الطالبة
                </td>
                <td colspan="4">
                    الغياب
                </td>
                <td colspan="3" rowspan="2">
                    النسبة المئوية
                </td>
                <td colspan="5" rowspan="2">
                    ملاحظات الولى وتوقيعه
                </td>
                <td colspan="4" rowspan="2">
                    ترتيب الطالبة
                </td>
                <td rowspan="2" colspan="4">
                    النتيجـــــة النهائيـــــــة
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    مبرر
                </td>
                <td colspan="2">
                    غير مبرر
                </td>
            </tr>
            <tr>
                <td height="30">
                    الفصل الأول
                </td>
                <td><?php echo to_ar_num($actualAttendance1) ?></td>
                <td><?php echo to_ar_num($actualAttendance1 - explode(',', explode('-', $stdData['absent'])[0])[0] - explode(',', explode('-', $stdData['absent'])[0])[1]) ?></td>
                <td colspan="2"><?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[0])[0]) ?></td>
                <td colspan="2"><?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[0])[1]) ?></td>
                <td colspan="3"></td>
                <td colspan="5" rowspan="3"></td>
                <td colspan="4" rowspan="3"></td>
                <td colspan="4">
                    رشح إلى الامتحان العام لشهادة التعليم المهني
                </td>
            </tr>
            <tr>
                <td height="30">
                    الفصل الثاني
                </td>
                <td><?php echo to_ar_num($actualAttendance2) ?></td>
                <td><?php echo to_ar_num($actualAttendance2 - explode(',', explode('-', $stdData['absent'])[1])[0] - explode(',', explode('-', $stdData['absent'])[1])[1]) ?></td>
                <td colspan="2"><?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[1])[0]) ?></td>
                <td colspan="2"><?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[1])[1]) ?></td>
                <td colspan="3"></td>
                <td colspan="4">
                    لم ترشح إلى الامتحان العام لشهادة التعليم المهني
                </td>
            </tr>
            <tr>
                <td height="30">
                    المجموع
                </td>
                <td><?php echo to_ar_num($actualAttendance1 + $actualAttendance2) ?></td>
                <td><?php echo to_ar_num($actualAttendance2 - explode(',', explode('-', $stdData['absent'])[1])[0] - explode(',', explode('-', $stdData['absent'])[1])[1] + $actualAttendance1 - explode(',', explode('-', $stdData['absent'])[0])[0] - explode(',', explode('-', $stdData['absent'])[0])[1]) ?></td>
                <td colspan="2"><?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[1])[0] + explode(',', explode('-', $stdData['absent'])[0])[0]) ?></td>
                <td colspan="2"><?php echo to_ar_num(explode(',', explode('-', $stdData['absent'])[1])[1] + explode(',', explode('-', $stdData['absent'])[0])[1]) ?></td>
                <td colspan="3"></td>
                <td>
                    اسم المدير
                </td>
                <td></td>
                <td style="white-space:nowrap">
                    التوقيع والختم
                </td>
                <td></td>
            </tr>
            <tr>
                <td height="30">
                    توقيع الموجه:
                </td>
                <td colspan="6">
                    توقيع المدير:
                </td>
                <td colspan="3">
                    في
                    <pre style="display: inline;">  /  /  <?php echo to_ar_num(explode('-', $year)[1]) ?></pre>
                </td>
                <td colspan="5"></td>
                <td colspan="4">
                    توقيع الموجه:
                </td>
                <td colspan="4">
                    في
                    <pre style="display: inline;">  /  /  <?php echo to_ar_num(explode('-', $year)[1]) ?></pre>
                </td>
            </tr>
        </tbody>
    </table>
    <script>
        if (<?php var_export($showFasel2 == 0) ?>)
            (() => {
                let tr = document.querySelectorAll('#cont tr');
                for (let row = 6; row < 21; row++) {
                    let td = tr[row].children;
                    for (let cell = 6; cell < 11; cell++) {
                        td[cell].innerHTML = ''
                    }
                }
            })()

        function myPrint() {
            let x = window.open();
            x.document.write(document.getElementById("cont").innerHTML);
            x.print();
        }

        document.getElementById("cont").classList.add("p-5");
    </script>
<?php endif; ?>

<style>
    .failed,
    .failed1 {
        background-color: #ffdad2 !important;
        color: #3d0700;
        text-decoration: underline;
    }
</style>