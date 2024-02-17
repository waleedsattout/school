<script src="<?php echo base_url('public/assets/js/bootstrap.js', env('protocol')) ?>"></script>
<script src="<?php echo base_url('public/assets/js/jquery.js', env('protocol')) ?>"></script>
<script src="<?php echo base_url('public/assets/js/modal.js', env('protocol')) ?>"></script>
<script src="<?php echo base_url('public/assets/js/main.js', env('protocol')) ?>"></script>
<script src="<?php echo base_url('public/assets/js/script.js', env('protocol')) ?>"></script>
<?php
helper('jwt');
if ($page_name != 'login') : ?>
<?php
    helper('jwt_helper');
    getData();
else : ?>
    <datalist id="students"></datalist>
    <datalist id="classes"></datalist>
    <datalist id="sections"></datalist>
    <datalist id="subjects"></datalist>
<?php endif; ?>
<?php if (session()->getFlashdata('error') != '') : ?>
    <script>
        app.fireAlert('error', '<?php echo session()->getFlashdata("error"); ?>');
    </script>
<?php elseif (session()->getFlashdata('success') != '') : ?>
    <script>
        app.fireAlert('success', '<?php echo session()->getFlashdata("success"); ?>');
    </script>
<?php endif; ?>

<?php if (session()->getTempdata('jwt')) : ?>
    <script id='rm'>
        app.secret = <?php echo session()->getTempdata('jwt') ?>;
        localStorage.removeItem('jwt');
        window.localStorage.setItem('jwt', app.secret.jwt);
        app.secret = '';
        document.getElementById('rm').remove();
    </script>
<?php endif; ?>
<?php if ($page_name == 'certificate' || $page_name == "sum") : ?>
    <div id="fab" style="
    position: fixed;
    bottom: 8px;
    right: 16px;
    text-align: center;
    vertical-align: middle;
    height:<?php if ($page_name != "certificate")
                echo "56px";
            else
                echo "112px"; ?>;
    border-radius: 16px;
    cursor:pointer;
    display: flex;
    min-width: 80px;
    box-shadow: var(--md-sys-elevation-3);
    align-items: center;
    flex-direction: column;
    " class="d-print-none primary on-primary-text m-0">
        <?php if ($page_name == "certificate") : ?>
            <div class="d-print-none primary on-primary-text m-0" style="
            width: 100%;
            height: 100%;
            align-items: center;
            display: flex;
            border-bottom: 1px solid rgba(253 253 253 / .5);
            border-radius: 8px 8px 0 0;" onclick="app.deleteFasel2()">
                <p class="d-inline" style="padding: 12px;font-weight: 500;margin: 0;font-size: 14px;width: 100%;"><?php echo lang('General.delete') . ' ' . lang('General.secondSem') ?></p>

            </div>
        <?php endif; ?>
        <div class="d-print-none primary on-primary-text m-0" style="height: 100%;align-items: center;display: flex;border-radius:<?php if ($page_name != "certificate") echo "8px";
                                                                                                                                    else echo "0 0 8px 8px"; ?>;" onclick="myPrint()">
            <p class="d-inline" style="padding: 12px;font-weight: 500;margin: 0;font-size: 14px;"></p>
            <i class="bi bi-printer" style="font-size: 24px;padding: 10px 0 10px 10px;"></i>
        </div>
    </div>
<?php endif; ?>

<script>
    ;
    (function() {
        var src = '//cdn.jsdelivr.net/npm/eruda';
        if (!/eruda=true/.test(window.location) && localStorage.getItem('active-eruda') != 'true') return;
        document.write('<scr' + 'ipt src="' + src + '"></scr' + 'ipt>');
        document.write('<scr' + 'ipt>eruda.init();</scr' + 'ipt>');
    })();
</script>