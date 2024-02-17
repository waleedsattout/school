<div style="direction:rtl;text-align:right">
    <form id="forms" class="info needs-validation" action="<?php echo base_url($locale . '/students/edit_student') ?>" method="dialogS" novalidate="">
        <input type="text" class="d-none" name="id" id="id" value="<?php echo $stdData['id'] ?>">
        <div class="d-flex contact-row" style="flex-flow: wrap; width:fit-content">
            <md-outlined-text-field autofocus name="firstName" value="<?php echo $stdData['firstName'] ?>" required label="<?php echo lang('General.firstName') ?>"></md-outlined-text-field>
            <md-outlined-text-field name="lastName" label="<?php echo lang('General.lastName') ?>" value="<?php echo $stdData['lastName'] ?>" required></md-outlined-text-field>

            <md-outlined-text-field name="fatherName" value="<?php echo $stdData['fatherName'] ?>" required label="<?php echo lang('General.fatherName') ?>"></md-outlined-text-field>
            <md-outlined-text-field name="motherName" value="<?php echo $stdData['motherName'] ?>" required label="<?php echo lang('General.motherName') ?>"></md-outlined-text-field>

            <md-outlined-text-field name="dob" value="<?php echo $stdData['dob'] ?>" required type="number" pattern="^[a-zA-Z]+$" label="<?php echo lang('General.dob') ?>"></md-outlined-text-field>
            <md-outlined-select required name="sec" autocomplete="true" label="<?php echo lang('General.section') ?>">
                <?php foreach ($sections as $key => $val) : ?>
                    <md-select-option id="sec<?php echo $key ?>" value="<?php echo $key ?>" <?php echo $stdData['section'] == $key ? 'selected' : '' ?>>
                        <div slot="headline">
                            <?php echo $val ?>
                        </div>
                    </md-select-option>
                <?php endforeach; ?>
            </md-outlined-select>
        </div>
        <md-filled-tonal-button tonal='error' class="d-block m-auto pt-2" style=" width: fit-content;" trailing-icon onclick="editStd(false)"><?php echo lang('General.send') ?></md-filled-tonal-button>
    </form>
</div>

<hr>
<div class="marks">
    <div class="mainMarks" style="direction: ltr;">
        <div class="row0">
            <div class="empty" style="min-width: 215px"></div>
            <div class="fasel1">
                <div class="head1"><?php echo lang('General.firstSem') ?></div>
                <div class="cont1">
                    <div class="sh1"><?php echo lang('General.verbal') ?></div>
                    <div class="hm1"><?php echo lang('General.assignments') ?></div>
                    <div class="quiz1"><?php echo lang('General.Revision') ?></div>
                    <div class="final1"><?php echo lang('General.Exam') ?></div>
                </div>
            </div>
            <div class="fasel2">
                <div class="head2">
                    <?php echo lang('General.firstSem') ?>
                </div>
                <div class="cont2">
                    <div class="sh2"><?php echo lang('General.verbal') ?></div>
                    <div class="hm2"><?php echo lang('General.assignments') ?></div>
                    <div class="quiz2"><?php echo lang('General.Revision') ?></div>
                    <div class="final2"><?php echo lang('General.Exam') ?></div>
                </div>
            </div>
            <div class="sub" style="grid-area:sub; min-width:72px"></div>
        </div>
        <?php
        $i = 1;
        $stdMarks = $stdMarks[0];
        foreach ($subData as $subject) {
            $marks1 = explode(',', explode('-', $stdMarks[$subject['name']])[0]);
            $marks2 = explode(',', explode('-', $stdMarks[$subject['name']])[1]);
        ?>
            <div class="row<?php echo $i; ?>">
                <form class="row<?php echo $i; ?> needs-validation" action="<?php echo base_url($locale . '/students/edit_student_marks') ?>" method="POST" novalidate="">
                    <input type="text" class="d-none" name="id" id="id" value="<?php echo $stdData['id'] ?>">
                    <input type="text" class="d-none" name="Name" id="name" value="<?php echo $subject['name'] ?>">
                    <div class="name">
                        <?php echo $subject['arabic'] ?>
                    </div>
                    <div class="rowMarks">
                        <md-outlined-text-field type="text" class="mark0" name="sh1" id="sh1" value="<?php echo $marks1[0] ?>" required=""></md-outlined-text-field>
                        <md-outlined-text-field type="text" class="mark1" name="hom1" id="hom1" value="<?php echo $marks1[1] ?>" required=""></md-outlined-text-field>
                        <md-outlined-text-field type="text" class="mark2" name="test1" id="test1" value="<?php echo $marks1[2] ?>" required=""></md-outlined-text-field>
                        <md-outlined-text-field type="text" class="mark3" id="fin1" name="fin1" value="<?php echo $marks1[3] ?>" required=""></md-outlined-text-field>
                        <md-outlined-text-field type="text" class="mark4" name="sh2" id="sh2" value="<?php echo $marks2[0] ?>" required=""></md-outlined-text-field>
                        <md-outlined-text-field type="text" class="mark5" name="hom2" id="hom2" value="<?php echo $marks2[1] ?>" required=""></md-outlined-text-field>
                        <md-outlined-text-field type="text" class="mark6" name="test2" id="test2" value="<?php echo $marks2[2] ?>" required=""></md-outlined-text-field>
                        <md-outlined-text-field type="text" class="mark7" id="fin2" name="fin2" value="<?php echo $marks2[3] ?>" required=""></md-outlined-text-field>
                    </div>
                    <md-filled-button trailing-icon><?php echo lang('General.send') ?>
                    </md-filled-button>
                </form>
            </div>

        <?php $i++;
        } ?>
    </div>
