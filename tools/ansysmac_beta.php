<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ANSYS计算宏生成助手</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.staticfile.org/bootstrap-icons/1.10.3/font/bootstrap-icons.css" />
    <script src="https://cdn.staticfile.org/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/5.1.1/js/bootstrap.min.js"></script>
    <?php
$macname = strval(isset($_POST['macname'])? $_POST['macname'] : '');//宏文件名
if($macname){
}else{
?>
    <script src="/js/ansysmac_beta.js"></script>
    <?php
}
?>

</head>

<body>
    <div class="container-sm p-3">
        <h1 class="text-center bi-gear-wide-connected p-3">ANSYS计算宏生成助手</h1>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>说明</strong>
            <ul>
                <li>宏名称使用英文字母开头，由字母和数字组成，长度不超过10位</li>
                <li>
                    需要对模型中组件截图时，应提前在模型中设置好line组件，且名称以‘CP+数字编号’的形式从CP1到CP8，最多支持设置8个组件，截图保存的顺序是先整体后组件</li>
                <li>加载点从第四象限开始逆时针依次填入</li>
                <li>8工况条件下可生成python脚本辅助汇总结果</li>
                <li>一点加载360工况条件下可生成python脚本辅助生成反力曲线图</li>
                <li>Z+为竖直向上，Y-为工况1，其余工况逆时针排列</li>
                <li>边界约束、重力加速度以及大变形等前处理部分需提前在ANSYS中设置，本程序涉及的步骤为加载求解和后处理</li>
            </ul>
        </div>
        <?php
include_once('common.php');
include_once('main_part.php');
if($macname){include_once('output_part.php');} 
else{//如果没有点击提交按钮，则macname参数是空值，则显示表单截面
	//form表单提交数据是name标签
?>
        <form action="" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="macname" name="macname" placeholder="输入宏名称">
                <label for="macname">宏名称</label>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="form-check">
                        <input name="loadkpnum" class="form-check-input" type="radio" id="load1" value="1">
                        <label class="form-check-label" for="load1">1点加载</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input name="loadkpnum" class="form-check-input" type="radio" id="load4" value="4" checked>
                        <label class="form-check-label" for="load4">4点加载</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="sel1" name="ysnum">
                    <option value="2" selected>2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
                <label for="sel1" class="form-label">约束点数量</label>
            </div>
            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="form-check">
                        <input name="casenum" class="form-check-input" type="radio" id="case8" value="8" checked>
                        <label class="form-check-label" for="case8">8工况</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check">
                        <input name="casenum" class="form-check-input" type="radio" id="ca360" value="360">
                        <label class="form-check-label" for="ca360">360工况</label>
                    </div>
                </div>
            </div>


            <label class="form-label mb-3">加载点编号:</label>
            <div class="row">
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="kp1">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="kp2">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="kp3">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="kp4">
                </div>
            </div>

            <label class="form-label mb-3">约束点编号:</label>
            <div class="row">
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node1">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node2">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node3">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node4">
                </div>
            </div>
            <div class="row">
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node5">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node6">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node7">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="node8">
                </div>
            </div>


            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="fix" name="fix" value="1">
                <label class="form-check-label text-nowrap" for="fix">节点是否约束了旋转</label>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text">垂直力</span>
                <input type="text" class="form-control" placeholder="" name="fv">
                <span class="input-group-text">t</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">水平力</span>
                <input type="text" class="form-control" placeholder="" name="fs">
                <span class="input-group-text">t</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">弯矩</span>
                <input type="text" class="form-control" placeholder="" name="m">
                <span class="input-group-text">t.m</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">扭矩</span>
                <input type="text" class="form-control" placeholder="" name="mk">
                <span class="input-group-text">t.m</span>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">扭矩力</span>
                <input type="text" class="form-control" placeholder="" name="fmk">
                <span class="input-group-text">t</span>
            </div>
            <div class="row">
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="rf" name="rf" value="1" checked>
                        <label class="form-check-label text-nowrap" for="rf">提取节点反力</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="rm" name="rm" value="1">
                        <label class="form-check-label text-nowrap" for="rm">提取节点反弯矩</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="af" name="af" value="1">
                        <label class="form-check-label text-nowrap" for="af">提取杆件轴力</label>
                    </div>
                </div>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select" id="sel2" name="afnum">
                    <option value="0" selected>0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
                <label for="sel2" class="form-label">杆件数量</label>
            </div>


            <label class="form-label mb-3">杆件编号:</label>
            <div class="row">
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem1">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem2">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem3">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem4">
                </div>
            </div>
            <div class="row">
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem5">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem6">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem7">
                </div>
                <div class="col-sm mb-3">
                    <input type="text" class="form-control" name="elem8">
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="dfx" name="dfx" value="1">
                        <label class="form-check-label text-nowrap" for="dfx">输出整体X向位移云图</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="dfy" name="dfy" value="1">
                        <label class="form-check-label text-nowrap" for="dfy">输出整体y向位移云图</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="dfz" name="dfz" value="1">
                        <label class="form-check-label text-nowrap" for="dfz">输出整体z向位移云图</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="dftotal" name="dftotal" value="1">
                        <label class="form-check-label text-nowrap" for="dftotal">输出整体合位移云图</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="stotal" name="stotal" value="1">
                        <label class="form-check-label text-nowrap" for="stotal">输出整体合应力云图</label>
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3">
                <select class="form-select" id="sel3" name="cpnum">
                    <option value="0" selected>0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
                <label for="sel3" class="form-label">组件CP数量</label>
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="cpnx" name="cpnx" value="1">
                        <label class="form-check-label text-nowrap" for="cpnx">输出组件CPN X向位移</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="cpny" name="cpny" value="1">
                        <label class="form-check-label text-nowrap" for="cpny">输出组件CPN y向位移</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="cpnz" name="cpnz" value="1">
                        <label class="form-check-label text-nowrap" for="cpnz">输出组件CPN z向位移</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="cpnt" name="cpnt" value="1">
                        <label class="form-check-label text-nowrap" for="cpnt">输出组件CPN 合位移</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="cpnst" name="cpnst" value="1">
                        <label class="form-check-label text-nowrap" for="cpnst">输出组件CPN 合应力</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="d-grid col mx-auto">
                    <button type="button" class="btn btn-danger btn-lg text-nowrap"
                        onclick="javascript:location.reload()">重置页面</button>
                </div>
                <div class="d-grid col mx-auto">
                    <button type="submit" class="btn btn-primary btn-lg text-nowrap">生成脚本</button>
                </div>
            </div>

        </form>
        <?php
}
?>
    </div>
    <!--end of container-->

</body>

</html>