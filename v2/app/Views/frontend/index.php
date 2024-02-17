<!DOCTYPE html>
<html lang="<?= $locale ?>">
<head>
    <?php include 'top.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link name="favicon" type="image/x-icon" href="<?php echo base_url('public/favicon.ico', env('protocol')) ?>" rel="icon" />
    <title>
        <?php echo $title ?>
    </title>

</head>

<body>
    <script id="hide" src="<?php echo base_url('public/assets/js/app.js', env('protocol')) ?>?v=<?php echo time(); ?>"></script>
    <?php
    if ($page_name != null) {
        if ($page_name == 'login') {
            include $page_name . '.php';
        } else {
            include 'header.php';
            echo '<div id="cont">';
            include $page_name . '.php';
            echo '</div>';
        }
        include 'footer.php';
        include 'bottom.php';
    } else if (!empty($page_name)) {
    }
    ?>
</body>

</html>