</div>

<hr>
<div class="d-flex">
    <md-filled-button onclick="app.showModal('','<?php echo lang('General.AreYouSure') ?>','hideStd()','<?php echo lang('General.AreYouSure') ?>','confirm')">
        <?php echo lang('General.Hide') . ' ' . lang('Students.Student') ?>
    </md-filled-button>

    <md-filled-button onclick="del()"> <?php echo lang('General.delete') . ' ' . lang('Students.Student') ?></md-filled-button>
</div>

<style>
    .d-flex md-filled-button {
        --md-filled-button-container-color: var(--md-sys-color-error);
    }

    button.btn.error.on-error-text:hover {
        box-shadow: 0px 3px 1px -2px rgb(var(--md-sys-color-shadow-rgb) / 0.2), 0px 2px 2px 0px rgb(var(--md-sys-color-shadow-rgb) / 0.14), 0px 1px 5px 0px rgb(var(--md-sys-color-shadow-rgb) / 0.12)
    }

    .marks {
        overflow: auto;
        padding: 1rem;
        background: var(--md-sys-color-surface-container);
        border-radius: 1.5rem;
        color: var(--md-sys-color-on-background);
    }

    md-filled-button {
        width: fit-content;
        display: block;
        margin: auto;
    }

    .marks md-filled-button {
        width: calc(100% - .5rem);
        height: calc(100% - 2px);
        background: var(--md-sys-color-primary);
        border-radius: 4px;
    }

    @media screen and (max-width: 667px) {
        .add-std-container {
            margin: 0rem;
        }
    }

    @media screen and (min-width: 668px) {
        .add-std-container {
            margin: auto 11rem;
        }
    }

    #cont {
        width: auto;
    }

    .add-std-container {
        padding: 2.5rem;
        height: fit-content;
        background-color: var(--md-sys-color-surface);
        border-radius: 3rem;
        display: grid;
    }

    .add-std-container .info {
        padding: 2.5rem;
        border-radius: 2rem;
        background: var(--md-sys-color-surface-container);
    }

    .stddata {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }

    .form-label {
        white-space: nowrap;
    }

    .mainMarks {
        overflow: auto;
        display: grid;
        grid-template-columns: 3.25fr;
        grid-template-rows: repeat(12, 0.5fr);
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "row0"
            "row1"
            "row2"
            "row3"
            "row4"
            "row5"
            "row6"
            "row7"
            "row8"
            "row9"
            "row10"
            "row11"
            <?php if (session()->get("class") != "c10")
                echo "\"row12\""; ?>
        ;
        align-items: center;
    }

    .row0 {
        display: grid;
        grid-template-columns: 0.25fr repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "sub fasel2 fasel1 empty"
            "sub fasel2 fasel1 empty";
        grid-area: row0;
    }

    .empty {
        grid-area: empty;
    }

    .fasel1 {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: repeat(2, 0.5fr);
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "head1"
            "cont1";
        grid-area: fasel1;
    }

    .head1 {
        grid-area: head1;
    }

    .sh1 {
        grid-area: sh1;
    }

    .hm1 {
        grid-area: hm1;
    }

    .quiz1 {
        grid-area: quiz1;
    }

    .final1 {
        grid-area: final1;
    }

    .fasel2 {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: repeat(2, 0.5fr);
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "head2"
            "cont2";
        grid-area: fasel2;
    }

    .head2 {
        grid-area: head2;
    }

    .sh2 {
        grid-area: sh2;
    }

    .hm2 {
        grid-area: hm2;
    }

    .quiz2 {
        grid-area: quiz2;
    }

    .final2 {
        grid-area: final2;
    }

    .row1,
    .row2,
    .row3,
    .row4,
    .row5,
    .row6,
    .row7,
    .row8,
    .row9,
    .row10,
    .row11,
    .row12 {
        display: grid;
        grid-template-columns: 0.25fr repeat(3, 1fr);
        grid-template-rows: 1fr;
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "sub rowMarks rowMarks name";
    }

    .row1 {
        grid-area: row1;
    }

    .row2 {
        grid-area: row2;
    }

    .row3 {
        grid-area: row3;
    }

    .row4 {
        grid-area: row4;
    }

    .row5 {
        grid-area: row5;
    }

    .row6 {
        grid-area: row6;
    }

    .row7 {
        grid-area: row7;
    }

    .row8 {
        grid-area: row8;
    }

    .row9 {
        grid-area: row9;
    }

    .row10 {
        grid-area: row10;
    }

    .row11 {
        grid-area: row11;
    }

    .row12 {
        grid-area: row12;
    }

    .name {
        grid-area: name;
    }

    .rowMarks {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        grid-template-rows: 1fr;
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "mark7 mark6 mark5 mark4 mark3 mark2 mark1 mark0";
        grid-area: rowMarks;
    }

    .mark0 {
        grid-area: mark0;
    }

    .mark1 {
        grid-area: mark1;
    }

    .mark2 {
        grid-area: mark2;
    }

    .mark3 {
        grid-area: mark3;
    }

    .mark4 {
        grid-area: mark4;
    }

    .mark5 {
        grid-area: mark5;
    }

    .mark6 {
        grid-area: mark6;
    }

    .mark7 {
        grid-area: mark7;
    }

    .fasel1,
    .fasel2,
    .empty,
    .name,
    .sub {
        outline: 1px solid var(--md-sys-color-on-surface-variant-dark);
        border-radius: 4px;
        align-items: center;
        display: grid;
    }

    [class*="fasel"] *:not([class*="cont"]) {
        padding: calc(56px / 4) 4px;
        border: 1px solid var(--md-sys-color-on-surface-variant-dark)
    }

    [class*="fasel"] *:not([class*="cont"]),
    .marks md-outlined-text-field {
        min-width: 60px;
    }

    .cont2 {
        grid-area: cont2;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: 0.5fr;
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "final2 quiz2 hm2 sh2";
        border: none;
    }

    .cont1 {

        grid-area: cont1;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: 0.5fr;
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "final1 quiz1 hm1 sh1";
        border: none;
    }

    .sub {
        grid-area: sub;
    }

    input {
        text-align: center;
    }
</style>