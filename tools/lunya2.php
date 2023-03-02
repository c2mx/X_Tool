<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>行走/底架-最大支反力计算</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/bootstrap-icons/1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.staticfile.org/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container p-1 my-1">
        <h1 class="text-center bi-gear-wide-connected"> 行走/底架-最大支反力计算</h1>
        <?php
$lunju = floatval(isset($_POST['lunju'])? $_POST['lunju'] : '0');
$guiju = floatval(isset($_POST['guiju'])? $_POST['guiju'] : '0');
$wm = floatval(isset($_POST['wm'])? $_POST['wm'] : '0');
$nwm = floatval(isset($_POST['nwm'])? $_POST['nwm'] : '0');
$tg = floatval(isset($_POST['tg'])? $_POST['tg'] : '0');
$xzg = floatval(isset($_POST['xzg'])? $_POST['xzg'] : '0');
$gmax = floatval(isset($_POST['gmax'])? $_POST['gmax'] : '0');

if($lunju * $guiju > 0){

$l = $lunju * $guiju / sqrt(pow($guiju,2)+pow($lunju,2));
$fwmax = round(($tg + $xzg + $gmax) /4 + $wm / (2 * $l),2);
$fwmin = round(($tg + $xzg + $gmax) /4 - $wm / (2 * $l),2);
$mst = round(($tg + $xzg + $gmax) * min($lunju,$guiju) / 2,2);
$ws = round($mst / $wm,2);
$fnwmax = round(($tg + $xzg) /4 + $nwm / (2 * $l),2);
$fnwmin = round(($tg + $xzg) /4 - $nwm / (2 * $l),2);
$mnst = round(($tg + $xzg) * min($lunju,$guiju) / 2,2);
$nws = round($mnst / $nwm,2);
$fmax = round(max($fwmax,$fnwmax),2);
$fmin = round(min($fwmin,$fnwmin),2);
echo <<<EOF
<div class="row">
<div class="col">
<div class="alert alert-info">
<p>轮距：$lunju m</p>
<p>轨距：$guiju m</p>
<p>工作弯矩：$wm t.m</p>
<p>非工作弯矩：$nwm t.m</p>
<p>塔机自重：$tg t</p>
<p>行走机构自重：$xzg t</p>
<p>最大吊重：$gmax t</p>
</div>
</div>
<div class="col">
<div class="alert alert-success">
<p>工作状态最大轮压为$fwmax t</p>
<p>工作状态最小轮压为$fwmin t</p>
<p>工作状态稳定力矩为$mst t.m，稳定系数$ws</p>
<p>非工作状态最大轮压为$fnwmax t</p>
<p>非工作状态最小轮压为$fnwmin t</p>
<p>非工作状态稳定力矩为$mnst t.m，稳定系数$nws</p>
<p><strong>综合工作和非工作：最大轮压为$fmax t,最小轮压为$fmin t</strong></p>
</div>
</div>
</div>
EOF;
} else {
?>
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="t">轮距(m):</label>
                        <input type="text" class="form-control" id="lunju" placeholder="输入轮距" name="lunju" required>
                        <div class="invalid-feedback">请输入轮距！</div>
                    </div>
                    <div class="form-group">
                        <label for="t">轨距(m):</label>
                        <input type="text" class="form-control" id="guiju" placeholder="输入轨距" name="guiju" required>
                        <div class="invalid-feedback">请输入轨距！</div>
                    </div>
                    <div class="form-group">
                        <label for="t">工作弯矩(t.m):</label>
                        <input type="text" class="form-control" id="wm" placeholder="输入工作弯矩" name="wm" required>
                        <div class="invalid-feedback">请输入工作弯矩！</div>
                    </div>
                    <div class="form-group">
                        <label for="t">非工作弯矩(s):</label>
                        <input type="text" class="form-control" id="nwm" placeholder="输入非工作弯矩" name="nwm" required>
                        <div class="invalid-feedback">请输入非工作弯矩！</div>
                    </div>
                    <div class="form-group">
                        <label for="t">塔机自重(t):</label>
                        <input type="text" class="form-control" id="tg" placeholder="输入塔机自重" name="tg" required>
                        <div class="invalid-feedback">请输入塔机自重！</div>
                    </div>
                    <div class="form-group">
                        <label for="t">行走机构自重(t):</label>
                        <input type="text" class="form-control" id="xzg" placeholder="输入行走机构自重" name="xzg" required>
                        <div class="invalid-feedback">请输入行走机构自重！</div>
                    </div>
                    <div class="form-group">
                        <label for="t">最大吊重(t):</label>
                        <input type="text" class="form-control" id="gmax" placeholder="输入最大吊重" name="gmax" required>
                        <div class="invalid-feedback">请输入最大吊重！</div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="d-grid col-3 mx-auto">
                    <button type="submit" class="btn btn-primary btn-lg bi-calculator">计算</button>
                </div>
            </div>
        </form>
        <script>
        // 如果验证不通过禁止提交表单
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // 获取表单验证样式
                var forms = document.getElementsByClassName('needs-validation');
                // 循环并禁止提交
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        </script>
        <?php
}
?>
    </div>
    <!--main-->

</body>

</html>