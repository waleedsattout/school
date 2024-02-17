<!DOCTYPE html>

<head>
    <?php include 'top.php'; ?>
    <?php include 'header.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo lang('General.pleaseWait')?>
    </title>

</head>

<body class="background">
    <div class="d-flex" style="margin-top:130px">
        <div class="w-50 p-5 m-auto mt-0">
            <div class="alert tertiary-container pill  on-tertiary-container-text">
                <p class="p-2">
                    <?php echo lang('General.pleaseWait')?>
                    ...
                </p>
                <hr>
                <div class="tertiary on-tertiary-text py-3 px-2" style="border-radius: 12px;">
                    <ul id="result"></ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        let loop = ['database']
        setTimeout(() => { loop.forEach((e) => send(e)) }, 3000);
        function send(e) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', `/migrate/${e}`, true);
            xhr.onreadystatechange = function () {
                if (this.readyState !== 4) return;
                if (this.status !== 200) return;
                document.getElementById('result').innerHTML += this.responseText;
            };
            xhr.send();
        }
    </script>
    <?php
    include 'footer.php';
    include 'bottom.php';
    ?>
</body>