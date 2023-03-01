<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>动臂塔机吊臂头部侧向等效载荷计算</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/bootstrap-icons/1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.staticfile.org/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container p-1 my-1">
        <h1 class="text-center bi-gear-wide-connected"> 动臂塔机吊臂头部侧向等效载荷计算</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="needs-validation"
            novalidate>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="l">吊臂长度(m):</label>
                        <input type="text" class="form-control" id="l" placeholder="输入吊臂长度" name="l" required>
                        <div class="invalid-feedback">请输入吊臂长度！</div>
                    </div>
                    <div class="form-group">
                        <label for="b">吊臂宽度(m):</label>
                        <input type="text" class="form-control" id="b" placeholder="输入吊臂宽度" name="b" required>
                        <div class="invalid-feedback">请输入吊臂宽度！</div>
                    </div>
                    <div class="form-group">
                        <label for="e">吊臂充实率:</label>
                        <input type="text" class="form-control" id="e" placeholder="输入吊臂充实率" name="e" value="0.3"
                            required>
                        <div class="invalid-feedback">请输入吊臂充实率！</div>
                    </div>
                    <div class="form-group">
                        <label for="gb">吊臂自重(t):</label>
                        <input type="text" class="form-control" id="gb" placeholder="输入吊臂自重" name="gb" required>
                        <div class="invalid-feedback">请输入吊臂自重！</div>
                    </div>
                    <div class="form-group">
                        <label for="g">吊物重量(t):</label>
                        <input type="text" class="form-control" id="g" placeholder="输入吊物重量" name="g" required>
                        <div class="invalid-feedback">请输入吊物重量！</div>
                    </div>
                    <div class="form-group">
                        <label for="r">幅度:</label>
                        <input type="text" class="form-control" id="r" placeholder="输入幅度" name="r" required>
                        <div class="invalid-feedback">请输入幅度！</div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="gg">钩头含绳重量(t):</label>
                        <input type="text" class="form-control" id="gg" placeholder="输入钩头含绳重量" name="gg" required>
                        <div class="invalid-feedback">请输入钩头含绳重量！</div>
                    </div>
                    <div class="form-group">
                        <label for="tg">吊物偏摆角度(0.05-0.1):</label>
                        <input type="text" class="form-control" id="tg" placeholder="输入吊物偏摆角度" name="tg" value="0.05"
                            required>
                        <div class="invalid-feedback">请输入吊物偏摆角度！</div>
                    </div>
                    <div class="form-group">
                        <label for="p">工作状态计算风压(Pa):</label>
                        <input type="text" class="form-control" id="p" placeholder="输入工作状态计算风压" name="p" value="250"
                            required>
                        <div class="invalid-feedback">请输入工作状态计算风压！</div>
                    </div>
                    <div class="form-group">
                        <label for="n">回转速度(rpm):</label>
                        <input type="text" class="form-control" id="n" placeholder="输入回转速度" name="n" value="0.6"
                            required>
                        <div class="invalid-feedback">请输入回转速度！</div>
                    </div>
                    <div class="form-group">
                        <label for="t">回转制动时间(s):</label>
                        <input type="text" class="form-control" id="t" placeholder="输入回转制动时间" name="t" value="4"
                            required>
                        <div class="invalid-feedback">请输入回转制动时间！</div>
                    </div>

                </div>
            </div>
            <div class="row mt-3">
                <div class="d-grid col-3 mx-auto">
                    <button type="submit" class="btn btn-primary btn-lg bi-calculator">计算</button>
                </div>
            </div>
            <!--<div class="cl"></div>-->
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $l = $_POST["l"];
        $b = $_POST["b"];
        $e = $_POST["e"];
        $gb = $_POST["gb"];
        $g = $_POST["g"];
        $r = $_POST["r"];
        $gg = $_POST["gg"];
        $tg = $_POST["tg"];
        $p = $_POST["p"];
        $n = $_POST["n"];
        $t = $_POST["t"];
        if ($l * $b * $e * $gb * $g * $r * $gg * $tg * $p * $n * $t == 0) {
            echo "请检查输入数据<br>";
            die();
        }
        echo '<div class="alert alert-success">';
        #货物产生的偏摆力
        $huo = $tg * ($g + $gg);
        echo '货物产生的偏摆力:'.round($huo,2).'t<br>';
        #风载
        $wind = $e * $l * $b * (1+0.59) * 1.2 * $p / 9800;
        echo '吊臂所受侧向风载:'.round($wind,2).'t<br>';
        #吊臂切向惯性载荷
        $db = $gb * 1000 * 2 * 3.14 * $n * ($r * 0.55) / (60 * $t * 10000);
        echo '吊臂切向惯性力:'.round($db,2).'t<br>';      
        #吊臂头部等效侧向力
        $f = $huo + 0.55 * ($wind + $db);
        echo '<strong>吊臂头部等效水平合力:'.round($f,2).'t</strong>';
        echo '</div>';
    }
    ?>
    </div>
    <!--container-->
</body>

</html>