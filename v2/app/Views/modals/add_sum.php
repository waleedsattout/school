<?php
if ($sem == 'الأول')
    $index = 0;
else if ($sem == 'الثاني')
    $index = 1;
?>
<p class="p-4">
    <?php echo lang('Subjects.subjectMirror') . '<br>' . $subject ?> <br>
    <?php echo lang('Classes.class') ?>
    <?php echo $class ?> <br>
    <?php echo lang('General.section') ?>
    <?php echo $section ?> <br>
    <?php echo lang('General.semester') ?>
    <?php echo $sem ?>
</p>
<div class="content" style="direction:rtl;text-align:right;padding: 1.5rem;margin: 0 3.5rem;">
    <form class="needs-validation" novalidate="" onSubmit="return false;">
        <div class="row g-3">
            <div class="d-flex justify-content-around">
                <div class="col-2 d-flex" style="align-items: end;">
                    <p style="white-space:nowrap"><?php echo lang('Students.studentName') ?>: </p>
                </div>
                <div class="col-2 text-center">
                    <label class="form-label"><?php echo lang('General.verbal') ?></label>
                </div>
                <div class="col-2 text-center">
                    <label class="form-label"><?php echo lang('General.assignments') ?></label>
                </div>
                <div class="col-2 text-center">
                    <label class="form-label"><?php echo lang('General.Revision') ?></label>
                </div>
                <div class="col-2 text-center">
                    <label class="form-label"><?php echo lang('General.Exam') ?></label>
                </div>
            </div>

            <?php $i = 0;
            foreach ($data as $key => $data1) : ?>
                <?php
                $marks = $data1['marks'];
                $marks1 = explode(',', explode('-', $marks)[$index]);
                ?>
                <div id="r-<?php echo $i ?>" class="d-flex justify-content-around">
                    <div class="col-3 d-flex" style="align-self: center;">
                        <p class="m-0" std="<?php echo $data1['id']; ?>" style="white-space:nowrap">
                            <?php echo $data1['name'] ?>
                        </p>
                    </div>
                    <div class="col-2">
                        <input type="number" step="1" min="0" max="<?php echo ($max * 0.25); ?>" class="form-control" name="sh1" id="sh1" value="<?php echo $marks1[0] ?>" required="">
                    </div>
                    <div class="col-2">
                        <input type="number" step="1" min="0" max="<?php echo ($max * 0.25); ?>" class="form-control" name="hom1" id="hom1" value="<?php echo $marks1[1] ?>" required="">
                        <div class="invalid-feedback">
                            <?php echo lang('General.minMaxMarkWarning') . ' ' . ($max * 0.25); ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <input type="number" step="1" min="0" max="<?php echo ($max * 0.5); ?>" class="form-control" name="test1" id="test1" value="<?php echo $marks1[2] ?>" required="">
                        <div class="invalid-feedback"><?php echo lang('General.minMaxMarkWarning') . ' ' . ($max * 0.5); ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <input type="number" step="1" min="0" max="<?php echo ($max); ?>" class="form-control" id="fin1" name="fin1" value="<?php echo $marks1[3] ?>" required="">
                        <div class="invalid-feedback"><?php echo lang('General.minMaxMarkWarning') . ' ' . ($max); ?>
                        </div>
                    </div>
                </div>
            <?php $i++;
            endforeach; ?>
        </div>
        <button id="rows" rows="<?php echo count($data) ?>" class="btn btn-primary btn-lg mt-4" onClick="collect_data()" style="display: block;margin: auto;"><?php echo lang('General.send') ?></button>
    </form>
</div>