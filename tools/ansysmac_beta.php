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
    <script src="/js/ansysmac.js"></script>
    <?php
}
?>
    <!--<link rel="stylesheet" type="text/css" href="/css/ansysmac.css">-->
</head>

<body>
    <div class="container-sm p-3">
        <h1 class="text-center bi-gear-wide-connected p-3">ANSYS计算宏生成助手</h1>
        <?php
include_once('common.php');
include_once('main_part.php');
if($macname){nclude_once('output_part.php');} 
else{//如果没有点击提交按钮，则macname参数是空值，则显示表单截面
?>
        <form action="" method="post">
            宏名称:<input type="text" name="macname" value="macname" id="macname">
            加载点数量:
            <input name="loadkpnum" type="radio" id="load1" value="1" checked>1
            <input name="loadkpnum" type="radio" id="load4" value="4">4
            约束点数量:
            <select name="ysnum">
                <option value="2" selected>2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            工况数量:
            <input type="radio" checked name="casenum" value="8" id="case8">8
            <input type="radio" name="casenum" value="360" id="ca360">360


            加载点关键点编号:
            <input name="kp1" type="text" value="1">
            <input name="kp2" type="text" class="kp4" value="2">
            <input name="kp3" type="text" class="kp4" value="3">
            <input name="kp4" type="text" class="kp4" value="4">
            约束点node编号:
            <input type="text" name="node1" value="1">
            <input type="text" name="node2" value="2">
            <input type="text" name="node3" class="node" value="3">
            <input type="text" name="node4" class="node" value="4">
            <input type="text" name="node5" class="node" value="5">
            <input type="text" name="node6" class="node" value="6">
            <input type="text" name="node7" class="node" value="7">
            <input type="text" name="node8" class="node" value="8">
            <input type="checkbox" name="fix" value="1">约束旋转



            载荷
            <input type="checkbox" name="ckfv" value="1">垂直力<input type="text" name="fv" value="0" disabled>t
            <input type="checkbox" name="ckfs" value="1">水平力<input type="text" name="fs" value="0" disabled>t
            <input type="checkbox" name="ckm" value="1">弯矩<input type="text" name="m" value="0" disabled>t.m
            <input type="checkbox" name="ckmk" value="1">扭矩<input type="text" name="mk" value="0" disabled>t.m
            <input type="checkbox" name="ckfmk" value="1">扭矩力<input type="text" name="fmk" value="0" disabled>t

            输出结果和截图
            <input type="checkbox" checked name="rf" value="1">反力
            <input type="checkbox" name="rm" value="1">反弯矩
            <input type="checkbox" name="af" value="1">杆轴力
            数量
            <select name="afnum">
                <option value="1" selected>1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            杆件elem编号:
            <input type="text" name="elem1" value="1">
            <input type="text" name="elem2" class="elem" value="2">
            <input type="text" name="elem3" class="elem" value="3">
            <input type="text" name="elem4" class="elem" value="4">
            <input type="text" name="elem5" class="elem" value="5">
            <input type="text" name="elem6" class="elem" value="6">
            <input type="text" name="elem7" class="elem" value="7">
            <input type="text" name="elem8" class="elem" value="8">

            <input type="checkbox" name="dfx" value="1">整体X向位移
            <input type="checkbox" name="dfy" value="1">整体y向位移
            <input type="checkbox" name="dfz" value="1">整体z向位移
            <input type="checkbox" name="dftotal" value="1">整体合位移
            <input type="checkbox" name="stotal" value="1">整体合应力

            组件CP数量
            <select name="cpnum">
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

            <input type="checkbox" name="cpnx" value="1">组件CPN X向位移
            <input type="checkbox" name="cpny" value="1">组件CPN y向位移
            <input type="checkbox" name="cpnz" value="1">组件CPN z向位移
            <input type="checkbox" name="cpnt" value="1">组件CPN 合位移
            <input type="checkbox" name="cpnst" value="1">组件CPN 合应力

            说明
            <ol>
                <li>宏名称使用英文字母开头，由字母和数字组成，长度不超过10位</li>
                <li>需要对模型中组件截图时，应提前在模型中设置好line组件，且名称以‘CP+数字编号’的形式从CP1到CP8，最多支持设置8个组件，截图保存的顺序是先整体后组件</li>
                <li>加载点从第四象限开始逆时针依次填入</li>
                <li>8工况条件下可生成python脚本辅助汇总结果</li>
                <li>一点加载360工况条件下可生成python脚本辅助生成反力曲线图</li>
                <li>Z+为竖直向上，Y-为工况1，其余工况逆时针排列</li>
                <li>边界约束、重力加速度以及大变形等前处理部分需提前在ANSYS中设置，本程序涉及的步骤为加载求解和后处理</li>
            </ol>
            <input type="submit" value="生成脚本">
            <button type="button" onclick="javascript:location.reload()">重置页面</button>

        </form>
        <?php
}
?>
    </div>
    <!--end of container-->

</body>

</html>